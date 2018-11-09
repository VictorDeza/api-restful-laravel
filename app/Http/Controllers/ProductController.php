<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
{
    public function index(){
        $products = Product::all();
        return $this->showAll($products);
    }

    public function store(Request $model){

        $rules = [
            'name' => 'required|max:50',
            'code' => 'required',
            'quantity' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'max:256'
        ];

        $validator = Validator::make($model->all(), $rules);
        if($validator->fails()) return $this->errorResponse($validator->errors()->messages(), 400);

        $product = $model->all();
        $product['image'] = $model->file('image')->store('');
        $product = Product::create($product);
        return $this->showOne($product);
    }

    public function show(Product $product){
        return $this->showOne($product, 201);
    }

    public function update(Request $model, Product $product){
        $rules = [
            'name' => 'required|max:50',
            'code' => 'required',
            'quantity' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'max:256'
        ];

        $validator = Validator::make($model->all(), $rules);
        if($validator->fails()) return $this->errorResponse($validator->errors()->messages(), 400);

        $product->name = $model->name;
        $product->code = $model->code;
        $product->quantity = $model->quantity;
        $product->sale_price = $model->sale_price;
        $product->purchase_price = $model->purchase_price;
        $product->image = $model->file('image')->store('');
        $product->description = $model->description;
        $product->category_id = $model->category_id;
        $product->save();
        return $this->showOne($product);
    }

    public function destroy(Product $product){
        $product->status = !$product->status;
        $product->save();
        return $this->showOne($product);
    }
}
