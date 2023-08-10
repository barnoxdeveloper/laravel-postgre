<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;
use App\Services\Category\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->categoryService->index();
        return ResponseFormatter::success(
            $data,
            'Success Get Data Category!'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
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
            'name',
            'status',
        ]);
        $category = $this->categoryService->store($data);
        return ResponseFormatter::success(
            $category,
            'Category Created Successfully!'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = $this->categoryService->show($id);
        if (!$category) {
            return ResponseFormatter::error(
                ['error' => 'Category Not Found, ID : '.$id],
                'Category Not Found, ID : '.$id,
                401
            );
        }
        return ResponseFormatter::success(
            $category,
            'Success Get Data Category ID : '.$id
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id)
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
            'name',
            'status',
        ]);
        $category = $this->categoryService->update($data, $id);
        return ResponseFormatter::success(
            $category,
            'Category Updated Successfully!'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = $this->categoryService->destroy($id);
        if (!$category) {
            return ResponseFormatter::error(
                ['error' => 'Category Not Found, ID : '.$id],
                'Category Not Found, ID : '.$id,
                401
            );
        }
        return ResponseFormatter::success(
            $category,
            'Category deleted successfully, ID : '.$id
        );
    }
}
