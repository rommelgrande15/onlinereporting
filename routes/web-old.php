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
// 	'uses'=>'UserController@getLoginIndex',
// 	'as'=>'login'
// ]);

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

Route::get('/register',[
	'uses'=>'UserController@getRegister',
	'as'=>'register'
]);

Route::post('/create',[
	'uses'=>'UserController@postUserSignUp',
	'as'=>'create'
]);

Route::get('/mail',[
	'uses'=>'UserController@testMail',
	'as'=>'mail'
]);

Route::get('activate/{confirmation_code}', [
'uses' => 'UserController@activateUser',
'as' => 'activate'
]);

////////////////////////////////////////////////////****Account Routes****//////////////////////////////////////////
Route::get('/dashboard',[
	'uses'=>'AccountController@getDashboard',
	'as'=>'dashboard',

]);

Route::get('/profile',[
	'uses'=>'AccountController@getProfile',
	'as'=>'dashboard',

]);

Route::get('/settings',[
	'uses'=>'AccountController@accountSettings',
	'as'=>'settings',

]);

Route::post('/updateprofile',[
	'uses' => 'AccountController@updateProfile',
	'as'=>'updateprofile'
]);

Route::post('/updateemail',[
	'uses' => 'AccountController@changeEmail',
	'as'=>'updateemail'
]);

Route::post('/updatepassword',[
	'uses' => 'AccountController@changePassword',
	'as'=>'updatepassword'
]);

Route::post('/updateusername',[
	'uses' => 'AccountController@changeUsername',
	'as'=>'updateusername'
]);
///////////////////////////////////////////////***** Inspection Routes *****//////////////////////////////////////////
Route::get('/inspection',[
	'uses'=>'InspectionController@getIndex',
	'as'=>'inspection',

]);

///////////////////////////////////////////////***** Admin Routes *****//////////////////////////////////////////
Route::get('/administrator',[
	'uses'=>'AdminUserController@getLogin',
	'as'=>'administrator'
]);

Route::post('/signin',[
	'uses'=>'AdminUserController@postLoginAdmin',
	'as'=>'signinuser'
]);

Route::get('/signout',[
	'uses'=>'AdminAccountController@getLogout',
	'as'=>'signout'
]);

Route::get('/test',[
	'uses'=>'AdminAccountController@testReportNo',
	'as'=>'test'
]);


Route::post('/saveinspection',[
	'uses'=>'AdminAccountController@postInspectionData',
	'as'=>'saveinspection'
]); 
Route::post('/savecbpiinspection',[
	'uses'=>'AdminAccountController@postCBPIData',
	'as'=>'savecbpiinspection'
]);

Route::post('/savesitevisitinspection',[
	'uses'=>'AdminAccountController@postSiteData',
	'as'=>'savesitevisitinspection'
]);

//jesser save as draft
Route::post('/savedraftinspection',[
	'uses'=>'AdminAccountController@saveDraftInspection',
	'as'=>'savedraftinspection'
]);

//jesser update draft
Route::post('/editpsidraft',[
	'uses'=>'AdminAccountController@updateInspectionPsiDataFromDraft',
	'as'=>'editpsidraft'
]); 

Route::post('/editcbpidraft',[
	'uses'=>'AdminAccountController@updateDraftInspectionCbpi',
	'as'=>'editcbpidraft'
]); 


//jesser save and publish from draft
Route::post('/edited-draft-inspection',[
	'uses'=>'AdminAccountController@postInspectionDataFromDraft',
	'as'=>'edited-draft-inspection'
]); 

//jesser save and publish from draft without added files
Route::post('/publishdraftwoutfiles',[
	'uses'=>'AdminAccountController@postInspectionDataFromDraftWoutAddedFiles',
	'as'=>'publishdraftwoutfiles'
]); 

//jesser save and publish from draft without added files cbpi
Route::post('/publishdraftwoutfilescbpi',[
	'uses'=>'AdminAccountController@postCBPIDataFromDraftWoutFiles',
	'as'=>'publishdraftwoutfilescbpi'
]); 

//jesser save and publish from draft cbpi
Route::post('/edited-draft-inspection-cbpi',[
	'uses'=>'AdminAccountController@postCBPIDataFromDraft',
	'as'=>'edited-draft-inspection-cbpi'
]); 

