<?php

use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periods')->truncate();
        $data = [
            ['startdate' => '2019-01-01', 'enddate' => '2019-01-31'],
            ['startdate' => '2019-02-01', 'enddate' => '2019-02-28'],
            ['startdate' => '2019-03-01', 'enddate' => '2019-03-31'],
            ['startdate' => '2019-04-01', 'enddate' => '2019-04-30'],
            ['startdate' => '2019-05-01', 'enddate' => '2019-05-31'],
            ['startdate' => '2019-06-01', 'enddate' => '2019-06-30'],
            ['startdate' => '2019-07-01', 'enddate' => '2019-07-31'],
            ['startdate' => '2019-08-01', 'enddate' => '2019-08-31'],
            ['startdate' => '2019-09-01', 'enddate' => '2019-09-30'],
            ['startdate' => '2019-10-01', 'enddate' => '2019-10-31'],
            ['startdate' => '2019-11-01', 'enddate' => '2019-11-30'],
            ['startdate' => '2019-12-01', 'enddate' => '2019-12-31'],
            ['startdate' => '2020-01-01', 'enddate' => '2020-01-31'],
            ['startdate' => '2020-02-01', 'enddate' => '2020-02-28'],
            ['startdate' => '2020-03-01', 'enddate' => '2020-03-31'],
            ['startdate' => '2020-04-01', 'enddate' => '2020-04-30'],
            ['startdate' => '2020-05-01', 'enddate' => '2020-05-31'],
            ['startdate' => '2020-06-01', 'enddate' => '2020-06-30'],
            ['startdate' => '2020-07-01', 'enddate' => '2020-07-31'],
            ['startdate' => '2020-08-01', 'enddate' => '2020-08-31'],
            ['startdate' => '2020-09-01', 'enddate' => '2020-09-30'],
            ['startdate' => '2020-10-01', 'enddate' => '2020-10-31'],
            ['startdate' => '2020-11-01', 'enddate' => '2020-11-30'],
            ['startdate' => '2020-12-01', 'enddate' => '2020-12-31'],
        ];

        DB::table('periods')->insert($data);
    }
}
