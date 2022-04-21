<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Http\Request;

class Cd_SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderByDesc('id')->with('quizs')->get();
        return response()->json($subjects, 200);
        // $subjects = Subject::all()->load('quizs')->toJson();
        // return $subjects;
    }
    public function store(Request $request)
    {
        // $subject = Subject::create([
        //     'name' => $request->name,
        //     'logo' => $request->logo,
        //     'code' => $request->code,
        //     'slug' => $request->slug,
        // ]);
        // $subject = new Subject();
        // $subject->name = $request->name;
        // $subject->logo = $request->logo;
        // $subject->code = $request->code;
        // $subject->slug = $request->slug;
        // $subject->save();
        $subject = Subject::create($request->all());
        return response()->json($subject, 200);
    }
    public function destroy($id)
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            return response()->json([
                'payload' => 'Lỗi không tồn tại !'
            ], 500);
        } else {
            $subject->destroy($id);
            return response()->json([
                'payload' => 'Xóa thành công !'
            ], 200);
        }
    }
    public function show($id)
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            return response()->json(['payload' => 'Không tồn tại trong cơ sở dữ liệu !'], 500);
        } else {
            return response()->json($subject, 200);
        }
    }
    public function update($id, Request $request)
    {
        $subject = Subject::find($id);
        if (is_null($subject)) {
            return response()->json(['payload' => 'Không tồn tại trong cơ sở dữ liệu !'], 500);
        } else {
            $subject->update([
                'name' => $request->name,
                'logo' => $request->logo,
                'code' => $request->code,
            ]);
            return response()->json($subject, 200);
        }
    }
}