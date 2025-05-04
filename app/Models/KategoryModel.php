<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoryModel extends Model
{
    protected $table = 'm_kategory';
    protected $primaryKey = 'kategory_id';
    protected $fillable = ['kategory_name', 'kategory_code'];

    // Example of a relationship (if needed)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Adjust based on your actual relationship
    }
}
