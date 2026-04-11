<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'total', 'user', 'note', 'datetime', 'returned', 'edited_by'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}