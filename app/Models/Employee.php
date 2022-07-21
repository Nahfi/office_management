<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Authenticatable
{
    use HasRoles,HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    protected $guarded = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * encrypt password using hash
     */
    public function passwordEncrypt($value){
        return Hash::make($value);
    }

    public function createdBy(){
        return $this->belongsTo('App\Models\Admin','created_by','id');
    }
    /**
     * Get the user name who edit this employee
     */
    public function editedBy(){
        return $this->belongsTo('App\Models\Admin','edited_by','id');
    }


    public static function trashItemCount(){
        return Employee::onlyTrashed()->count();
    }
    /**
     *  get all work report info that created by employee
     */
    public function employeeReport(){
        return $this->hasMany(Report::class,'employee_id','id');
    }
}