Route::get('/geteditaql/{id}',[
	'uses'=>'AdminAccountController@getEditAQL',
	'as'=>'getEditAQL'
]);
//joe
Route::post('/deleteContact',[
	'uses'=>'ClientController@deleteContact',
	'as'=>'deleteContact'
]);

Route::post('/getAllData',[
	'uses'=>'ClientController@getallData',
	'as'=>'getAllData'
]);

Route::post('/updatedraftaql',[
	'uses'=>'AdminAccountController@updateDraftAQL',
	'as'=>'updateDraftAQL'
]); 

Route::get('/deletedraftproduct/{id}',[
	'uses'=>'AdminAccountController@deleteDraftProduct',
	'as'=>'deletedraftproduct'
]);

//jesser find attachments
Route::get('/findattachments/{id}',[
	'uses'=>'AdminAccountController@getAttachments',
	'as'=>'findattachments'
]);

Route::post('/deleteattachments',[
	'uses'=>'AdminAccountController@deleteAttachments',
	'as'=>'deleteattachments'
]);

//jesser save as draft cbpi
Route::post('/savedraftinspectioncbpi',[
	'uses'=>'AdminAccountController@saveDraftInspectionCbpi',
	'as'=>'savedraftinspectioncbpi'
]); 

Route::get('/panel/{id}',[
	'uses'=>'AdminAccountController@getDashboardPanel',
	'as'=>'panel',

]);

Route::get('/template',[
    'uses'=>'AdminAccountController@getTemplateForm',
    'as'=>'template',
]);

Route::get('/template/{id}',[
    'uses'=>'AdminAccountController@getTemplate',
    'as'=>'template-get',
]);

Route::get('/template/{id}/delete',[
    'uses'=>'AdminAccountController@deleteTemplate',
    'as'=>'template-delete',
]);

Route::post('/template',[
    'uses'=>'AdminAccountController@postTemplate',
    'as'=>'template-post',
]);

Route::post('/template/assets',[
    'uses'=>'AdminAccountController@postTemplateAssets',
    'as'=>'template-assets',
]);

//dev start
Route::get('/project-dev',[
	'uses'=>'AdminAccountControllerDev@getInspectionProjectForm',
	'as'=>'project',
]);
//dev end

Route::get('/project',[
	'uses'=>'AdminAccountController@getInspectionProjectForm',
	'as'=>'project',
]);

//jesser edit-project
Route::get('/edit-project/{inspection_id}',[
	'uses'=>'AdminAccountController@getInspectionProjectFormEdit',
	'as'=>'edit-project',
]);

//jesser edit-project-cbpi
Route::get('/edit-project-cbpi/{inspection_id}',[
	'uses'=>'AdminAccountController@getInspectionProjectFormEditCbpi',
	'as'=>'edit-project-cbpi',
]);

//jesser
Route::get('/getclientcountinspection/{id}',[
	'uses'=>'AdminAccountController@getCountInspection',
	'as'=>'getclientcountinspection',
]);

Route::post('/addclientcontactajax',[
	'uses'=>'AdminAccountController@addNewContactAJAX',
	'as'=>'addclientcontactajax'
]);

Route::get('/getallclientcontacts/{id}', [
	'uses'=>'AdminAccountController@getAllClientContacts',
	'as'=>'getallclientcontacts'
]);

Route::get('/getoneclientcontact/{id}', [
	'uses'=>'AdminAccountController@getClientContact',
	'as'=>'getoneclientcontact'
]);
//Inspector Address
Route::get('/getinspectoraddress/{id}', [
	'uses'=>'AdminAccountController@getInspectorAddress',
	'as'=>'getinspectoraddress'
]);

Route::get('/getonefactorycontact/{id}', [
	'uses'=>'AdminFactoryController@getOneContact',
	'as'=>'getonefactorycontact'
]);

//jesser more factory contact person
Route::get('/getonefactorycontact2/{id}/{id2}', [
	'uses'=>'AdminFactoryController@getOneContact2',
	'as'=>'getonefactorycontact2'
]);


Route::post('/addfactorycontact',[
	'uses'=>'AdminFactoryController@addNewContactAJAX',
	'as'=>'addfactorycontact'
]);
Route::post('/addclientcontact',[
	'uses'=>'ClientController@addNewContact',
	'as'=>'addclientcontact'
]);
Route::get('/clients',[
	'uses'=>'ClientController@getClients',
	'as'=>'clients',

]);

