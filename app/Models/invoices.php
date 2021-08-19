<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $tabal = 'invoices';
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product_id',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'discount',
        'rate_vat',
        'value_vat',
        'value_status',
        'total',
        'note',
        'created_by'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\product', 'product_id');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\section', 'section_id');
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
