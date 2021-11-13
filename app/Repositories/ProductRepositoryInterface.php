<?php

namespace App\Repositories;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

interface ProductRepositoryInterface
{
    public function store(CreateProductRequest $request);

    public function index();

    public function update(UpdateProductRequest $request);

    public function show($id);

    public function delete($id);
}
