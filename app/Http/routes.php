<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
 * 前台页面路由
 * */

Route::group(['namespace'=> 'View'],function (){
    Route::get('/', 'IndexController@index');
    Route::get('/login','MemberController@toLogin');
    Route::get('/register','MemberController@toRegister');
    Route::get('/product/detail/{id}', 'ProductController@show');
    Route::get('/category/{id}', 'CategoryController@index');
    Route::get('/buyOne/{product_id}/{num}', 'OrderController@buyOne')->middleware('checklogin');
    Route::post('/buy', 'OrderController@buy')->middleware('checklogin');
    Route::get('/tobuy', 'OrderController@toBuy')->middleware('checklogin');
    Route::get('/orders', 'OrderController@index')->middleware('checklogin');
    Route::post('/receipt', 'OrderController@receipt');
    Route::get('/pay', 'OrderController@toPay')->middleware('checklogin');
    Route::get('/pay/{no}', 'OrderController@toPay_no')->middleware('checklogin');
    Route::get('/order/detail/{id}', 'OrderController@toDetail')->middleware('checklogin');
    Route::get('/cart', 'CartController@index');
    Route::get('/myinfo', 'MyinfoController@index')->middleware('checklogin');
    Route::get('/review/{id}', 'OrderController@orderReview')->middleware('checklogin');
    Route::get('/toInfo', 'MyinfoController@toInfo')->middleware('checklogin');
    Route::get('/repassword', 'MyinfoController@toRestPassword')->middleware('checklogin');

});



/*
 *  前台接口路由
 */
Route::group(['namespace'=>'Service', 'prefix'=>'service'],function(){
    Route::get('validate/sendSMS','ValidateController@sendSMS');
    Route::post('register', 'MemberController@register');
    Route::post('login','MemberController@login');
    Route::get('logout','MemberController@logout');
    Route::get('validate_email', 'ValidateController@validateEmail');
    Route::post('search', 'IndexController@search');
    Route::get('cart/add/{id}', 'CartController@addCart');
    Route::post('/getCartnum', 'CartController@getCartnum');
    Route::post('/addCartSession', 'CartController@addCartSession');
    Route::get('/cart/delete', 'CartController@destroy');
    Route::post('/pay', 'PayController@alipay');
    Route::post('/payagain', 'PayController@alipay_again');
    Route::post('/pay/notify', 'PayController@notify');
    Route::get('/pay/call_back', 'PayController@call_back');
    Route::post('/review', 'OrderController@review');
    Route::post('editInfo','MemberController@editInfo');
    Route::post('/confimpassword','MemberController@confimpassword');
    Route::post('/changepassword','MemberController@changepassword');



});



/*
 * 公共路由
 * */
//文件上传接口，前后台共用
Route::post('uploadImg', 'PublicController@uploadImg');
Route::post('deleteImg','PublicController@deleteImg');
Route::post('deleteImg_database/{id}', 'PublicController@deleteImg_database');

/*
 * 后台公共路由
 * */
Route::group(['namespace'=>'Admin', 'prefix'=>'admin'], function (){
    Route::get('/login','LoginController@index');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');

});



Route::group(['namespace'=>'Admin', 'prefix'=>'admin','middleware'=>'auth'], function () {
    Route::get('/','IndexController@toIndex');
    Route::get('welcome','IndexController@toWelcome');


});

/*
 * 系统管理
 * */
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', 'middleware'=> ['role:root,'] ],function(){

    //角色管理
    Route::get('role','RoleController@index');
    Route::get('getrolelist', 'RoleController@getRoleList');
    Route::get('role_edit', 'RoleController@edit');
    Route::post('role_update','RoleController@update');
    Route::get('role/{id}/permission','RoleController@permission');
    Route::get('role_create','RoleController@create');
    Route::post('role_add', 'RoleController@store');
    Route::post('/role/destroy', 'RoleController@destroy');
    Route::put('role_permission/update/{id}','RoleController@permission_update');

    //权限管理
    Route::get('permission','PermissionController@index');
    Route::get('getpermission_list', 'PermissionController@getPermissionList');
    Route::get('permission_create', 'PermissionController@create');
    Route::post('permission_add', 'PermissionController@store');
    Route::get('permission/{id}/edit','PermissionController@edit');
    Route::post('permission_update', 'PermissionController@update');

});

