<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    //
    // SignIn Form
    public function signIn(){
        return view('users.signIn');
    }

    //SignUp Form
    public function signUp(){
        return view('users.signUp');
    } 

    public function recipe(){
        return view('users.recipe');
    }
}
