<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'code', 'sale_price', 'purchase_price', 'quantity', 'image', 'description', 'status', 'category_id'];
    public function category(){
        return $this->belongsTo('App\Category');
    }
}
