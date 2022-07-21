<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [

    ];

    //get all user info
    public function user(){
        return $this->belongsTo(User::class,"customer_id",'id');
    }
    //get all invoice info
    public function invoiceInfo(){
        return $this->hasMany(InvoiceInfo::class,'invoice_id','id');
    }

}
