<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    const STATUS_NEW = 1;
    const STATUS_PROCESS = 2;
    const STATUS_CANCELED = 3;

    protected $table = 'applications';
    protected $fillable = ['item_id', 'phone', 'status', 'fullname', 'address'];



}
