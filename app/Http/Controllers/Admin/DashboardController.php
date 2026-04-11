<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => Item::count(),
            'total_qty'   => Item::sum('total'),
            'total_users' => User::count(),
            'categories'  => Category::count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats
        ]);
    }
}