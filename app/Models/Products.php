<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $table = 'products';
    protected $fillable = ['product_name','description','section_id'];
    protected $hidden = ['created_at','updated_at'];

    public function section(){
        return $this->belongsTo('App\Models\Sections','section_id','id');
    }
}
