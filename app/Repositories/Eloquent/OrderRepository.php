<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\OrderRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function store($request, $timeStamp)
    {
        DB::beginTransaction();
        $order = Order::create(['customer_id' => (int) $request->customer_id, 'order_status' => 1]);
        $orderDetailPayload = collect($request->order_detail)->map(function ($data) use ($order, $timeStamp) {
            $data['order_id'] = $order->id;
            $data['created_at'] = $timeStamp;
            $data['updated_at'] = $timeStamp;
            return $data;
        });
        $order->total_price = $orderDetailPayload->sum('price');
        $order->save();
        $orderDetail = OrderDetail::insert($orderDetailPayload->toArray());
        if ($order && $orderDetail) {
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
            $data = $order->toArray();
            $data['order_detail'] = $orderDetails->toArray();
            return [
                'result' => true,
                'data' => $data
            ];
            DB::commit();
        } else {
            return [
                'result' => false,
                'data' => [],
            ];
            DB::rollBack();
        }
    }

    public function show($id)
    {
        try {
            $order = OrderDetail::with('product')->where('order_id', $id)->get();
            $result = [
                'result' => true,
                'message' => '',
                'data' => $order
            ];
        } catch (\Throwable $th) {
            $result = [
                'result' => false,
                'message' => $th->getMessage(),
                'data' => []
            ];
        }

        return $result;
    }

    public function checkout($id, $timeStamp)
    {
        DB::beginTransaction();

        try {
            $orderDetails = OrderDetail::with('product')->where('order_id', $id)->lockForUpdate()->get();
            $order = Order::find($id);
            if ($order->order_status !== 1) {
                throw new Exception('Expired product order');
            }
            $success = true;
            foreach ($orderDetails as $k => $detail) {
                $product = $detail->product()->first();
                if ($detail->quantity <= $product->stock) {
                    $product->stock -= $detail->quantity;
                    $product->save();
                } else {
                    $success = false;
                    break;
                }
            }
            if ($success) {
                $order->order_status = 2;
                $result = [
                    'result' => true,
                    'message' => 'Checkout succeed'
                ];
            } else {
                $result = [
                    'result' => false,
                    'message' => 'Checkout failed, product out of stock'
                ];
                $order->order_status = 3;
            }
            $order->updated_at = $timeStamp;
            $order->save();
            DB::commit();
            $result['data'] = $orderDetails->toArray();
        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                'result' => false,
                'message' => $th->getMessage(),
                'data' => []
            ];
        }
        return $result;
    }

    public function cancel($id, $timeStamp)
    {
        try {
            $cancelled = Order::find($id);
            if ($cancelled->order_status !== 1) {
                throw new Exception('Expired product order');
            }
            $cancelled->order_status = 3;
            $cancelled->updated_at = $timeStamp;
            $cancelled->save();
            $result = [
                'result' => true,
                'message' => 'Cancel order succeed',
                'data' => $cancelled->toArray()
            ];
        } catch (\Throwable $th) {
            $result = [
                'result' => false,
                'message' => $th->getMessage(),
                'data' => []
            ];
        }
        return $result;
    }
}
