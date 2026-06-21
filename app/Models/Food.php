<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'user_id',
        'nama',
        'deskripsi',
        'foto',
        'stok',
        'harga',
        'harga_asli',
        'jenis',
        'alamat',
        'latitude',
        'longitude',
        'pickup_time_start',
        'pickup_time_end',
        'status'
    ];
    /**
     * Scope for customer page: active, in stock, and currently within pickup time
     */
    public function scopeAvailable($query)
    {
        $now = now()->format('H:i:s');
        return $query->where('status', 'aktif')
                     ->where('stok', '>', 0)
                     ->whereTime('pickup_time_start', '<=', $now)
                     ->whereTime('pickup_time_end', '>=', $now);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}