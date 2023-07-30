<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository
{
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('id', 'ASC')->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function show($id)
    {
        $product = $this->model->where('id', $id)->first();
        return $product ? $product : $product = null;
    }

    public function update(array $data, $id)
    {
        $product = Product::find($id);
        $product->update($data);
        return $product;
    }

    public function destroy($id)
    {
        $product = $this->model->find($id);
        return $product ? $product->delete() : null;
    }
}
