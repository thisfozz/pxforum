<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;


class SettingsController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = User::find(auth()->user()->user_id);
        $userDetails = UserDetail::find($user->user_id);

        $imagePath = null;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $imagePath = $request->file('avatar')->store('images', 'public');
        }

        $userDetails->avatar_url = $imagePath;
        $userDetails->save();

        return redirect()->route('profile.edit')->with('success', 'Avatar updated successfully.');
    }
}