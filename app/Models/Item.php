<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Lending;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'total',
        'repair',
    ];

    // RELATION: Item -> Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // RELATION: Item -> Lending
    public function lendings()
    {
        return $this->hasMany(Lending::class, 'item_id');
    }

    // ACCESSOR: jumlah yang sedang dipinjam (belum dikembalikan)
    public function getActiveLendingCountAttribute()
    {
        return Lending::where('item_id', $this->id)
            ->whereNull('return_date')
            ->sum('total');
    }

    // ACCESSOR: stok tersedia = total - dipinjam - rusak
    public function getAvailableAttribute()
    {
        return $this->total - $this->active_lending_count - ($this->repair ?? 0);
    }
    public function lendingDetails()
{
    return $this->hasMany(\App\Models\LendingDetail::class, 'item_id');
}
}
