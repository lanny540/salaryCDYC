<?php

Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('reset', 'LoginController@showResetForm');
    Route::post('reset', 'LoginController@resetPassword')->name('password.reset');
});

Route::group(['middleware' => 'auth'], function () {
    // 登录后重置密码
    Route::get('resetpassword', 'UserController@showReset');
    Route::post('resetpassword', 'UserController@resetPassword')->name('password.reset2');
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

    // 上传数据审核
    Route::get('workflow', 'WorkFlowController@index')->name('workflow.index');
    // 审核数据
    Route::put('workflow/{wfId}', 'WorkFlowController@dataConfirm')->name('workflow.confirm');
    // 查看明细数据
    Route::get('workflow/{wfId}', 'WorkFlowController@dataShow')->name('workflow.show');

    // 专项税务导入导出
    Route::get('special', 'SpecialController@index')->name('special.index');
    Route::post('specialExport', 'SpecialController@taxExport');
    Route::post('specialImport', 'SpecialController@taxImport')->name('special.import');

    // 薪酬计算页面
    Route::get('calculation', 'SalaryController@calculate')->name('salary.calculate');
    // 薪酬计算
    Route::get('calSalary', 'SalaryController@calSalary');
    // 薪酬明细导出
    Route::post('salaryExport', 'SalaryController@salaryExport');
    // 当期会计期结束
    Route::post('settleAccount', 'SalaryController@settleAccount');

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
    // 凭证数据重新计算
    Route::post('vdataReCal', 'VoucherController@vdataReCal')->name('vdata.recal');

    // 薪金查询
    Route::get('search', 'SalaryController@salarySearch')->name('salary.search');
    Route::post('search', 'SalaryController@search');
    // 个人薪金打印页
    Route::get('personprint', 'SalaryController@personPrint')->name('person.print');
    Route::post('personprintExport', 'SalaryController@personPrintExport')->name('person.export');
    Route::post('personprint', 'SalaryController@getPersonPrintData');
    // 部门薪金打印页
    Route::get('departmentprint', 'SalaryController@departmentPrint')->name('department.print');
    Route::post('print', 'SalaryController@print');
    // 我的消息
    Route::get('mymsg', 'MessageController@index')->name('mymsg.index');
    Route::get('mymsg/{msgId}', 'MessageController@show')->name('mymsg.show');
    Route::delete('mymsg/{msgId}', 'MessageController@delete')->name('mymsg.delete');

    // 消息发送
    Route::get('messages', 'MessageController@sendIndex')->name('messages.send');
    Route::post('messages', 'MessageController@sendMessage')->name('msg.send');
    Route::post('customMessages', 'MessageController@sendCustomMessage')->name('customMsg.send');

    // 人员信息管理
    Route::get('users', 'UserController@index')->name('users.index');
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
    // 系统基础信息管理
    Route::get('systemconfig', 'ConfigController@systemIndex')->name('systemconfig.index');
    Route::get('systemconfig/{id}', 'ConfigController@systemShow')->name('systemconfig.show');
    Route::put('systemconfig/{id}', 'ConfigController@systemUpdate')->name('systemconfig.update');
    Route::delete('systemconfig/{id}', 'ConfigController@systemDelete')->name('systemconfig.delete');
    // 导入字段读取管理
    Route::get('importconfig', 'ConfigController@importIndex')->name('importconfig.index');
    Route::get('importconfig/{id}', 'ConfigController@importShow')->name('importconfig.show');
    Route::put('importconfig/{id}', 'ConfigController@importUpdate')->name('importconfig.update');
    Route::delete('importconfig/{id}', 'ConfigController@importDelete')->name('importconfig.delete');

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

    Route::get('temp', 'TempController@test');
});
