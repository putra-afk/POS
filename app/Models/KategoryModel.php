<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoryModel extends Model
{
    protected $table = 'm_kategory';
    protected $primaryKey = 'kategory_id';
    protected $fillable = ['kategory_name', 'kategory_code'];
}
