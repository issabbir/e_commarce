<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToCompany;

class Order extends Model
{
    use HasFactory, BelongsToCompany;

    protected $fillable = ['user_id', 'customer_name', 'customer_email', 'total', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
