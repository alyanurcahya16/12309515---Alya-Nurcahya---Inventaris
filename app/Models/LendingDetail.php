<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendingDetail extends Model
{
    protected $fillable = ['lending_id', 'item_id', 'qty'];

    public function item()
{
    return $this->belongsTo(\App\Models\Item::class);
}

public function lending()
{
    return $this->belongsTo(\App\Models\Lending::class, 'lending_id');
}
}
