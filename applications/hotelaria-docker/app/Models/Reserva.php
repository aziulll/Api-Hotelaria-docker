<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $fillable = ['data_checkin', 'data_checkout', 'quarto_id', 'user_id'];

    /**
     *
     * @param int 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function reservasPorCliente($userId)
    {
        return $this->where('user_id', $userId)->get();
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
