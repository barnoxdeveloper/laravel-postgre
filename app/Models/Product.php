<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['name', 'category_id', 'description', 'price', 'image'];

    // accessor
    public function getImageAttribute($value)
	{
		return url('storage/' . $value);
	}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
