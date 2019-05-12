<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
	public function show($username)
	{
		$user = User::findOrFail($username);

		return view('home', ['user' => $user]);
	}
}
