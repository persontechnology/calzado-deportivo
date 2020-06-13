<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    public function cliente()
    {
        return $this->belongsTo(User::class,'cliente_id');
    }


    public function vendedor()
    {
        return $this->belongsTo(User::class,'vendedor_id');
    }

    public function facturaDetalles()
    {
        return $this->hasMany(FacturaDetalle::class);
    }



}
