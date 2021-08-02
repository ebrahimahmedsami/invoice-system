<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $fillable = ['section_name','description','created_by'];

    public function products(){
        return $this->hasMany('App\Models\Products','section_id','id');
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoices','section','id');
    }
}

