<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcription extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'subscription_master';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Subcription($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }

    public static function getSubscription($id)
    {
    
        $query = Subcription::select('subscription_master.*', 'fs_owner_recurring_payment_history.*','fs_owner.total_orders', 'fs_owner_recurring_payment_history.plan_id', 'fs_owner_recurring_payment_history.start_date', 'fs_owner_recurring_payment_history.end_date','fs_owner_recurring_payment_history.user_id')
            ->join('fs_owner', 'fs_owner.plan_id', '=', 'subscription_master.id')
            ->join('fs_owner_recurring_payment_history', 'fs_owner_recurring_payment_history.plan_id', '=', 'subscription_master.id')
            ->where('fs_owner_recurring_payment_history.user_id', $id)
            ->orderBy('fs_owner_recurring_payment_history.id','desc')
            ->whereNull('fs_owner_recurring_payment_history.deleted_at')
            ->whereNull('subscription_master.deleted_at');

        return $query;
    }
}
