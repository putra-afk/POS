<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';
    public $timestamps = false;

    protected $fillable = [
        'stok_id',
        'barang_id',
        'user_id',
        'stok_tanggal',
        'stok_jumlah',
        'craeted_at',
        'updated_at'
    ];

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }
}
