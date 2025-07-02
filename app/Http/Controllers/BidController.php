<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use App\Mail\BidPlaced;
use App\Mail\BidNotification;
use Illuminate\Support\Facades\Mail;

class BidController extends Controller
{
    public function store(Request $request)
    {
        $property = Property::first();

        if (!Auth::user()->document_valide) {
            return back()->withErrors(['document' => "Vous devez fournir un justificatif de solvabilité pour participer à l'enchère."]);
        }

        if ($property->closed || $property->end_at->isPast()) {
            return back()->withErrors(['auction' => 'La vente est terminée.']);
        }

        $highest = $property->bids()->max('amount') ?? $property->starting_price - $property->min_increment;

        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:' . ($highest + $property->min_increment)],
        ]);

        $bid = Bid::create([
            'property_id' => $property->id,
            'user_id' => Auth::id(),
            'amount' => $validated['amount'],
        ]);

        Mail::to(Auth::user())->send(new BidPlaced($bid));
        Mail::to(config('mail.owner_address'))->send(new BidNotification($bid));

        return back();
    }
}
