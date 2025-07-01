<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bid;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();

        return view('admin.index', [
            'users' => User::all(),
            'bids' => Bid::with('user')->orderByDesc('created_at')->get(),
            'property' => Property::first(),
        ]);
    }

    public function close()
    {
        $this->authorizeAdmin();

        $property = Property::first();
        $property->update(['closed' => true]);

        return back();
    }

    private function authorizeAdmin(): void
    {
        if (Auth::guest() || Auth::user()->email !== config('mail.admin_address')) {
            abort(403);
        }
    }
}
