<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class HowItWorksController extends Controller
{
    public function show()
    {
        $howItWorks = Jetstream::localizedMarkdownPath('how-it-works.md');

        return Inertia::render('HowItWorks', [
            'howItWorks' => Str::markdown(file_get_contents($howItWorks)),
        ]);
    }
}
