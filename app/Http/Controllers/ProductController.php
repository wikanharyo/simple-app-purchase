<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepositoryInterface;

class ProductController extends Controller
{
    private $repository;
    private $code;
    private $notFound;
    public function __construct(ProductRepositoryInterface $productReopsitory)
    {
        $this->repository = $productReopsitory;
        $this->code = 200;
        $this->notFound = 'Product not found';
    }

    public function store(CreateProductRequest $request)
    {
        $created = $this->repository->store($request);

        return response()->json([
            'result' => true,
            'message' => 'Product successfully created',
            'data' => $created
        ], 201);
    }

    public function index()
    {
        $products = $this->repository->index();
        return response()->json([
            'result' => true,
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = $this->repository->show($id);
        if (!$product) {
            $product = 'Product not found';
            $this->code = 400;
        }
        return response()->json([
            'result' => true,
            'data' => $product,
        ]);
    }

    public function delete($id)
    {
        $delete = $this->repository->delete($id);
        if ($delete) {
            $message = 'Product succesfully deleted';
        } else {
            $message = 'Product not found';
            $this->code = 400;
        }
        return response()->json(['message' => $message], $this->code);
    }

    public function update(UpdateProductRequest $request)
    {
        $update = $this->repository->update($request);

        if ($update) {
            $message = 'Product succesfully updated';
        } else {
            $message = 'Update product failed';
            $this->code = 400;
        }
        return response()->json(['message' => $message], $this->code);
    }
}
