<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productRepository->index();
        return ResponseFormatter::success(
            $data,
            'Success Get Data Products!'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return ResponseFormatter::error(
                ['errors' => $validator->errors()],
                'Validation Error!',
                422
            );
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = null;
        }
        $productData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ];

        $products = $this->productRepository->store($productData);

        return ResponseFormatter::success(
            $products,
            'Products created successfully!'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productRepository->show($id);
        if (!$product) {
            return ResponseFormatter::error(
                ['error' => 'Product Not Found, ID : '.$id],
                'Product Not Found, ID : '.$id,
                401
            );
        }
        return ResponseFormatter::success(
            $product,
            'Success Get Data Products ID : '.$id
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return ResponseFormatter::error(
                ['errors' => $validator->errors()],
                'Validation Error!',
                422
            );
        }

        $productData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ];

        if ($request->hasFile('image')) {
            $productData['image'] = $request->file('image');
        }

        $product = $this->productRepository->update($id, $productData);
        if (!$product) {
            return ResponseFormatter::error(
                ['error' => 'Product Not Found!'],
                'Product Not Found!',
                401
            );
        }
        return ResponseFormatter::success(
            $product,
            'Product updated successfully!'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->productRepository->destroy($id);
        if (!$product) {
            return ResponseFormatter::error(
                ['error' => 'Product Not Found!'],
                'Product Not Found!',
                401
            );
        }
        return ResponseFormatter::success(
            $product,
            'Product deleted successfully, ID : '.$id
        );
    }
}
