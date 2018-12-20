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
use Illuminate\Http\Request;
use App\Events\chatroom\UserLoginedEvent;
use App\Events\chatroom\UserSendMessageEvent;
use App\Events\chatroom\UserLogoutEvent;

Route::get('/', function (Request $request) {
    $needSendCookie = false;

    if (! $request->session()->has('user')) {
        if ($userid = Cookie::get('userid')) {
            $username = Cookie::get('username');
        } else {
            $userid = uniqid();
            $username = '游客';

            $foreverCookie1 = Cookie::forever('userid', $userid);
            $foreverCookie2 = Cookie::forever('username', $username);

            //参数格式：$name, $value, $minutes
            $tempCookie = Cookie::make('userip', $request->ip(), 5);
            
            $needSendCookie = true;
        }

        session([
            'user' => [
                'id' => $userid,
                'name' => $username
            ]
        ]);

        $userinfo = [
            'id' => $userid,
            'name' => $username,
            'ip' => $request->ip()
        ];
        event(new UserLoginedEvent('public', $userinfo));
    } else {
        if (! Cookie::get('userid')) {
            $userid = session('user.id');
            $username = session('user.name');

            $foreverCookie1 = Cookie::forever('userid', $userid);
            $foreverCookie2 = Cookie::forever('username', $username);

            //参数格式：$name, $value, $minutes
            $tempCookie = Cookie::make('userip', $request->ip(), 5);
            
            $needSendCookie = true;
        } 
    }

    if ($needSendCookie) {
        return response()->view('index')
            ->withCookie($foreverCookie1)
            ->withCookie($foreverCookie2)
            ->withCookie($tempCookie);
    } else {
        return view('index');
    }
});
Route::post('/userlogin', function (Request $request) {
    
});
Route::post('/userlogout', function (Request $request) {
    $userid = session('user.id');
    $username = session('user.name');
    
    $userinfo = [
        'id' => $userid,
        'name' => $username,
        'ip' => $request->ip(),
    ];
    event(new UserLogoutEvent('public', $userinfo));
});
Route::post('/sendmessage', function (Request $request) {
    $userid = session('user.id');
    $username = session('user.name');
    
    $userinfo = [
        'id' => $userid,
        'name' => ($username == '') ? '游客' : $username,
        'ip' => $request->ip(),
    ];
    $message = $request->message;
    event(new UserSendMessageEvent('public', $userinfo, $message));
});
