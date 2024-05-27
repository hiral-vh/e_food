<?php
namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'menu_category';

    public function menuCategory()
    {
        return $this->hasOne(MenuCategory::class, 'id', 'menu_category_id');
    }
}
