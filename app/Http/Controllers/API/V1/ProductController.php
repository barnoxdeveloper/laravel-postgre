<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productService->index();
        return ResponseFormatter::success(
            $data,
            'Success Get Data Product!'
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
        $data = $request->only([
            'category_id',
            'name',
            'description',
            'price',
            'image',
        ]);
        $products = $this->productService->store($data);
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
        $product = $this->productService->show($id);
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

        $data = $request->only([
            'category_id',
            'name',
            'description',
            'price',
            'image',
        ]);

        $product = $this->productService->update($id, $data, $request->file('image'));

        if (!$product) {
            return ResponseFormatter::error(
                ['error' => 'Product Not Found!'],
                'Product Not Found!',
                401
            );
        }

        return ResponseFormatter::success(
            $product,
            'Product Updated Successfully!'
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->productService->destroy($id);
        if (!$product) {
            return ResponseFormatter::error(
                ['error' => 'Product Not Found!'],
                'Product Not Found!',
                401
            );
        }
        return ResponseFormatter::success(
            $product,
            'Product Deleted Successfully, ID : '.$id
        );
    }
}
