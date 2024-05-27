<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'fs_menu';

    public function category()
    {
        return $this->belongsTo(Foodcategory::class, 'category_id', 'id');
    }

    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Owner::class, 'restaurant_id', 'id');
    }

    public function menuAttribute()
    {
        return $this->hasMany(Menuattribute::class, 'menu_id', 'id');
    }

    public function menuExtraItem()
    {
        return $this->hasMany(MenuExtraItem::class, 'menu_id', 'id');
    }

    public function removeIngredients()
    {
        return $this->hasMany(RemoveIngredients::class, 'menu_id', 'id');
    }

    // public function subCategory()
    // {
    //     return $this->hasOne(Foodmenusubcategory::class, 'id', 'sub_category_id');
    // }
    // public function foodType()
    // {
    //     return $this->hasOne(Foodcategory::class, 'id', 'food_type_id');
    // }
    public function scopeRestaurantId($q)
    {
        $restaurantId = auth()->guard('restaurantportal')->user()->restaurant_id;
        $q->where('restaurant_id', $restaurantId);
    }
}
