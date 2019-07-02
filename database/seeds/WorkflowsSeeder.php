<?php

use App\Models\WorkFlow\WorkFlow;
use App\Models\WorkFlow\WorkFlowLog;
use App\Models\WorkFlow\WorkFlowStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WorkflowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WorkFlowStatus::truncate();
        WorkFlowLog::truncate();
        WorkFlow::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $status = [
            ['statusCode' => 0, 'description' => '待发起'],
            ['statusCode' => 1, 'description' => '等待部门审核'],
            ['statusCode' => 2, 'description' => '等待会计审核'],
            ['statusCode' => 3, 'description' => '等待财务审核'],
            ['statusCode' => 8, 'description' => '已办结'],
            ['statusCode' => 9, 'description' => '上传已审核数据'],
        ];
        WorkFlowStatus::insert($status);

        $workflows = [];
        $date = Carbon::now();
        $faker = Faker\factory::create('zh_CN');
        for ($i = 0; $i <= 3; $i++) {
            $data = [
                'title' => $faker->sentence,
                'category_id' => $faker->numberBetween(9, 23),
                'statusCode' => $i,
                'createdUser' => 1,
                'fileUrl' => asset('/storage/excelFiles/1.xls'),
                'created_at' => $date, 'updated_at' => $date,
            ];
            $workflows[] = $data;
        }
        WorkFlow::insert($workflows);
    }
}
