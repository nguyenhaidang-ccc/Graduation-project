<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_review'; // Chỉ định tên bảng (nếu khác quy ước)

    protected $fillable = ['user_id', 'product_id', 'rate', 'content',]; // Các trường có thể gán hàng loạt

    public function user()
    {
        return $this->belongsTo(User::class); // Quan hệ với model User
    }

    public function product()
    {
        return $this->belongsTo(Product::class); // Quan hệ với model Product
    }

   
}