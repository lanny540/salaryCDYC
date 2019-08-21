<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class SalaryInfo extends Model
{
    protected $table = 'salary_info';

    protected $fillable = [
        'period_id', 'user_id', 'upload_file',
    ];
}
