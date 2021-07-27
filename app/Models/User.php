<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use DateTimeInterface;

class User extends Authenticatable
{

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['remember_token'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function employee_state()
    {
        return $this->belongsTo(StateEmployee::class);
    }

    public function type_identification()
    {
        return $this->belongsTo(TypeIdentification::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class)->with("state");
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function stateEmployee()
    {
        return $this->belongsTo(StateEmployee::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function hasRoles(array $roles)
    {
        foreach ($roles as $role) {
            if ($this->role->id === intval($role)) {
                return true;
            }
        }
        return false;
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
