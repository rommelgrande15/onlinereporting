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

Route::get('/send_Mail',[
	'uses'=>'UserController@send_Mail',
	'as'=>'send_Mail'
]);

Route::get('/',[
	'uses'=>'AdminUserController@getLogin',
	'as'=>'login'
]);
Route::get('/tic-sera-login',[
	'uses'=>'AdminUserController@getLogin2',
	'as'=>'tic-sera-login'
]);

//Forgot Password for Tic-Sera
Route::get('/forgot-password-tic-sera',[
	'uses'=>'PasswordController@getForgotSera',
	'as'=>'forgotSera'
]);

//Forgot Password
Route::get('/forgot-password',[
	'uses'=>'PasswordController@getForgot',
	'as'=>'forgot'
]);

Route::post('/forgot-password_click',[
	'uses'=>'PasswordController@postForgot',
	'as'=>'forgotuser'
]);

Route::post('/forgot-password_click-tic-sera',[
	'uses'=>'PasswordController@postForgot',
	'as'=>'forgotuser-tic-sera'
]);

//Password Reset Form
Route::get('/reset-password/{reset_code}',[
	'uses'=>'PasswordController@getResetPassword',
	'as'=>'resetpassword'
]);

//Password Reset Form TIC-Sera
Route::get('/reset-password/{reset_code}/tic-sera',[
	'uses'=>'PasswordController@getResetPassword',
	'as'=>'resetpassword-tic-sera'
]);

Route::post('/reset-password/submit',[
	'uses'=>'PasswordController@postResetPassword',
	'as'=>'resetpasswordsubmit'
]);

