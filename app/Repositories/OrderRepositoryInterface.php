<?php

namespace App\Repositories;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateProductRequest;

interface OrderRepositoryInterface
{
    public function store(CreateOrderRequest $request, $timeStamp);

    public function checkout($id, $timeStamp);

    public function cancel($id, $timeStamp);

    public function show($id);
}
