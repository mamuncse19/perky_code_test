<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'products';
    public $timestamps = true;

     public function Category(){
        return $this->belongsTo(Category::class);
    }
}
