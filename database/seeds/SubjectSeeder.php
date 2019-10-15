<?php

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Subject::truncate();
        $data = [
            // type = 0
            ['subject_no' => '540', 'subject_name' => '成钞公司', 'subject_type' => '0'],
            // type = 1-5 从excel内导入
        ];
        Subject::insert($data);
    }
}
