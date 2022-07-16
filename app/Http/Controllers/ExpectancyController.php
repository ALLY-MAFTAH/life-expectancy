<?php

namespace App\Http\Controllers;

use App\Models\Expectancy;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Schema;

class ExpectancyController extends Controller
{
    public function getExpectancyData(Request $request)
    {
        $year = $request->get('year', 2020);
        $selectedYear = Year::where('name', $year)->first();
        $currentYear = $year;
        $expectancies = $selectedYear->expectancies;
        $ex = new YearController();
        $years = $ex->index();

        if (REQ::is('api/*'))
            return response()->json([
                'Expectancies' => $expectancies,
                'years' => $years
            ], 200);
        return view('welcome')->with([
            'expectancies' => $expectancies,
            'years' => $years,
            'currentYear' => $currentYear
        ]);
    }

    public function uploadFile(Request $request)
    {
        $ye = new YearController();
        $years = $ye->index();
        $csvFile = $request->file('csv_file');

        if (!$csvFile) {
            return back()->with('error', 'File Not Uploaded');
        } else {
            $fileName = $csvFile->getClientOriginalName();
            $locationToStore = 'uploads';
            $csvFile->move($locationToStore, $fileName);
            $filepath = public_path($locationToStore . "/" . $fileName);

            // Read the file and store its data into array
            $initialCount = 0;
            $dataArray = array();
            $csvFile = fopen($filepath, "r");
            while (($filedata = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                // Skip first row of headings
                if ($initialCount == 0) {
                    $initialCount++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $dataArray[$initialCount][] = $filedata[$c];
                }
                $initialCount++;
            }
            fclose($csvFile);
            $finalCount = 0;
            // Upload data
            foreach ($dataArray as $importData) {
                $finalCount++;
                foreach ($years as $index => $year) {
                    try {
                        $expectancy =  Expectancy::create([
                            'country_name' => $importData[0],
                            'country_code' => $importData[1],
                            'indicator_name' => $importData[2],
                            'year_id' => $year->id,
                            'total' => $importData[$index + 3],
                        ]);
                        $year->expectancies()->save($expectancy);
                    } catch (\Exception $e) {
                        print($e);
                    }
                }
            }
            if (REQ::is('api/*'))
                return response()->json([
                    'Success' => "$finalCount expectancy data successfully uploaded"
                ], 200);
            return back()->with('success', "$finalCount expectancy data successfully uploaded");
        }
    }

    // public function getYears()
    // {
    //     $columnNames = [];
    //     $years = [];

    //     $columns = Schema::getColumnListing('expectancies');
    //     for ($i = 4; $i < 35; $i++) {
    //         $columnNames[] = $columns[$i];
    //     }
    //     foreach ($columnNames as $columnName) {
    //         $x = substr($columnName, 5, 4);
    //         $years[] = $x;
    //     }
    //     return $years;
    // }

    public function deleteAllData()
    {
        Expectancy::truncate();
        if (REQ::is('api/*'))
            return response()->json([
                'Success' => "Successfully Deleted All Expectancy Data"
            ], 200);
        return back()->with('success', "Successfully Deleted All Expectancy Data");
    }
}
