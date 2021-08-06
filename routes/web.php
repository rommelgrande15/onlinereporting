<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//header('Access-Control-Allow-Origin : *');
//header('Access-Control-Allow-Headers : Content-Type, Authorization, X-Requested-With');

// Route::get('/',function(){
// 	return view('pages.main.home');
// });

// Route::get('/',[
// 	'uses'=>'UserController@getLoginIndex qaetr',
// 	'as'=>'login'
// ]);

Route::get('/resize-images/{report}', 'SendReportController@testResizeImage');

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/test_route/{id}',[
	'uses'=>'TesterController@testOnly',
	'as'=>'test_route'
]);


Route::get('/signout',[
	'uses'=>'AdminAccountController@getLogout',
	'as'=>'signout'
]);
Route::post('/signin',[
	'uses'=>'AdminUserController@postLoginAdmin',
	'as'=>'signinuser'
]);
Route::get('/',[
	'uses'=>'AdminUserController@getLogin',
	'as'=>'login'
]);
Route::get('/logout', [
'uses' => 'AccountController@getLogout',
'as' => 'logout'
]);

Route::post('/loginuser',[
	'uses'=>'UserController@postLogin',
	'as'=>'loginuser'
]);
Route::post('/addclient',[
	'uses'=>'ClientController@addNewClient',
	'as'=>'addclient'
]);


///--------------- NEW ROUTES FOR INPSECTORS -ONLINE - REPORTING ------------------//
/// ---------------- ADDED BY ROMMEL 05/31/2021 -------------------------//
Route::get('login-again',[
	'uses'=>'InspectorAccountController@getLoginReturn',
	'as'=>'login-again'
]);

Route::post('/reportsdatalogin',[
	'uses'=>'InspectorAccountController@postLoginReportDetails',
	'as'=>'reportsdatalogin'
]);

Route::get('/inspector-reviewer/{id}',[
	'uses'=>'InspectorAccountController@getDashboardInspectorForReports',
	'as'=>'inspector-reviewer',
]);

Route::get('/inspector-reports-general/{id}',[
	'uses'=>'InspectorAccountController@getInspectorGeneralInformationReportsDetails',
	'as'=>'inspector-reports-general',
]);

Route::post('/inspector-reports-save',[
	'uses'=>'InspectorAccountController@saveInspectorReportDetails',
	'as'=>'inspector-reports-save',
]);


Route::post('/inspector-image-create',[
	'uses'=>'InspectorAccountController@inspectorFileImageCreate',
	'as'=>'inspector-image-create',
]);

Route::post('/inspector-image-delete',[
	'uses'=>'InspectorAccountController@inspectorFileImageDelete',
	'as'=>'inspector-image-delete',
]);

Route::get('/inspector-summary-result/{id}',[
	'uses'=>'InspectorAccountController@getInspectorInspectionSummaryResultReportsDetails',
	'as'=>'inspector-summary-result',
]);

Route::get('/generate-docx/{id}',[
	'uses'=>'InspectorAccountController@generateDocx',
	'as'=>'generate-docx',
]);

Route::get('/getpstcodedata/{id}',[
	'uses'=>'InspectorAccountController@getPstCode',
	'as'=>'getpstcodedata'
]);

Route::get('/getpartnumber/{id}',[
	'uses'=>'InspectorAccountController@getPartNumberData',
	'as'=>'getpartnumber'
]);

Route::get('/getmainpartdata/{id}',[
	'uses'=>'InspectorAccountController@getMainPartData',
	'as'=>'getmainpartdata'
]);








