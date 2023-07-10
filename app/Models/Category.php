<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Category extends Model
{
    use HasFactory;
    public function posts()
    {
    return $this->hasMany(Post::class);
    }
    public function getByCategory(int $limit_count = 5)//ここのlimit変えても何も変わらん....。
    {
     return $this->posts()->with('category')->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
}
