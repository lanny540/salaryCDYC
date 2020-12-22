<?php

use App\Models\Users\User;
use App\Models\Users\UserProfile;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $date = Carbon::now();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        UserProfile::truncate();

        $user = User::create([
            'name' => 'admin',
            'password' => bcrypt('123qwe'),
            'created_at' => $date, 'updated_at' => $date,
        ]);

        $faker = factory::create('zh_CN');

        UserProfile::create([
            'user_id' => $user->id,
            'userName' => '李凌',
            'sex' => '男',
            'department_id' => 11,
            'organization_id' => 11,
            'uid' => $faker->uuid,
            'mobile' => $faker->phoneNumber,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'policyNumber' => $faker->ean8,
            'wageCard' => $faker->creditCardNumber,
            'bonusCard' => $faker->creditCardNumber,
            'flag' => 0,
            'status' => '在职',
            'hiredate' => '2005-08-01',
            'handicapped' => 0,
            'tax_rebates' => 0,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        //将admin用户分配到管理员角色
        $user = User::findOrFail(1);
        $role = Role::where('id', 1)->Orwhere('typeId', 9)->get();
        $user->roles()->sync($role);

//        //以下为测试数据
//        $department = Department::where('level', 2)->pluck('id')->toArray();
//        $tempUsers = [];
//        $userProfiles = [];
//        for ($i = 1; $i < 20; ++$i) {
//            $data1 = [
//                'name' => 'tempuser'.$i,
//                'password' => bcrypt('123qwe'),
//                'created_at' => $date, 'updated_at' => $date,
//            ];
//            $data2 = [
//                'user_id' => $i + 1,
//                'userName' => $faker->name,
//                'sex' => '男',
//                'department_id' => $department[array_rand($department)],
//                'organation_id' => $department[array_rand($department)],
//                'uid' => $faker->uuid,
//                'mobile' => $faker->phoneNumber,
//                'phone' => $faker->phoneNumber,
//                'address' => $faker->address,
//                'policyNumber' => $faker->ean8,
//                'wageCard' => $faker->creditCardNumber,
//                'bonusCard' => $faker->creditCardNumber,
//                'flag' => 0,
//                'status' => '在职',
//                'hiredate' => '2005-08-01',
//                'departure' => null,
//                'handicapped' => 0,
//                'tax_rebates' => 0,
//                'created_at' => $date, 'updated_at' => $date,
//            ];
//
//            $tempUsers[] = $data1;
//            $userProfiles[] = $data2;
//        }
//        User::insert($tempUsers);
//        UserProfile::insert($userProfiles);
    }
}