Route::get('/clientcontacts/{id}',[
	'uses'=>'ClientController@getClientContacts',
	'as'=>'clientcontacts',
]);

Route::post('/addclientcontact',[
	'uses'=>'ClientController@addNewContact',
	'as'=>'addclientcontact'
]);

Route::get('/getoneclients/{id}',[
	'uses'=>'ClientController@getOneClient',
	'as'=>'getoneclients',
]);

Route::post('/addclient',[
	'uses'=>'ClientController@addNewClient',
	'as'=>'addclient'
]);
 
Route::post('/addclientajax',[
	'uses'=>'ClientController@addNewClientAJAX',
	'as'=>'addclientajax'
]);

Route::post('/deleteclient',[
	'uses'=>'ClientController@deleteClient',
	'as'=>'deleteclient'
]);

Route::post('/updateclient',[
	'uses'=>'ClientController@updateClient',
	'as'=>'updateclient'
]);

Route::get('/getonecontact/{id}',[
	'uses'=>'ClientController@getOneContact',
	'as'=>'getonecontact',
]);

Route::get('/inspectorassignment/{id}/{insp_date}',[
	'uses'=>'AdminAccountController@getInspectorCount',
	'as'=>'inspectorassignment',
]);

Route::post('/updatecontact',[
	'uses'=>'ClientController@updateContact',
	'as'=>'updatecontact'
]);

Route::post('/deletecontact',[
	'uses'=>'ClientController@deleteContact',
	'as'=>'deletecontact'
]);

Route::get('/inspectors',[
	'uses'=>'InspectorsController@getInspectors',
	'as'=>'inspectors',
]);

Route::get('/inspectorsData',[
	'uses'=>'InspectorsController@getInspectorsData',
	'as'=>'inspectorsData',
]);

Route::post('/inspectorsDataNew',[
	'uses'=>'InspectorsController@getInspectorsDataNew',
	'as'=>'inspectorsDataNew',
]);

Route::get('/InspectorsUsernameData',[
	'uses'=>'InspectorsController@getInspectorsUsernameData',
	'as'=>'InspectorsUsernameData',
]);

Route::post('/InspectorsUsernameDataNew',[
	'uses'=>'InspectorsController@getInspectorsUsernameDataNew',
	'as'=>'InspectorsUsernameDataNew',
]);

Route::post('/newinspector',[
	'uses'=>'InspectorsController@postNewInspector',
	'as'=>'newinspector'
]);

Route::get('/getoneinspector/{id}',[
	'uses'=>'InspectorsController@getOneInspector',
	'as'=>'getoneinspector',
]);

Route::get('/getallinspector',[
	'uses'=>'InspectorsController@getAllInspector',
	'as'=>'getallinspector',
]);


Route::post('/updateinspector',[
	'uses'=>'InspectorsController@updateInspector',
	'as'=>'updateinspector'
]);

Route::post('/deleteinspector',[
	'uses'=>'InspectorsController@deleteInspector',
	'as'=>'deleteinspector'
]);

Route::get('/factorylist',[
	'uses'=>'AdminFactoryController@getFactoryList',
	'as'=>'factorylist',
]);

Route::get('/InspectionCost',[
	'uses'=>'AdminInspectionCostController@InspectionCost',
	'as'=>'InspectionCost',
]);

//jesser short publish
Route::get('/short-publish/{id}',[
	'uses'=>'AdminAccountController@shortPublish',
	'as'=>'short-publish',
]);

//jesser shortcut publish save
Route::post('/shortpublishinspection',[
	'uses'=>'AdminAccountController@shortPublishInspection',
	'as'=>'shortpublishinspection',
]);

//jesser shortcut publish save CBPI
Route::post('/shortpublishinspectioncbpi',[
	'uses'=>'AdminAccountController@shortPublishInspectionCbpi',
	'as'=>'shortpublishinspectioncbpi',
]);

Route::post('/postnewfactory',[
	'uses'=>'AdminFactoryController@postNewFactory',
	'as'=>'postnewfactory',
]);

Route::post('/postnewfactorycontact',[
	'uses'=>'AdminFactoryController@AddMoreFactoryContact',
	'as'=>'AddMoreFactoryContact',
]);


Route::post('/newfactoryajax',[
	'uses'=>'AdminFactoryController@postNewFactoryAJAX',
	'as'=>'newfactoryajax',
]);


