<?php

//members routes
Route::get('members', 'MembersController@index')->name('investmentclub.members');
Route::get('members/create', 'MembersController@create')->name('investmentclub.members.create');
Route::post('members', 'MembersController@store')->name('investmentclub.members.store');
Route::get('members/{id}/edit', 'MembersController@edit')->name('investmentclub.members.edit');
Route::any('members/{id}/update', 'MembersController@update')->name('investmentclub.members.update');
Route::any('members/{id}/delete', 'MembersController@delete')->name('investmentclub.members.delete');

//accounts routes
Route::get('accounts', 'AccountsController@index')->name('investmentclub.accounts');
Route::get('accounts/create', 'AccountsController@create')->name('investmentclub.accounts.create');
Route::post('accounts', 'AccountsController@store')->name('investmentclub.accounts.store');
Route::get('accounts/{id}/edit', 'AccountsController@edit')->name('investmentclub.accounts.edit');
Route::any('accounts/{id}/update', 'AccountsController@update')->name('investmentclub.accounts.update');
Route::any('accounts/{id}/delete', 'AccountsController@delete')->name('investmentclub.accounts.delete');

//payments routes
Route::get('payments', 'PaymentsController@index')->name('investmentclub.payments');
Route::get('payments/create', 'PaymentsController@create')->name('investmentclub.payments.create');
Route::post('payments', 'PaymentsController@store')->name('investmentclub.payments.store');
Route::get('payments/{id}/edit', 'PaymentsController@edit')->name('investmentclub.payments.edit');
Route::any('payments/{id}/update', 'PaymentsController@update')->name('investmentclub.payments.update');
Route::any('payments/{id}/delete', 'PaymentsController@delete')->name('investmentclub.payments.delete');

//savings routes
Route::get('savings', 'SavingsController@index')->name('investmentclub.savings');
Route::post('savings', 'SavingsController@store')->name('investmentclub.savings.store');
Route::any('savings/{id}/update', 'SavingsController@update')->name('investmentclub.savings.update');
Route::any('savings/{id}/delete', 'SavingsController@delete')->name('investmentclub.savings.delete');

//permissions
Route::get('users/permissions', 'UsersController@permissions')->name('investmentclub.users.permissions');
Route::post('users/permissions', 'UsersController@storepermissions')->name('investmentclub.users.permissions.store');
Route::any('users/permissions/{id}/update', 'UsersController@updatepermissions')->name('investmentclub.users.permissions.update');
Route::any('users/permissions/{id}/delete', 'UsersController@deletepermissions')->name('investmentclub.users.permissions.delete');
//roles
Route::get('users/roles', 'UsersController@roles')->name('investmentclub.users.roles');
Route::get('users/roles/create', 'UsersController@createroles')->name('investmentclub.users.roles.create');
Route::post('users/roles', 'UsersController@storeroles')->name('investmentclub.users.roles.store');
Route::get('users/roles/{id}/edit', 'UsersController@editroles')->name('investmentclub.users.roles.edit');
Route::any('users/roles/{id}/update', 'UsersController@updateroles')->name('investmentclub.users.roles.update');
Route::any('users/roles/{id}/delete', 'UsersController@deleteroles')->name('investmentclub.users.roles.delete');
//users
Route::get('users', 'UsersController@users')->name('investmentclub.users');
Route::get('users/create', 'UsersController@createusers')->name('investmentclub.users.create');
Route::post('users', 'UsersController@storeusers')->name('investmentclub.users.store');
Route::get('users/{id}/edit', 'UsersController@editusers')->name('investmentclub.users.edit');
Route::any('users/{id}/update', 'UsersController@updateusers')->name('investmentclub.users.update');
Route::any('users/{id}/delete', 'UsersController@deleteusers')->name('investmentclub.users.delete');
Route::get('general_settings', 'SettingsController@general_settings')->name('investmentclub.general_settings');
Route::post('general_settings', 'SettingsController@store_general_settings')->name('investmentclub.general_settings.store');
Route::post('general_settings/update', 'SettingsController@update_general_settings')->name('investmentclub.general_settings.update');
