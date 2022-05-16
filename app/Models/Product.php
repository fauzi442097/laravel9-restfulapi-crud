<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'master_product';
    protected $primaryKey = 'id';

    public $incrementing = true; // default true
    public $timestamps = true; // default true

    protected $guarded = []; // semua kolom bisa diisi


}
