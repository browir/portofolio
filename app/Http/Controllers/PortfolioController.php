<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('portfolio', [
            'data' => config('portfolio'),
            'comments' => Comment::latest()->limit(50)->get(),
        ]);
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $to = config('portfolio.links.email');

        if ($to && config('mail.default') !== 'log') {
            Mail::raw(
                "Dari: {$validated['name']} <{$validated['email']}>\n\n{$validated['message']}",
                function ($mail) use ($validated, $to) {
                    $mail->to($to)
                        ->subject('Pesan baru dari portofolio — '.$validated['name'])
                        ->replyTo($validated['email'], $validated['name']);
                }
            );
        }

        return back()->with('status', 'Pesanmu berhasil terkirim! Aku akan membalas secepatnya.');
    }
}