Route::post('/reset-password-sera/submit',[
	'uses'=>'PasswordController@postResetPasswordSera',
	'as'=>'resetpasswordSerasubmit'
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


//Resend Activation code to Email Address
Route::get('/resend-code', [
'uses' => 'UserController@resendActivationCode',
'as' => 'resend_activation'
]);

Route::post('resend-code/submit', [
'uses' => 'UserController@resendActivationCodeSubmit',
'as' => 'resend-activation'
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

///////////////////////////////////////////////***** factory Routes *****//////////////////////////////////////////


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
//05-04-2021
Route::post('/saveinspection-dev-mr',[
	'uses'=>'AdminAccountControllerDevMR@postInspectionData',
	'as'=>'saveinspection-dev-mr'
]);
//dev routes
Route::post('/saveinspection-dev',[
	'uses'=>'AdminAccountControllerDev@postInspectionData',
	'as'=>'saveinspection-dev'
]); 

Route::post('/savecbpiinspection',[
	'uses'=>'AdminAccountController@postCBPIData',
	'as'=>'savecbpiinspection'
]);

Route::post('/savesitevisitinspection',[
	'uses'=>'AdminAccountController@postSiteData',
	'as'=>'savesitevisitinspection'
]);

Route::post('/releaseorder',[
	'uses'=>'ReleaseClientOrderController@releaseClientOrder',
	'as'=>'releaseorder'
]);
//06-03-2021
Route::post('/releaseorder-mrn',[
	'uses'=>'ReleaseClientOrderControllerMrn@releaseClientOrder',
	'as'=>'releaseorder-mrn'
]);

Route::post('/releaseordercbpi',[
	'uses'=>'ReleaseClientOrderController@releaseClientOrderLoading',
	'as'=>'releaseordercbpi'
]);

Route::post('/holdorder',[
	'uses'=>'ReleaseClientOrderController@holdClientOrder',
	'as'=>'holdorder'
]);
//06-03-2021
Route::post('/holdorder-mrn',[
	'uses'=>'ReleaseClientOrderControllerMrn@holdClientOrder',
	'as'=>'holdorder-mrn'
]);
Route::post('/holdordercbpi',[
	'uses'=>'ReleaseClientOrderController@holdClientOrderLoading',
	'as'=>'holdordercbpi'
]);

 
//jesser new api
Route::post('/savedraftinspectionsite',[
	'uses'=>'AdminEditInspectionController@saveSiteDataAsDraft',
	'as'=>'savedraftinspectionsite'
]);

//jesser new api
Route::post('/savedraftinspectionsitewithfiles',[
	'uses'=>'AdminEditInspectionController@saveSiteDataAsDraftWithFiles',
	'as'=>'savedraftinspectionsitewithfiles'
]);


//jesser save as draft
Route::post('/savedraftinspection',[
	'uses'=>'AdminEditInspectionController@saveDraftInspection',
	'as'=>'savedraftinspection'
]);
//04-20-2021
Route::post('/savedraftinspection-dev-mr',[
	'uses'=>'AdminEditInspectionControllerDevMR@saveDraftInspection',
	'as'=>'savedraftinspection-dev-mr'
]);

//jesser update draft
Route::post('/editpsidraft',[
	'uses'=>'AdminEditInspectionController@updateInspectionPsiDataFromDraft',
	'as'=>'editpsidraft'
]); 
//05-20-2021
Route::post('/editpsidraft-mrn',[
	'uses'=>'AdminEditInspectionControllerDevMR@updateInspectionPsiDataFromDraft',
	'as'=>'editpsidraft-mrn'
]); 

//jesser new api edit site draft
Route::post('/editsitedraft',[
	'uses'=>'AdminEditInspectionController@updateInspectionSiteDataFromDraft',
	'as'=>'editsitedraft'
]); 

Route::post('/editcbpidraft',[
	'uses'=>'AdminEditInspectionController@updateDraftInspectionCbpi',
	'as'=>'editcbpidraft'
]); 

//jesser save and publish from copy
Route::post('/save-copy-inspection',[
	'uses'=>'AdminCopyInspectionController@postInspectionDataFromCopy',
	'as'=>'save-copy-inspection'
]); 


//jesser save and publish from draft
Route::post('/edited-draft-inspection',[
	'uses'=>'AdminEditInspectionController@postInspectionDataFromDraft',
	'as'=>'edited-draft-inspection'
]); 
//05-31-2021
Route::post('/edited-draft-inspection-mrn',[
	'uses'=>'AdminEditInspectionControllerDevMR@postInspectionDataFromDraft',
	'as'=>'edited-draft-inspection-mrn'
]); 

//jesser save and publish from draft without added files
Route::post('/publishdraftwoutfiles',[
	'uses'=>'AdminEditInspectionController@postInspectionDataFromDraftWoutAddedFiles',
	'as'=>'publishdraftwoutfiles'
]); 
//05-31-2021
Route::post('/publishdraftwoutfiles-mrn',[
	'uses'=>'AdminEditInspectionControllerDevMR@postInspectionDataFromDraftWoutAddedFiles',
	'as'=>'publishdraftwoutfiles-mrn'
]);


//jesser save and publish from draft without added files site new api
Route::post('/publishdraftwoutfilessite',[
	'uses'=>'AdminEditInspectionController@postInspectionSiteDataFromDraftWoutAddedFiles',
	'as'=>'publishdraftwoutfilessite'
]); 

//jesser save and publish from draft site
Route::post('/edited-draft-inspection-site',[
	'uses'=>'AdminEditInspectionController@postInspectionSiteDataFromDraft',
	'as'=>'edited-draft-inspection-site'
]); 

//jesser save and publish from copy site
Route::post('/save-copy-site-inspection',[
	'uses'=>'AdminCopyInspectionController@postInspectionSiteDataFromCopy',
	'as'=>'save-copy-site-inspection'
]); 

//jesser save and publish from draft without added files cbpi
Route::post('/publishdraftwoutfilescbpi',[
	'uses'=>'AdminEditInspectionController@postCBPIDataFromDraftWoutFiles',
	'as'=>'publishdraftwoutfilescbpi'
]); 

//jesser save and publish from draft cbpi
Route::post('/edited-draft-inspection-cbpi',[
	'uses'=>'AdminEditInspectionController@postCBPIDataFromDraft',
	'as'=>'edited-draft-inspection-cbpi'
]); 

//jesser save and publish from copy cbpi
Route::post('/save-copy-inspection-cbpi',[
	'uses'=>'AdminCopyInspectionController@postCBPIDataFromCopy',
	'as'=>'save-copy-inspection-cbpi'
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

Route::post('/deleteattachments-mrn',[
	'uses'=>'AdminAccountControllerDevMR@deleteAttachments',
	'as'=>'deleteattachments-mrn'
]);

//jesser save as draft cbpi
Route::post('/savedraftinspectioncbpi',[
	'uses'=>'AdminEditInspectionController@saveDraftInspectionCbpi',
	'as'=>'savedraftinspectioncbpi'
]); 

Route::get('/panel/{id}',[
	'uses'=>'AdminAccountController@getDashboardPanel',
	'as'=>'panel',

]);

Route::get('/panel-dev/{id}',[
	'uses'=>'AdminAccountController@getDashboardPanelDev',
	'as'=>'panel-dev',

]);


Route::get('/template',[
    'uses'=>'AdminAccountController@getTemplateForm',
    'as'=>'template',
]);

//Request IOS App Form
Route::get('/request-app',[
    'uses'=>'EmailController@getRequestForm',
    'as'=>'request-app',
]);

//Request IOS App Form Submit
Route::post('/request-app/submit',[
    'uses'=>'EmailController@SubmitRequestForm',
    'as'=>'request-app-submit',
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

Route::get('/project-mrn',[
	'uses'=>'AdminAccountControllerDevMR@getInspectionProjectForm',
	'as'=>'project-mrn',
]);

//jesser edit-project
Route::get('/edit-project/{inspection_id}',[
	'uses'=>'AdminEditInspectionController@getInspectionProjectFormEdit',
	'as'=>'edit-project',
]);
//05-19-2021
Route::get('/edit-project-mrn/{inspection_id}',[
	'uses'=>'AdminEditInspectionControllerDevMR@getInspectionProjectFormEdit',
	'as'=>'edit-project-mrn',
]);

//jesser admin copy project psi
Route::get('/copy-project-admin/{inspection_id}',[
'uses'=>'AdminCopyInspectionController@getInspectionProjectFormCopyAdmin',
	'as'=>'copy-project-admin',
]);

//jesser admin copy project psi
Route::get('/copy-project-cbpi-admin/{inspection_id}',[
	'uses'=>'AdminCopyInspectionController@getInspectionProjectFormCopyAdminCbpi',
	'as'=>'copy-project-cbpi-admin',
]);


//jesser release client order
Route::get('/release-client-order/{inspection_id}',[
	'uses'=>'ReleaseClientOrderController@getInspectionProjectFormClientOrder',
	'as'=>'release-client-order',
]);
//06-03-2021
Route::get('/release-client-order-mrn/{inspection_id}',[
	'uses'=>'ReleaseClientOrderControllerMrn@getInspectionProjectFormClientOrder',
	'as'=>'release-client-order-mrn',
]);

Route::get('/release-client-order-loading/{inspection_id}',[
	'uses'=>'ReleaseClientOrderController@getInspectionProjectFormLoadingClientOrder',
	'as'=>'release-client-order-loading',
]);

//copy client order

Route::get('/copy-client-order/{inspection_id}',[
	'uses'=>'CopyClientOrderController@getInspectionProjectFormClientOrder',
	'as'=>'copy-client-order',
]);

Route::get('/copy-client-order-loading/{inspection_id}',[
	'uses'=>'CopyClientOrderController@getInspectionProjectFormLoadingClientOrder',
	'as'=>'copy-client-order-loading',
]);

Route::post('/copy-order-client-save',[
	'uses'=>'CopyClientOrderController@copyClientOrder',
	'as'=>'copy-order-client-save'
]);

Route::post('/copy-order-client-save-cbpi',[
	'uses'=>'CopyClientOrderController@copyClientOrderLoading',
	'as'=>'copy-order-client-save-cbpi'
]);


//jesser edit-project-cbpi
Route::get('/edit-project-cbpi/{inspection_id}',[
	'uses'=>'AdminEditInspectionController@getInspectionProjectFormEditCbpi',
	'as'=>'edit-project-cbpi',
]);

//jesser edit-project-site new api
Route::get('/edit-project-site/{inspection_id}',[
	'uses'=>'AdminEditInspectionController@getInspectionProjectFormEditSite',
	'as'=>'edit-project-site',
]);


//jesser copy project sit
Route::get('/copy-project-site-admin/{inspection_id}',[
	'uses'=>'AdminCopyInspectionController@getInspectionProjectFormCopySite',
	'as'=>'copy-project-site-admin',
]);


//jesser
Route::get('/getclientcountinspection/{id}',[
	'uses'=>'AdminAccountController@getCountInspection',
	'as'=>'getclientcountinspection',
]);

Route::get('/getclientcountinspection-new/{id}/{inspect_date?}',[
	'uses'=>'ReferenceNumberController@getReferenceNumber',
	'as'=>'getclientcountinspection-new',
]);

Route::get('/getclientdbcountinspection-new/{id}/{inspect_date?}',[
	'uses'=>'ReferenceNumberController@getReferenceNumber',
	'as'=>'getclientdbcountinspection-new',
]);

Route::get('/getclient-refnum/{id}/{inspect_date?}',[
	'uses'=>'ReferenceNumberController@getClientDBCountInspection',
	'as'=>'getclient-refnum',
]);

Route::get('/getclientcountinspectiondev/{id}',[
	'uses'=>'DevController@getCountInspectionDev',
	'as'=>'getclientcountinspectiondev',
]);

//jesser get product
Route::get('/getproductbyclientcode/{id}',[
	'uses'=>'AdminAccountController@getProductByCode',
	'as'=>'getproductbyclientcode',
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
//Inspector Username and Password
Route::get('/get-inspector-fm-account/{id}', [
	'uses'=>'AdminAccountController@getInspectorFMAccount',
	'as'=>'get-inspector-fm-account'
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



Route::get('/newclients',[
	'uses'=>'ClientController@getNewClients',
	'as'=>'newclients',

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


Route::post('/getProductPhoto',[
	'uses'=>'ClientAccountController@getProductPhoto',
	'as'=>'getProductPhoto'
]);

Route::post('/deleteclient',[
	'uses'=>'ClientController@deleteClient',
	'as'=>'deleteclient'
]);

Route::post('/updateclient',[
	'uses'=>'ClientController@updateClient',
	'as'=>'updateclient'
]);



Route::post('/updatenewclient',[
	'uses'=>'ClientController@updateNewClient',
	'as'=>'updatenewclient'
]);

Route::post('/rejectclient',[
	'uses'=>'ClientController@rejectClient',
	'as'=>'rejectclient'
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
///////06-18-2021 Sales Manager By Migz
Route::get('/sales-manager',[
	'uses'=>'SalesManagerController@getSalesManager',
	'as'=>'sales-manager',
]);
Route::post('/newsales',[
	'uses'=>'SalesManagerController@postNewSales',
	'as'=>'newsales'
]);
Route::post('/SalesUsernameDataNew',[
	'uses'=>'SalesManagerController@getSalesUsernameDataNew',
	'as'=>'SalesUsernameDataNew',
]);
Route::post('/salesDataNew',[
	'uses'=>'SalesManagerController@getSalesDataNew',
	'as'=>'salesDataNew',
]);
Route::get('/getonesales/{id}',[
	'uses'=>'SalesManagerController@getOneSales',
	'as'=>'getonesales',
]);
Route::post('/updatesales',[
	'uses'=>'SalesManagerController@updateSales',
	'as'=>'updatesales'
]);
Route::post('/deletesales',[
	'uses'=>'SalesManagerController@deleteSales',
	'as'=>'deletesales'
]);
//---end--//

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
	'uses'=>'AdminFactoryController@AddMoreFctoryContact',
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
	'uses'=>'AdminAccountController@getInspectionDetails',
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

//migz supplier get product 04-13-2021
Route::post('/selectproductnew',[
	'uses'=>'SupplierAccountController@getProductNew',
	'as'=>'selectproductnew'
]);
//migz get supplier product 04-13-2021
Route::get('/getsupplierproductbyclientcode/{id}',[
	'uses'=>'SupplierAccountController@getSupplierProductByCode',
	'as'=>'getsupplierproductbyclientcode',
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
	Route::post('client','APIController@getClientInformation');
	Route::get('project-details-client/{id}','APIController@getInspectionDetails');
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
	Route::post('log','ReportsController@createErrorLog');
	Route::post('report-photos','ReportsController@reportPhotos');
	Route::get('get-list-photos','ReportsController@getListPhotos');
	Route::post('report-sending','ReportsController@reportSending');
	Route::post('report-answers','ReportsController@reportAnswers');
	Route::post('geo-reporting','ReportsController@geoReporting');
	Route::post('report-status','ReportsController@reportStatus');
	Route::get('geo-reporting','ReportsController@getGeoReporting');
	Route::get('report-status','ReportsController@getReportStatus');
	Route::get('report-start-time','ReportsController@getReportStartTime');
	Route::get('report-end-time','ReportsController@getReportEndTime');
	Route::get('inspection-tracking/{id}','APIController@inspectionTracking');
	Route::get('contact-person/{code}','APIController@getContactPerson');
	Route::get('supplier/{code}','APIController@getSupplier');
	Route::get('supplier-contact/{supplier_id}','APIController@getSupplierContact');
	Route::get('factory/{supplier_id}','APIController@getFactory');
	Route::get('all-factory/{client_code}','APIController@getAllFactory');
	Route::get('factory-contact/{factory_id}','APIController@getFctoryContact');
	Route::get('product/{code}','APIController@getProducts');
	Route::post('create-booking','APIController@createBooking');
	Route::post('upload-attachments','APIController@uploadAttachments');
	Route::post('update-account-details','APIController@updateAccountDetails');
	Route::post('update-company-details','APIController@updateCompanyDetails');
	Route::post('update-invoice-details','APIController@updateInvoiceDetails');
	Route::post('update-aql-details','APIController@updateAqlDetails');
	Route::post('save-client-contact','APIController@saveClientContact');
	Route::post('delete-client-contact','APIController@deleteClientContact');
	Route::post('save-client-supplier','APIController@saveClientSupplier');
	Route::post('delete-client-supplier','APIController@deleteClientSupplier');
	Route::post('save-client-factory','APIController@saveClientFactory');
	Route::post('delete-client-factory','APIController@deleteClientFactory');
	Route::post('save-client-product','APIController@saveClientProduct');
	Route::post('save-client-images','APIController@saveClientProductImages');
	Route::post('delete-client-image','APIController@deleteClientProductImage');
	Route::post('delete-client-product','APIController@deleteClientProduct');
	Route::post('delete-client-supplier-contact','APIController@deleteClientSupplierContact');
	Route::post('delete-client-factory-contact','APIController@deleteClientFactoryContact');
	Route::get('category/{id}','APIController@getCategories');
	Route::post('sub-category','APIController@getSubCategories');
});
Route::get('report/{id}',[
	'uses'=>'SendReportController@downloadReport',
	'as'=>'report'
]);



/* Route::get('loadingreport/{id}',[
	'uses'=>'SendReportFinal@SendReposrtFinal',
	'as'=>'SendReportFinal'
]); */





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
//migz get part number 07-13-2021
Route::get('/getpartnumberbypstcode/{id}',[
	'uses'=>'InspectorAccountController@getPartNumberByPstCode',
	'as'=>'getpartnumberbypstcode',
]);
//migz get part number 07-13-2021
Route::post('/selectpartnumber',[
	'uses'=>'InspectorAccountController@getPartNumber',
	'as'=>'selectpartnumber'
]);







