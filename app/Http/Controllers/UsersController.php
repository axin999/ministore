<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    //
    public function home(){
    	
    }
    public function index(){
    	return User::orderBy('id','DESC')->get();
    }
}
