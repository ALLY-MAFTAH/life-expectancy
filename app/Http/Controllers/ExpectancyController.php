<?php

namespace App\Http\Controllers;

use App\Expectancy;
use App\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Schema;

class ExpectancyController extends Controller
{
    public function getExpectancyData(Request $request)
    {
        $years = [];
        $expects = [];
        $ex = new YearController();
        $years = $ex->index();

        if ($years == []) {
            return view('welcome', compact('years', 'expects'));
        }

        $year = $request->get('year', 2020);
        $currentYear = $year;
        $selectedYear = Year::where('name', $year)->first();
        $expectancies = $selectedYear->expectancies;

        $country = $request->get('country', 'Aruba');
        $currentCountry = $country;
        $expects = Expectancy::where('country_name', $currentCountry)->get();


        $countries = [];
        $allExpectancies = Expectancy::all();
        foreach ($allExpectancies->unique('country_name') as $ex) {
            $countries[] = $ex->country_name;
        }
        if (REQ::is('api/*'))
            return response()->json([
                'Expectancies' => $expectancies,
                'years' => $years
            ], 200);
        return view('welcome')->with([
            'expectancies' => $expectancies,
            'expects' => $expects,
            'years' => $years,
            'currentYear' => $currentYear,
            'currentCountry' => $currentCountry,
            'countries' => $countries
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
                // Skip first two rows of headings
                if ($initialCount == 0) {
                    $initialCount++;
                    continue;
                } elseif ($initialCount == 1) {
                    $initialCount++;
                    continue;
                } elseif ($initialCount == 2) {
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
                foreach (Year::all() as $index => $year) {
                    try {
                        $expectancy =  Expectancy::create([
                            'country_name' => $importData[0],
                            'country_code' => $importData[1],
                            'indicator_name' => $importData[2],
                            'year_id' => $year->id,
                            'total' => doubleval($importData[$index + 3]),
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
