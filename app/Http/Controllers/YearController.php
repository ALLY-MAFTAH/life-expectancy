<?php

namespace App\Http\Controllers;

use App\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allYears = Year::all();
        foreach ($allYears as $y) {
            $years[]=$y->name;
        }
        return $years;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:years'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $year = new Year();
        $year->name = $request->input('name');
        $year->save();

        if (REQ::is('api/*'))
            return response()->json([
                'Success' => "Successfully Posted Year"
            ], 200);
        return back()->with('success', "Successfully Posted Year");
    }

    public function deleteAllYears()
    {
        Year::truncate();
        if (REQ::is('api/*'))
            return response()->json([
                'Success' => "Successfully Deleted All Years"
            ], 200);
        return back()->with('success', "Successfully Deleted All Years");
    }
}
