<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends Controller
{

    public function login_google(Request $request)
    {
        return $this->_registerOrLoginUser($request);
    }
    protected function _registerOrLoginUser($data)
    {
        $student = Student::where('email',  $data->email)->first();
        if (!$student) {
            $student = new Student();
            $student->fullname = $data->name;
            $student->avatar = $data->photoUrl;
            $student->email = $data->email;
            $student->google_id = $data->id;
            $student->role_id = 1;
            $student->save();
        } else {
            $student->update([
                'google_id' => $data->id,
                'avatar' => $data->photoUrl,
            ]);
        }
        return response()->json(['payload' => $student], 200);
    }
}