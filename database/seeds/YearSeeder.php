<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('years')->insert([
            ['name' => 1990],
            ['name' => 1991],
            ['name' => 1992],
            ['name' => 1993],
            ['name' => 1994],
            ['name' => 1995],
            ['name' => 1996],
            ['name' => 1997],
            ['name' => 1998],
            ['name' => 1999],
            ['name' => 2000],
            ['name' => 2001],
            ['name' => 2002],
            ['name' => 2003],
            ['name' => 2004],
            ['name' => 2005],
            ['name' => 2006],
            ['name' => 2007],
            ['name' => 2008],
            ['name' => 2009],
            ['name' => 2010],
            ['name' => 2011],
            ['name' => 2012],
            ['name' => 2013],
            ['name' => 2014],
            ['name' => 2015],
            ['name' => 2016],
            ['name' => 2017],
            ['name' => 2018],
            ['name' => 2019],
            ['name' => 2020],
        ]);
    }
}
