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
        $years=[];
        foreach ($allYears as $y) {
            $years[] = $y->name;
        }
        return $years;
    }

    public function storeYears()
    {
        for ($i = 1990; $i <= 2020; $i++) {
            $year = new Year();
            $year->name = $i;
            $year->save();
        }

        if (REQ::is('api/*'))
            return response()->json([
                'Success' => "Successfully Posted Years"
            ], 200);
        return back()->with('success', "Successfully Posted Years");
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
