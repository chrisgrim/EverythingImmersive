<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
    	$userlist = User::latest()->paginate(9);
    	return view('profiles.adminIndex', compact('userlist'));
    }
}
