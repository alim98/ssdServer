<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'Api\AuthenticationController@login');
Route::post('logout', 'Api\AuthenticationController@logout');
Route::post('register', 'Api\RegisterController@register');

Route::resource('student', 'Api\StudentController');
Route::get('student/{id}/posts', 'Api\StudentController@get_posts');
Route::get('student/search/{keyword}', 'Api\StudentController@search');
Route::get('student/checkt/{id}', 'Api\StudentController@check_token');
Route::get('student/saved/{id}', 'Api\StudentController@get_saved_posts');
Route::get('student/stpub/{id}', 'Api\StudentController@get_public_info');

Route::resource('post', 'Api\PostController');
Route::get('student/{id}/followings/posts', 'Api\PostController@get_posts_of_followings');
Route::put('post/update_likes_count/{id}', 'Api\PostController@update_likes_count');
Route::get('post/comments/{id}', 'Api\PostController@get_comments');


//Route::resource('like', 'Api\LikeController');
Route::post('like', 'Api\LikeController@store');
Route::delete('like/{student_id}/{post_id}','Api\LikeController@destroy');
Route::get('like/{student_id}/{post_id}', 'Api\LikeController@is_liked');
Route::get('like/get_like/{student_id}/{post_id}','Api\LikeController@get_like' );


Route::get('like/comments/{id}', 'Api\LikeController@get_comments');

Route::post('follow', 'Api\FollowController@follow');
Route::delete('follow/{follower_id}/{following_id}', 'Api\FollowController@unfollow');
Route::get('followers/{id}', 'Api\FollowController@student_followers');
Route::get('followings/{id}', 'Api\FollowController@student_followings');
Route::get('follow/{follower_id}/{following_id}', 'Api\FollowController@is_followed');

Route::post('comment', 'Api\CommentController@store');
Route::delete('comment/{id}', 'Api\CommentController@delete');

Route::post('savedpost' , 'Api\SavedPostsController@store');
Route::delete('savedpost/{st_id}/{post_id}', 'Api\SavedPostsController@destroy');
Route::get('savedpost/check/{st_id}/{post_id}', 'Api\SavedPostsController@check');

Route::get('recent/{student_id}', 'Api\RecentController@get');

Route::get('university/{code}', 'Api\UniversityController@get_uni');
