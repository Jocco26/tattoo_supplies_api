<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Category extends Model
{
    protected $table = 'product_category';//use to overide the name of the table being used in the db
    protected $fillable = [
        'name'
    ];//declare what column can be filled in the table
    use HasFactory; 
}
