<?php

Route::group(['namespace' => 'Auth'], function () {
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
    // 获取二级分类名
    Route::get('getCatesName/{roleId}', 'WorkFlowController@getCatesName');

    // 向导表单提交
    Route::post('wizardSubmit', 'WorkFlowController@wizardSubmit')->name('wizard.submit');
    // 获取人员信息,用于上传数据校验
    Route::get('getProfiles', 'WorkFlowController@getProfiles');
    // 流程列表页面
    Route::get('workflow', 'WorkFlowController@index')->name('check.index');
    // 获取流程数据
    Route::get('getWorkFlows', 'WorkFlowController@getWorkFlows')->name('workflow.index');
    // 获取流程详细数据
    Route::get('workflow/{workflowId}', 'WorkFlowController@show')->name('workflow.show');
    // 审核流程
    Route::post('checkPost', 'WorkFlowController@post')->name('check.post');

    // 薪酬计算页面
    Route::get('calculation', 'salaryController@calculate')->name('salary.calculate');
    Route::get('calSalary', 'salaryController@calSalary');
    Route::post('settleAccount', 'salaryController@settleAccount');

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