Route::post('/postupdatefactory',[
	'uses'=>'AdminFactoryController@postUpdateFactory',
	'as'=>'postupdatefactory',
]);

Route::post('/postupdatefactorycontactperson',[
	'uses'=>'AdminFactoryController@postUpdateFactoryContactPerson',
	'as'=>'postupdatefactorycontactperson',
]);


Route::get('/getonefactory/{id}',[
	'uses'=>'AdminFactoryController@getOneFactory',
	'as'=>'getonefactory'
]);

Route::post('/addnewfactory',[
	'uses'=>'AdminFactoryController@addNewContact',
	'as'=>'addnewfactory',
]);



Route::post('/postdeletefactory',[
	'uses'=>'AdminFactoryController@postDeleteFactory',
	'as'=>'postdeletefactory'
]);

Route::get('/factorycontacts/{id}',[
	'uses'=>'AdminFactoryController@getFactoryContacts',
	'as'=>'factorycontacts'
]);
//Added
Route::get('/projectdetails/{id}',[
	'uses'=>'AdminFactoryController@getProjectDetails',
	'as'=>'projectdetails'
]);

//Added Jesser
Route::get('/project-details/{id}',[
	'uses'=>'AdminAccountController@getProjectDetailsNew',
	'as'=>'project-details'
]);

//Added Jesser
Route::get('/project-details-cbpi/{id}',[
	'uses'=>'AdminAccountController@getProjectDetailsCbpiNew',
	'as'=>'project-details-cbpi'
]);

//Added Jesser upload files
Route::post('/uploadfiles',[
	'uses'=>'AdminAccountController@uploadFiles',
	'as'=>'uploadFiles'
]);


Route::get('/inspectiondetails/{id2/id}',[
    'uses'=>'ClientController@inspectiondetails',
    'as'=>'inspectiondetails'
]);

Route::get('/projectdetails_cbpi/{id}',[
	'uses'=>'AdminFactoryController@getProjectDetails_cbpi',
	'as'=>'projectdetails_cbpi'
]);
Route::get('/factorycontact/{id}',[
	'uses'=>'AdminFactoryController@getOneContact',
	'as'=>'factorycontact'
]);

Route::get('/getclientfactory/{id}',[
	'uses'=>'AdminFactoryController@getAllFactories',
	'as'=>'clientfactory'
]);

Route::post('/udpatefactorycontact',[
	'uses'=>'AdminFactoryController@updateFactoryContact',
	'as'=>'udpatefactorycontact'
]);

Route::post('/deletefactorycontact',[
	'uses'=>'AdminFactoryController@deleteFactoryContact',
	'as'=>'deletefactorycontact'
]);

Route::post('/deletecontactfactory',[
	'uses'=>'AdminFactoryController@deleteFactoryContact',
	'as'=>'deletecontactfactory'
]);


/////////////////////////////////////////**Inspection Routes**/////////////////////////////////////////////////////////////////////////////
Route::post('/newfactory',[
	'uses'=>'FactoryController@postAJAXNewFactory',
	'as'=>'newfactory'
]);
Route::post('/getfactory',[
	'uses'=>'FactoryController@retrieveFactory',
	'as'=>'getfactory'
]);
Route::post('/fileupload',[
	'uses'=>'InspectionController@uploadPhoto',
	'as'=>'fileupload'
]);

Route::post('/newproduct',[
	'uses'=>'ProductController@postNewProduct',
	'as'=>'newproduct'
]);

Route::post('/newproductajax',[
	'uses'=>'ProductController@postNewProductAJAX',
	'as'=>'newproductajax'
]);
Route::post('/selectproduct',[
	'uses'=>'ProductController@getProduct',
	'as'=>'selectproduct'
]);

/////////////////////////////////////////**Product Routes**/////////////////////////////////////////////////////////////////////////////
Route::get('/products',[
	'uses'=>'ProductController@getProductPage',
	'as'=>'products',
]);

Route::post('/updateproduct',[
	'uses'=>'ProductController@updateProduct',
	'as'=>'updateproduct'
]);
Route::post('/deleteproduct',[
	'uses'=>'ProductController@deleteProduct',
	'as'=>'deleteproduct'
]);

/////////////////////////////////////////**Factory Routes**/////////////////////////////////////////////////////////////////////////////
Route::get('/factories',[
	'uses'=>'FactoryController@getFactoryIndex',
	'as'=>'factories'
]);
Route::post('/updatefactory',[
	'uses'=>'FactoryController@updateFactory',
	'as'=>'updatefactory'
]);

