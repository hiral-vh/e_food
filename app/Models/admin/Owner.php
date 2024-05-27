<?php

namespace App\Models\admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Owner extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_owner';

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'restaurant_id');
    }

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Owner($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }

    public static function getPlanDetails()
    {
        $query = Owner::select('fs_owner.*', 'fs_owner_recurring_payment_history.end_date')
            ->join('fs_owner_recurring_payment_history', 'fs_owner_recurring_payment_history.user_id', '=', 'fs_owner.id')
            ->whereNull('fs_owner.deleted_at')
            ->orderBy('fs_owner_recurring_payment_history.created_at', 'desc')
            ->groupBy('fs_owner_recurring_payment_history.user_id');
        // ->unique('fs_owner_recurring_payment_history.user_id');
        return $query;
    }

    public static function getAllData()
    {
        $query = Owner::select('fs_owner.*', 'fs_owner_recurring_payment_history.start_date', 'fs_owner_recurring_payment_history.end_date')
            ->join('fs_owner_recurring_payment_history', 'fs_owner_recurring_payment_history.user_id', '=', 'fs_owner.id');

        return $query;
    }
}
