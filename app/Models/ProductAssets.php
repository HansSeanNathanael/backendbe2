<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAssets extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "product_assets";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "product_id",
        "image"
    ];
}
