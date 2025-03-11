<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LevelModel;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; // Pastikan sesuai dengan nama tabel
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
