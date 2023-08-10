<?php

namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository
{
    private $model;

    public function __construct(Category $model)
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
        $category = $this->model->where('id', $id)->first();
        return $category ? $category : $category = null;
    }

    public function update(array $data, $id)
    {
        $category = $this->model->find($id);
        $category->update($data);
        return $category;
    }

    public function destroy($id)
    {
        $category = $this->model->find($id);
        return $category ? $category->delete() : null;
    }
}
