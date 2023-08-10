<?php

namespace App\Services\Product;

use Illuminate\Support\Facades\Storage;
use App\Repositories\Product\ProductRepository;

class ProductService {

    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function store(array $data)
    {
        // Handle file upload
        $imagePath = $this->handleFileUpload($data['image']);

        // Create product data without the image
        $productData = [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $imagePath, // This will be null if the file upload fails or no file is present
        ];

        // Store the product with the prepared data
        return $this->repository->store($productData);
    }


    public function show($id)
    {
        return $this->repository->show($id);
    }

    public function update($id, array $data, $imageFile = null)
    {
        $product = $this->repository->show($id);

        if (!$product) {
            return null;
        }

        if ($imageFile) {
            // Delete the old image from storage
            if ($product['image']) {
                // Delete the old image using the URL stored in the array
                $oldImagePath = str_replace(url('storage/'), '', $product['image']);
                Storage::disk('public')->delete($oldImagePath);
            }

            // Save the new image
            $data['image'] = $this->handleFileUpload($imageFile);
        } else {
            // If the image is not changed, keep the existing image path
            $data['image'] = $product['image'];
        }

        return $this->repository->update($data, $id);
    }

    public function destroy($id)
    {
        $product = $this->repository->show($id);

        if (!$product) {
            return null;
        }

        if ($product['image']) {
            // Delete the image from storage
            $imagePath = str_replace(url('storage/'), '', $product['image']);
            Storage::disk('public')->delete($imagePath);
        }

        return $this->repository->destroy($id);
    }

    public function handleFileUpload($file)
    {
        if ($file && $file->isValid()) {
            return $file->store('images', 'public');
        }

        return null;
    }
}
