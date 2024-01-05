<?php

namespace App\Http\Controllers;

class DarkModeController extends Controller
{
    public function toggleDarkMode()
    {
        $user = auth()->user();
        $user->dark_mode = !$user->dark_mode;
        // dd($user->dark_mode);
        $user->save(); // Save the updated user model
        // Optionally, you can return a response or redirect the user to a specific page
        return redirect()->back()->with('success', 'Dark mode has been toggled.');
    }
}
