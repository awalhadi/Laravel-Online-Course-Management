<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserCourse extends Controller
{
    //request for new coure
    public function request_course(Request $request, $id){
        if (!Auth::check()) {
            $notify[] = ['error', 'You are not authorized user'];
            return back()->withNotify($notify);
        }
        $user = Auth::user();
        $course = Course::findOrfail($id);
        $create_course = CourseUser::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $create_course->save();
        $notify[] = ['success', 'Course registration success'];
        return response()->json($create_course);
    }

    //request for new coure
    public function drop_course(Request $request, $id){

    }
}
