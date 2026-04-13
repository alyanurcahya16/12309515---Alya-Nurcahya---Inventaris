<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'total', 'user', 'note', 'datetime',
        'returned', 'return_date', 'edited_by'
    ];

   public function lendingDetails()
{
    return $this->hasMany(\App\Models\LendingDetail::class, 'lending_id');
}
}
