<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Frontend\IndexController@index')->name('index');

Auth::routes();
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->middleware('sms.check');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showPage')->name('password.request');
Route::post('/password/reset', 'Auth\ForgotPasswordController@handler')->middleware('sms.check');
Route::post('/sms/send', 'Frontend\SmsController@send')->name('sms.send');

Route::get('/courses', 'Frontend\CourseController@index')->name('courses');
Route::get('/course/{id}/{slug}', 'Frontend\CourseController@show')->name('course.show');
Route::get('/course/{course_id}/video/{id}/{slug}', 'Frontend\VideoController@show')->name('video.show');

Route::post('/subscription/email', 'Frontend\IndexController@subscriptionHandler')->name('subscription.email');

Route::get('/vip', 'Frontend\RoleController@index')->name('role.index');

Route::get('/faq', 'Frontend\FaqController@index')->name('faq');
Route::get('/faq/category/{id}', 'Frontend\FaqController@showCategoryPage')->name('faq.category.show');
Route::get('/faq/article/{id}', 'Frontend\FaqController@showArticlePage')->name('faq.article.show');

// 支付回调
Route::post('/payment/callback', 'Frontend\PaymentController@callback')->name('payment.callback');

Route::group([
    'prefix' => '/member',
    'middleware' => ['auth'],
    'namespace' => 'Frontend'
], function () {
    Route::get('/', 'MemberController@index')->name('member');

    Route::get('/password_reset', 'MemberController@showPasswordResetPage')->name('member.password_reset');
    Route::post('/password_reset', 'MemberController@passwordResetHandler');
    Route::get('/avatar', 'MemberController@showAvatarChangePage')->name('member.avatar');
    Route::post('/avatar', 'MemberController@avatarChangeHandler');
    Route::get('/join_role_records', 'MemberController@showJoinRoleRecordsPage')->name('member.join_role_records');
    Route::get('/messages', 'MemberController@showMessagesPage')->name('member.messages');
    Route::get('/courses', 'MemberController@showBuyCoursePage')->name('member.courses');
    Route::get('/course/videos', 'MemberController@showBuyVideoPage')->name('member.course.videos');
    Route::get('/orders', 'MemberController@showOrdersPage')->name('member.orders');

    Route::post('/course/{id}/comment', 'CourseController@commentHandler')->name('course.comment');
    Route::post('/video/{id}/comment', 'VideoController@commentHandler')->name('video.comment');

    Route::post('/upload/image', 'UploadController@imageHandler')->name('upload.image');

    Route::get('/recharge', 'PaymentController@index')->name('member.recharge');
    Route::post('/recharge', 'PaymentController@rechargeHandler');
    Route::get('/recharge/records', 'MemberController@showRechargeRecordsPage')->name('member.recharge_records');

    Route::get('/course/{id}/buy', 'CourseController@showBuyPage')->name('member.course.buy');
    Route::post('/course/{id}/buy', 'CourseController@buyHandler');

    Route::get('/video/{id}/buy', 'VideoController@showBuyPage')->name('member.video.buy');
    Route::post('/video/{id}/buy', 'VideoController@buyHandler');

    Route::get('/vip/{id}/buy', 'RoleController@showBuyPage')->name('member.role.buy');
    Route::post('/vip/{id}/buy', 'RoleController@buyHandler');
});