Route::post('/deletefactory',[
	'uses'=>'FactoryController@deleteFactory',
	'as'=>'deletefactory'
]);

/////////////////////////////////////////**Customer Requirements Routes**/////////////////////////////////////////////////////////////////////////////
Route::get('/requirements',[
	'uses'=>'CRController@getCustomerRequirements',
	'as'=>'requirements'
]);

Route::post('/updatecr',[
	'uses'=>'CRController@updateChanges',
	'as'=>'updatecr'
]);

Route::get('/testcount',[
	'uses'=>'SendReportController@testCount',
	'as'=>'testcount'
]);
/////////////////////////////////////////**App Routes**/////////////////////////////////////////////////////////////////////////////



Route::group(['middleware' => ['api'],'prefix' => 'api'], function () {
    Route::post('login','APIController@postApplogin');
    Route::get('user','APIController@getAuthenticatedUser');
    Route::get('users','APIController@index');
	Route::get('ping','APIController@pingServer');
    Route::post('download','APIController@downloadBlankReport');
    Route::post('sendchecklist','ReportsController@sendChecklist');
    Route::post('sendsupplier','ReportsController@sendSupplier');
	Route::post('sendcargoinputs','ReportsController@sendCargoInputs');
	Route::post('productInformation','ReportsController@productInformation');
	Route::post('productPhotoData','ReportsController@productPhotoData');
	Route::post('remarks','ReportsController@remarks');
    Route::post('sendcargophotos','ReportsController@sendCargoPhotos');
    Route::post('sendloading','ReportsController@sendLoading');
    Route::post('senddetailedphoto','ReportsController@sendDetailedPhoto');
    Route::post('senddetailedproduct','ReportsController@sendDetailedProduct');
    Route::post('sendproductqty','ReportsController@sendProductQty');
    Route::post('sendobservation','ReportsController@sendObservation');
    Route::post('sendobservationno','ReportsController@sendObservationNo');
    Route::post('senddescription','ReportsController@sendPhotoDescription');
    Route::post('sendinspection','ReportsController@sendInspectionInfo');
    Route::post('sendserials','ReportsController@sendSerialnumbers');
	/* Route::post('emailreport','SendReportFinal@sendMail'); */
	Route::post('emailreport','SendReportController@sendMail');
	Route::post('uploadmultiplecargophotos','ReportsController@uploadMultipleCargoPhotos');
	Route::post('savecargophotos','ReportsController@saveCargoPhotos');
	Route::post('report-photos','ReportsController@reportPhotos');
	Route::post('report-sending','ReportsController@reportSending');
	Route::post('report-answers','ReportsController@reportAnswers');
});
Route::get('report/{id}',[
	'uses'=>'SendReportController@downloadReport',
	'as'=>'report'
]);

/* Route::get('loadingreport/{id}',[
	'uses'=>'SendReportFinal@SendReportFinal',
	'as'=>'SendReportFinal'
]); */


Route::get('loadingreport/{id}',[
	'uses'=>'SendReportController@loadingReportLoader',
	'as'=>'loading'
]);

Route::get('reportupdate',[
    'uses'=>'SendReportController@reportUpdate',
    'as'=>'report-update'
]);

Route::get('getreport/{id}',[
    'uses'=>'SendReportController@loadingReportNew',
    'as'=>'getreport'
]);


Route::get('downloadzip/{id}',[
	'uses'=>'SendReportController@downloadzipnew',
	'as'=>'downloadzip'
]);

Route::get('SendReport2/{id}',[
	'uses'=>'sendReport4@reportsA2',
	'as'=>'SendReport2'
]);

Route::get('SendReport3/{id}',[
	'uses'=>'SendReport3@reportsA3',
	'as'=>'SendReport3'
]);

Route::get('SendReportFinal/{id}',[
	'uses'=>'SendReportFinal@SendReportFinal',
	'as'=>'SendReportFinal'
]);

/* Route::get('SendReportPsi/{id}',[
	'uses'=>'SendReportPsi@SendReportPsi',
	'as'=>'SendReportPsi'
]);
 */

Route::get('SendReportPSI/{id}',[
	'uses'=>'SendReportPSI@SendReportPSI',
	'as'=>'SendReportPSI'
]);

