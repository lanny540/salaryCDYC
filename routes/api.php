<?php

// 协同平台数据同步
Route::post('xtsync', 'SyncController@xtSync')->name('xtsync');
