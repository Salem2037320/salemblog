<?php

use App\Http\Controllers\Api\PostController;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('post/{id}', function ($id) {
    $element = Post::whereId($id)->with('comment', 'user')->first();
    return response()->json($element, 200);
});

Route::resource('post', PostController::class);

Route::get('comment', function () {
    $posts = Comment::simplePaginate(50);
    return response()->json($posts, 200);
});
