<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    use HasFactory;
    protected $table = 'invoices_details';
    protected $fillable = ['invoices_id','value_status','note'];
    protected $hidden = [];

    public function invoices()
    {
        return $this->belongsTo('App\Models\invoices','invoices_id');
    }


    public function getValueStatusAttribute($val)
    {
        switch ($val) {
            case $val == 1:
                return "<span class='btn btn-danger'>Not Paid</span>";
                break;
            case $val == 2:
                return "<span class='btn btn-success'>Paid</span>";
                break;
            case $val == 3:
                return "<span class='btn btn-primary'>Paid partial</span>";
                break;
            default:
                break;
        }
    }
}
