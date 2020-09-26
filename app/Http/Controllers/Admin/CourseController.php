<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    //show all course
    public function show_all()
    {
       $courses = Course::orderBy('created_at', 'desc')->get() ?? '';

        return response()->json($courses);
    }

    public function create(Request $request)
    {

        $title   = $request->title;
        $slug   =  slug($request->slug) ?? slug($title);
        $description = $request->description;
        $description = $request->description;
        $price      = $request->price;
        $start_date = $request->start_date;

        $course = Course::create([
            'title'   => $title,
            'slug'   =>  $slug,
            'description' => $description,
            'price'      => $price,
            'start_date' => $start_date,
        ]);

        $course->save();
        $notify[] = ['success', 'course create successfull'];
        return back()->withNotify($notify);
        return response()->json($course);


    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $title   = $request->title;
        $slug   =  slug($request->slug) ?? slug($title);
        $description = $request->description;
        $description = $request->description;
        $price      = $request->price;
        $start_date = $request->start_date;

        $course->update([
            'title'   => $title,
            'slug'   =>  $slug,
            'description' => $description,
            'price'      => $price,
            'start_date' => $start_date,
        ]);

        $notify = ['success', 'course Update successfull'];
        return response()->json($course);
    }

    public function remove(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        $courses = Course::orderBy('created_at', 'desc')->get();
        return response()->json($courses);
    }


}