Route::get('SendReportTest/{id}',[
	'uses'=>'SendReportTest@loadingReportTest',
	'as'=>'SendReportTest'
]);


/////////////////////////////////////////**Test Routes**/////////////////////////////////////////////////////////////////////////////
Route::get('/pdf/{id}', [
	'uses'=>'BookingController@getIndex',
	'as'=>'pdf'
]);

Route::get('/download/{id}', [
	'uses'=>'BookingController@downloadSheet',
	'as'=>'download'
]);


/////////////////////////////////////////**Artisan Routes**/////////////////////////////////////////////////////////////////////////////
Route::get('/artisan', [
	'uses'=>'ArtisanCall@callArtisan',
	'as'=>'artisan'
]);

/////////////////////////////////////////**My Bookings Routes**/////////////////////////////////////////////////////////////////////////////
Route::get('/bookings', [
	'uses'=>'BookingsController@getBookings',
	'as'=>'bookings'
]);
Route::get('/booking/{id}', [
	'uses'=>'BookingsController@viewBooking',
	'as'=>'booking'
]);
Route::post('/delete', [
	'uses'=>'BookingsController@deleteRequest',
	'as'=>'delete'
]);
///////////////////////////////////////////** Accounts Management **/////////////////////////////////////////////////////

Route::get('/accounts', [
	'uses'=>'AccountsManagementController@getAccounts',
	'as'=>'accounts'
]);

Route::post('/postnewaccount', [
	'uses'=>'AccountsManagementController@postNewAccount',
	'as'=>'postnewaccount'
]);

Route::get('/getoneaccount/{id}', [
	'uses'=>'AccountsManagementController@getOneAccount',
	'as'=>'getoneaccount'
]);

Route::post('/updateaccount', [
	'uses'=>'AccountsManagementController@updateAccount',
	'as'=>'updateaccount'
]);
Route::post('/deleteaccount', [
	'uses'=>'AccountsManagementController@deleteAccount',
	'as'=>'deleteaccount'
]);

//////////////////////////////////////////////** Permissions controller **////////////////////////////////////////

Route::get('/permissions', [
	'uses'=>'PermissionsController@getAllAccounts',
	'as'=>'permissions'
]);

Route::get('/setpermission/{id}', [
	'uses'=>'PermissionsController@setPermissions',
	'as'=>'setpermission'
]);

Route::post('/updatepermissions/{id}', [
	'uses'=>'PermissionsController@updatePermissions',
	'as'=>'updatepermissions'
]);

/////////////////////////////////////////////////** CMS Routes **////////////////////////////////////////////////
Route::get('/content-management/{id}', [
	'uses'=>'CMSController@getIndex',
	'as'=>'cms.index'
]);

Route::get('/new-content/{id}', [
	'uses'=>'CMSController@getNewEntry',
	'as'=>'cms.new'
]);

Route::get('/update-content/{id}', [
	'uses'=>'CMSController@updateContent',
	'as'=>'cms.updatecontent'
]);

Route::get('/pages', [
	'uses'=>'CMSController@getPagesList',
	'as'=>'cms.pages'
]);

Route::get('/languages', [
	'uses'=>'CMSController@getLanguages',
	'as'=>'cms.languages'
]);
Route::post('/new-language', [
	'uses'=>'CMSController@postNewLanguage',
	'as'=>'cms.newlanguage'
]);

Route::post('/new-page', [
	'uses'=>'CMSController@postNewPage',
	'as'=>'cms.newpage'
]);

Route::post('/new-content', [
	'uses'=>'CMSController@postNewContent',
	'as'=>'cms.newcontent'
]);

Route::post('/content-update', [
	'uses'=>'CMSController@postUpdateContent',
	'as'=>'cms.contentupdate'
]);

Route::get('/admin-dashboard', [
	'uses'=>'PagesController@getNewDashboard',
	'as'=>'admin.dashboard'
]);

Route::get('/client-dashboard', [
    'uses'=>'ClientController@getNewDashboard',
    'as'=>'client.dashboard'
])->middleware('auth:client');

Route::get('/client-dashboard/logout', [
   'uses'=>'ClientController@clientLogout',
    'as'=>'client.logout'
]);

//new booking routes
Route::get('/booking-lists', [
	'uses' => 'AdminBookingController@getBookingPanel',
	'as' => 'getBookingPanel'
	]);