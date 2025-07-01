<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function show()
    {
        $property = Property::first();
        $highestBid = $property->bids()->orderByDesc('amount')->first();

        return view('property.show', [
            'property' => $property,
            'highestBid' => $highestBid,
        ]);
    }

    public function bids()
    {
        $property = Property::first();
        $bids = $property->bids()->with('user')->orderByDesc('created_at')->get();

        return response()->json($bids);
    }
}
