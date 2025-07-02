<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\DocumentSubmitted;

class DocumentController extends Controller
{
    public function show()
    {
        return view('document.upload', ['user' => Auth::user()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'justificatif' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
        ]);

        $path = $request->file('justificatif')->store('justificatifs', 'public');

        $user = $request->user();
        $user->update([
            'justificatif_path' => $path,
            'document_valide' => false,
        ]);

        Mail::to(config('mail.admin_address'))->send(new DocumentSubmitted($user));

        return back()->with('status', 'document-submitted');
    }
}
