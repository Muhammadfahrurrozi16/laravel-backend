<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    // protected $fillable = ['name','description'];
    protected $fillable = ['name','description','price','image_url','category_id','user_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(user::class);
    }
    public function scopeCategoryId(Builder $query, string $categoryId, string $userId): Builder
    {
        return $query->where('category_id','LIKE','%'. $categoryId. '%')->where('user_id','LIKE','%'. $userId . '%');
    }
}
