<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Store the selected locale in the session and reload the previous page.
     */
    public function switch(string $locale)
    {
        if (in_array($locale, ['en', 'es'])) {
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }
}
