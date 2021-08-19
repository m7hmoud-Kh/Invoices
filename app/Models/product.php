<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','section_id','created_by'];
    protected $hidden = ['created_at','updated_at'];

    public function section()
    {
        return $this->belongsTo('App\models\section','section_id');
    }
}
