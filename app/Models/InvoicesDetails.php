<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesDetails extends Model
{
    use HasFactory;

    protected $table ='invoicedetails';
    protected $fillable =['invoice_id','invoice_number','section','product','status',
        'value_status','note','user','payment_date','created_at','updated_at'];
    protected $hidden =[];

    public function invoices(){
        return $this->belongsTo('App\Models\Invoices','invoice_id','id');
    }

}
