<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PeriodSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SalarySeeder::class);
        $this->call(WorkflowsSeeder::class);
    }
}
