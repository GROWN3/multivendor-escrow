<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product; // ✅ Required for product() relationship
use App\Models\User;    // ✅ Required for buyer() relationship

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
