<?php

namespace zedsh\tower\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachable extends Model
{
    use HasFactory;

    protected $table = 'attachables';
    public $timestamps = false;

    protected $fillable = [
        'file_id',
        'attachable_id',
        'attachable_type'
    ];
}
