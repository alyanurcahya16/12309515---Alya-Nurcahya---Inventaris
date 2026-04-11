<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item; // Ensure this is added for fetching items

class LendingController extends Controller
{
    public function index()
    {
        // Fetch all items from the database
        $items = Item::all(); 

        // Dummy lending data (you can replace it with real data from a Lending model if necessary)
        $lendings = [
            ['id' => 1, 'item_id' => 1, 'user' => 'John Doe', 'total' => 2, 'returned' => false, 'datetime' => '2023-04-10 15:30'],
            ['id' => 2, 'item_id' => 2, 'user' => 'Jane Smith', 'total' => 1, 'returned' => true, 'datetime' => '2023-04-09 10:00'],
        ];

        // Pass data to the view
        return view('operator.lendings', compact('items', 'lendings'));
    }
    
}