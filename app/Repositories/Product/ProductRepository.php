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
        return $this->model
                    ->with('category')
                    ->orderBy('name', 'ASC')
                    ->get()
                    ->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'category_name' => $product->category->name,
                            'description' => $product->description,
                            'price' => $product->price,
                            'image' => $product->image
                        ];
                    });
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function show($id)
    {
        $product = $this->model
                    ->with('category')
                    ->where('id', $id)
                    ->first();

        if (!$product) {
            return null; // Return null if product not found
        }

        $categoryName = $product->category ? $product->category->name : null;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'category_name' => $categoryName,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image
        ];
    }

    public function update(array $data, $id)
    {
        $product = Product::where('id', $id)->first();
        $product->update($data);
        return $product;
    }

    public function destroy($id)
    {
        $product = $this->model->find($id);
        return $product ? $product->delete() : null;
    }
}
