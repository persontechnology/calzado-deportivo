<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
