<?php

namespace App\Models\admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'country_code',
        'mobile_no',
        'remember_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $table = 'fs_user';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new User($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
    public static function updateUser($id, $data)
    {
        $update = User::where('id', $id)->update($data);
        return $update;
    }

    public static function getAllAppUsers()
    {
        $id = Auth::user()->id;
        $query = User::select('fs_user.*')
            ->join('fs_user_book_table', 'fs_user_book_table.user_id', '=', 'fs_user.id')
            ->where('fs_user_book_table.restaurant_id', $id)
            ->groupBy('fs_user_book_table.user_id')
            ->latest()
            ->get();

        $query1 = User::select('fs_user.*')
            ->join('fs_order_master', 'fs_order_master.user_id', '=', 'fs_user.id')
            ->where('fs_order_master.restaurant_id', $id)
            ->groupBy('fs_order_master.user_id')
            ->latest()
            ->get();

        $mergeTbl = $query->merge($query1);

        return $mergeTbl;
    }
}
