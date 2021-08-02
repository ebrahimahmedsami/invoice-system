<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesAttachment extends Model
{
    use HasFactory;

    protected $table ='invoiceattachments';
    protected $fillable =['invoice_id','invoice_number','file_name','user',
        'created_at','updated_at'];
    protected $hidden =[];

    public function invoices(){
        return $this->belongsTo('App\Models\Invoices','invoice_id','id');
    }
}
