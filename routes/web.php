<?php

Route::group(['namespace' => 'auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('reset', 'LoginController@showResetForm')->name('password.request');
    Route::post('reset', 'LoginController@resetPassword')->name('password.reset');
});

Route::group(['middleware' => 'auth'], function () {
    // 仪表板页面
    Route::get('/', 'HomeController@index')->name('home');

    // 个人薪酬页面
    Route::get('salary', 'SalaryController@index')->name('salary.index');
    // 个人薪酬单月明细
    Route::get('salary/{salaryId}', 'SalaryController@show')->name('salary.show');

    // 上传数据页面
    Route::get('uploadData', 'WorkFlowController@uploadIndex')->name('upload.index');
    // 根据角色获取对应表名以及字段名
    Route::get('getColumns/{roleId}', 'WorkFlowController@getColumns');
    // 向导表单提交
    Route::post('wizardSubmit', 'WorkFlowController@wizardSubmit')->name('wizard.submit');

    // 凭证汇总表查看页面
    Route::get('vsheet', 'VoucherController@vsheetIndex')->name('vsheet.index');
    // 根据周期生成凭证汇总表
    Route::get('vsheet/{pid}', 'VoucherController@vsheetShow')->name('vsheet.show');
    // 提交汇总表数据存入数据库
    Route::post('vsheet', 'VoucherController@vsheetSubmit')->name('vsheet.submit');

    // 凭证列表
    Route::get('vdata', 'VoucherController@vdataIndex')->name('vdata.index');
    // 查询凭证数据是否存在
    Route::get('vdatahas', 'VoucherController@vdataHas')->name('vdata.has');
    // 生成凭证页面
    Route::post('vdata', 'VoucherController@vdataShow')->name('vdata.show');
    // 凭证提交页面
    Route::post('vdatastore', 'VoucherController@vdataStore')->name('vdata.store');

    // 薪酬计算页面 --------暂时隐藏
    Route::get('calculation', 'SalaryController@calculate')->name('salary.calculate');

    // 工资条页面
    Route::get('sheet', 'PrintController@sheetIndex')->name('sheet.index');
    // 工资条打印
    Route::get('sheetPrint', 'PrintController@sheetPrint')->name('sheet.print');
    // 年收入页面
    Route::get('income', 'PrintController@incomeIndex')->name('income.index');

    // 人员信息管理
    Route::get('users', 'UserController@usersIndex')->name('users.index');
    Route::get('getUsersData', 'UserController@getUsersData');
    Route::get('users/{userId}/edit', 'UserController@edit')->name('user.edit');
    Route::put('users/{userId}/edit', 'UserController@update')->name('user.update');
    Route::put('users/{userId}/editS', 'UserController@updateS')->name('user.update.s');
    Route::put('users/{userId}/remit', 'UserController@remit')->name('user.remit');
    Route::put('users/{userId}/role', 'UserController@changeRole')->name('user.changeRole');
    // 角色管理
    Route::get('roles', 'RoleController@index')->name('role.index');
    Route::post('roles', 'RoleController@store')->name('role.store');
    Route::get('roles/{roleId}', 'RoleController@show')->name('role.show');
    Route::post('roles/update', 'RoleController@update')->name('role.update');
    // 权限管理
    Route::get('permissions', 'PermissionController@permissionIndex')->name('permission.index');
    // 部门管理
    Route::get('departments', 'DepartmentController@index')->name('department.index');
    Route::get('getDepartments', 'DepartmentController@getDepartments');
    Route::get('departments/{depId}', 'DepartmentController@show')->name('department.show');
    Route::post('departments', 'DepartmentController@store')->name('department.store');
    // 凭证模板管理

    // 个税计算器页面
    Route::get('tax', 'HelpController@taxIndex')->name('tax');
    // 个税计算
    Route::post('tax', 'HelpController@taxCalculate')->name('tax.calculate');
    // 系统BUG报告页面
    Route::get('report', 'HelpController@reportIndex')->name('report');
    // 报告提交
    Route::post('report', 'HelpController@reportPost')->name('report.post');
    // 联系我们页面
    Route::get('contact', 'HelpController@contactIndex')->name('contact');
});
