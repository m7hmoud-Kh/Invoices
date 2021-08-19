<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_attachments extends Model
{
    use HasFactory;
    protected $table = 'invoices_attachments';
    protected $fillable = [
        'file_name',
        'invoices_id'
    ];

    public function invoices()
    {
        return $this->belongsTo('App\Models\invoices','invoices_id');
    }
}
