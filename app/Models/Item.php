<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\LendingDetail;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'total',
        'repair',
    ];

    /**
     * RELATION: Item -> Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * RELATION: Item -> LendingDetail
     */
    public function lendingDetails()
    {
        return $this->hasMany(LendingDetail::class, 'item_id');
    }

    /**
     * ACCESSOR: jumlah yang sedang dipinjam (belum return)
     */
    public function getActiveLendingCountAttribute()
    {
        return $this->lendingDetails()
            ->whereHas('lending', function ($q) {
                $q->whereNull('return_date'); // sesuaikan dengan kolom kamu
            })
            ->sum('qty');
    }

    /**
     * ACCESSOR: stok tersedia
     */
    public function getAvailableAttribute()
    {
        return ($this->total ?? 0)
            - ($this->active_lending_count ?? 0)
            - ($this->repair ?? 0);
    }
}