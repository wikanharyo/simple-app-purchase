<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function store($request)
    {
        $product = Product::create($request->all());
        return $product;
    }

    public function index()
    {
        return Product::all();
    }

    public function show($id)
    {
        return Product::find($id);
    }

    public function delete($id)
    {
        try {
            return Product::find($id)->delete();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function update($request)
    {
        try {
            return Product::find($request->id)->update($request->only(['stock', 'price']));
        } catch (\Throwable $th) {
            return false;
        }
    }
}
