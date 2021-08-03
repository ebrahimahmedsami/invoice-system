<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function invoiceDetails(){
        return $this->hasOne('App\Models\InvoicesDetails','invoice_id','id');
    }

    public function invoiceAttachmets(){
        return $this->hasMany('App\Models\InvoicesAttachment','invoice_id','id');
    }

    public function sections(){
        return $this->belongsTo('App\Models\Sections','section','id');
    }
}