Route::group(['namespace'=>'Admin', 'prefix'=> 'admin', 'middleware'=>['permission:member.manage'] ],function (){
    //会员管理
    Route::get('member_list','MemberController@toMember_list');
    Route::get('delmembers_list','MemberController@todelMembers_list');
    Route::get('getmember_list','MemberController@getMemberList');
    Route::get('getdelmember_list','MemberController@getdelMembersList');
    Route::post('changememberstatus','MemberController@changeMemberStatus');
    Route::get('member_edit','MemberController@member_edit');
    Route::post('member_change','MemberController@edit');
    Route::post('member_del', 'MemberController@delMember');
    Route::post('member_restore', 'MemberController@member_restore');
});


//用户管理
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', 'middleware'=>['permission:system.user'] ], function (){
    Route::get('user','UserController@index')->middleware('permission:system.user');
    Route::get('getuserlist', 'UserController@getUserList')->middleware('permission:system.user');
    Route::post('changeuserstatus','UserController@changeUserStatus')->middleware('permission:system.user.edit');
    Route::get('user_edit','UserController@show_edit')->middleware('permission:system.user.edit');
    Route::post('user_update','UserController@update')->middleware('permission:system.user.edit');
    Route::get('user_role/{id}', 'UserController@show_userrole');
    Route::get('user_create', 'UserController@create')->middleware('permission:system.user.create');
    Route::post('user_store', 'UserController@store')->middleware('permission:system.user.create');
    Route::post('user_del', 'UserController@del')->middleware('permission:system.user.del');
    Route::get('user_permission', 'UserController@permission');
    Route::put('user/roleupdate/{id}', 'UserController@role');

});

//分类管理
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', 'middleware'=>['permission:category.manage']], function (){
    Route::get('category', 'CategoryController@index')->middleware('permission:category.manage.list');
    Route::get('category_list', 'CategoryController@getCategorylist');
    Route::get('category_create', 'CategoryController@create')->middleware('permission:category.create');
    Route::post('category_add', 'CategoryController@store');
    Route::get('category/edit/{id}', 'CategoryController@edit')->middleware('permission:category.edit');
    Route::post('category/update/{id}', 'CategoryController@update');
    Route::post('category/delete/{id}', 'CategoryController@destroy')->middleware('permission:category.del');
});


//商品管理
Route::group(['namespace'=>'Admin', 'prefix'=>'admin','middleware'=>['permission:product.manage'] ], function (){
    Route::get('product', 'ProductController@index');
    Route::get('getproductlist', 'ProductController@getProductList');
    Route::get('product_create', 'ProductController@create');
    Route::post('product_add', 'ProductController@store');
    Route::get('product/edit/{id}', 'ProductController@edit');
    Route::post('product/update/{id}', 'ProductController@update');
    Route::post('product/delete/{id}', 'ProductController@destroy');
});

//订单管理
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', ], function (){
    Route::get('order', 'OrderController@index');
    Route::get('getorderlist', 'OrderController@getOrderList');
    Route::get('order/edit/{id}', 'OrderController@edit');
    Route::get('order/show/{id}', 'OrderController@show');
    Route::post('order/update/{id}', 'OrderController@update');
});

//站点管理
Route::group(['namespace'=>'Admin', 'prefix'=>'admin', ], function (){
    Route::get('site', 'SiteController@index');
    Route::get('siteimage', 'SiteController@siteimage');
    Route::get('getsiteimageList', 'SiteController@getsiteimageList');
    Route::get('siteimage/create','SiteController@siteimagecreate');
    Route::post('siteimage/add', 'SiteController@siteimagestore');
    Route::post('siteimage/delete', 'SiteController@siteimagedestroy');
});

Route::group(['namespace'=>'Admin', 'prefix'=>'admin',],function (){
    Route::get('comment','CommentController@index');
    Route::get('gtcommentlist','CommentController@getCommentList');
});
