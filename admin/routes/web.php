<?php
date_default_timezone_set('Asia/Kolkata');

Route::get('/', function () {
	if(empty(session()->get('userdata')))
	{
		return view('login');
	}
	else
	{
		return redirect('dashboard');
	}
    
});

Auth::routes();

//////////routing////////////
Route::post('/Login','DefaultController@do_login');
Route::any('/logout','DefaultController@logout');
Route::post('/update-password','DefaultController@updatepassword');
Route::any('/session-check','DefaultController@sessioncheck');


Route::get('/dashboard', 'HomeController@index');
Route::get('/default/{data}','HomeController@default');
Route::post('/changestatus','HomeController@changestatus');


Route::any('/add-category','HomeController@addcategory');
Route::any('/edit-category/{data}','HomeController@editcategory');
Route::any('/update-category','HomeController@updatecategory');

Route::any('/add-subcategory','HomeController@addsubcategory');
Route::any('/edit-subcategory/{data}','HomeController@editsubcategory');
Route::any('/update-subcategory','HomeController@updatesubcategory');


Route::any('/add-department','HomeController@adddepartment');
Route::any('/edit-department/{data}','HomeController@editdepartment');
Route::any('/update-department','HomeController@updatedepartment');

Route::any('/add-banner','HomeController@addbanner');
Route::any('/edit-banner/{data}','HomeController@editbanner');
Route::any('/update-banner','HomeController@updatebanner');

Route::any('/add-emailsettings','HomeController@addemailsettings');
Route::any('/edit-emailsettings/{data}','HomeController@editemailsettings');
Route::any('/update-emailsettings','HomeController@updateemailsettings');

Route::any('/add-smssettings','HomeController@addsmssettings');
Route::any('/edit-smssettings/{data}','HomeController@editsmssettings');
Route::any('/update-smssettings','HomeController@updatesmssettings');

Route::any('/add-blog','HomeController@addblog');
Route::any('/edit-blog/{data}','HomeController@editblog');
Route::any('/update-blog','HomeController@updateblog');

Route::any('/add-blog_category','HomeController@addblog_category');
Route::any('/edit-blog_category/{data}','HomeController@editblog_category');
Route::any('/update-blog_category','HomeController@updateblog_category');

Route::any('/add-testimonial','HomeController@addtestimonial');
Route::any('/edit-testimonial/{data}','HomeController@edittestimonial');
Route::any('/update-testimonial','HomeController@updatetestimonial');

Route::any('/add-user','HomeController@adduser');
Route::any('/edit-user/{data}','HomeController@edituser');
Route::any('/update-user','HomeController@updateuser');

Route::any('/add-customer','HomeController@addcustomer');
Route::any('/edit-customer/{data}','HomeController@editcustomer');

Route::any('/add-vendor','HomeController@addvendor');
Route::any('/edit-vendor/{data}','HomeController@editvendor');

Route::any('/add-user','HomeController@adduser');
Route::any('/edit-user/{data}','HomeController@edituser');
Route::any('/update-user','HomeController@updateuser');


Route::any('/add-task','HomeController@addtask');
Route::any('/edit-task/{data}','HomeController@edittask');
Route::any('/update-task','HomeController@updatetask');

Route::any('/edit-completedtasks/{data}','HomeController@editcompletedtasks');
Route::any('/edit-inprocesstasks/{data}','HomeController@editinprocesstasks');
Route::any('/edit-acceptedtasks/{data}','HomeController@editacceptedtasks');
Route::any('/edit-paidtasks/{data}','HomeController@editpaidtasks');
Route::any('/edit-pendingtasks/{data}','HomeController@editpendingtasks');
Route::any('/edit-startedtasks/{data}','HomeController@editstartedtasks');

Route::any('/add-images','HomeController@addimages');

Route::any('/latest-updates','HomeController@latest_updates');
Route::any('/add-update','HomeController@addupdate');


/////////////////////access///////////////////////////////

Route::any('/access-management','HomeController@access_management');
Route::any('/user_by_dept_id','HomeController@user_by_dept_id');
Route::any('/page_data','HomeController@page_data');

Route::post('/update-permission','HomeController@update_permission');

Route::any('/side-menus','HomeController@sidemenu');
Route::any('/add-side-menus','HomeController@addsidemenu');
Route::any('/edit-side-menus/{data}','HomeController@editsidemenu');
Route::any('/update-side-menu','HomeController@updatesidemenu');


Route::any('/status','HomeController@headstatus');

Route::any('/change-order-status','HomeController@change_order_status');

Route::any('/change-vendor-status','HomeController@change_vendor_status');

Route::any('/change-vendor-ticket','HomeController@change_vendor_ticket');


Route::any('/add-settlementreports','HomeController@addsettlementreports');

Route::any('/vendor-details','HomeController@vendor_details');
