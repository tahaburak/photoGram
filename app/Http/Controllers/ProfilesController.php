<?php

namespace App\Http\Controllers;

use App\User;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{

	public function show(User $user)
	{
		return view('profiles.index', compact('user'));
	}

	public function edit(User $user)
	{
		$this->authorize('update', $user->profile);
		return view('profiles.edit', compact('user'));
	}

	public function update(User $user)
	{
		$this->authorize('update', $user->profile);
		$data = request()->validate([
			'title' => 'required',
			'description' => 'required',
			'url' => ['url'],
			'image' => '',
		]);

		if (request('image')) {
			$imagePath = request('image')->store('profile', 'public');
			$image = Image::make(public_path("profile/{$imagePath}"))->fit(1000, 1000);
			$image->save();
		}

		auth()->user()->profile->update(array_merge(
			$data, ['image' => $image]
		));

		return redirect("/profile/{$user->id}");

	}
}
