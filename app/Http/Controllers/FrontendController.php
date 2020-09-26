<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //
    public function index(){
        $page_title = "Online Course";
        $courses = Course::orderBy('created_at', 'desc')->get();
        return view('home', compact('page_title','courses'));
    }
}
