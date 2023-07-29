<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Product\ProductRepository;

class ProductRepositoryImplement implements ProductRepository
{
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('name', 'ASC')->get();
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

    public function update($id, array $data)
    {
        $product = Product::find($id);
        if ($product) {
            if (isset($data['image'])) {
                // Handle image upload and save to storage
                $imagePath = $data['image']->store('images', 'public');

                // Delete the old image from storage
                if ($product) {
                    Storage::disk('public')->delete($product->getRawOriginal('image'));
                }

                $data['image'] = $imagePath;
            }
            $product->update($data);
        } else {
            $product = null;
        }
        return $product;
    }

    public function destroy($id)
    {
        $product = $this->model->find($id);
        if ($product) {
            Storage::disk('public')->delete($product->getRawOriginal('image'));
            $product->delete();
        } else {
            $product = null;
        }
        return $product;
    }
}
