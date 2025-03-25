<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Ensure the table name is correct
    protected $primaryKey = 'level_id'; // Ensure the primary key is correct
    public $timestamps = false; // Set to true if your table has created_at & updated_at

    protected $fillable = ['level_code', 'level_name']; // Correct column names

    public function users()
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}
