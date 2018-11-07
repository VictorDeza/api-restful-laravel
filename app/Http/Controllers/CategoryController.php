<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    public function index(){
        $categories = Category::all();
        return $this->showAll($categories);
    }

    public function store(Request $model){
        $rules = [
            'name' => 'required|max:50',
            'description' => 'max:256'
        ];

        $validator = Validator::make($model->all(), $rules);
        if($validator->fails()) return $this->errorResponse($validator->errors()->messages(), 400);
        try{
            $category = Category::create($model->all());
            return $this->showOne($category);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function show(Category $category){
        return $this->showOne($category, 201);
    }

    public function update(Request $model, Category $category){
        $rules = [
            'name' => 'required|max:50',
            'description' => 'max:256'
        ];

        $this->validate($model, $rules);

        $category->name = $model->name;
        $category->description = $model->description;
        $category->save();
        return $this->showOne($category);
    }

    public function destroy(Category $category){
        $category->status = !$category->status;
        $category->save();
        return $this->showOne($category);
    }
}
