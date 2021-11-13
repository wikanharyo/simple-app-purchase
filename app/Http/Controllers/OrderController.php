<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Repositories\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $repository;
    private $timeStamp;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->timeStamp = Carbon::now();
        $this->repository = $orderRepository;
    }
    public function store(CreateOrderRequest $request)
    {
        $order = $this->repository->store($request, $this->timeStamp);
        if ($order !== []) {
            return response()->json([
                'result' => true,
                'data' => $order
            ]);
        }
    }

    public function show($id)
    {
        $order = $this->repository->show($id);
        return response()->json($order, $order['result'] ? 200 : 400);
    }

    public function checkout($id)
    {
        $checkout = $this->repository->checkout($id, $this->timeStamp);
        return response()->json($checkout, $checkout['result'] ? 200 : 400);
    }

    public function cancel($id)
    {
        $cancelled = $this->repository->cancel($id, $this->timeStamp);
        return response()->json($cancelled, $cancelled['result'] ? 200 : 400);
    }
}
