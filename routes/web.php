<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Message;
use App\Mail\profileMail;
use App\Models\Conversation;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\ChatMessageEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* ************************************************************************ */

// Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
// Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// Route::get('/posts/{post_id}/edit', [PostController::class, 'edit'])->name('posts.edit');
// Route::put('/posts/{post_id}', [PostController::class, 'update'])->name('posts.update');

// Route::delete('/posts/{post_id}', [PostController::class, 'destroy'])->name('posts.destroy');

//home
Route::get('/', function(){
    $posts = Post::all();
    return view('index', compact('posts'));
})->name('home');

//plateform
Route::resource('posts', PostController::class);
Route::resource('users', UserController::class)->except(['create', 'store']);
Route::resource('comments', CommentController::class)->except(['index', 'show', 'edit', 'update']);

//login and sign up
Route::controller(AuthController::class)->group(function(){
    Route::name('login.')->group(function(){
        Route::get('/login','showLogin')->name('show');
        Route::post('/login','login')->name('login');
        Route::get('/logout','logout')->name('logout');
    });
    Route::name('register.')->group(function(){
        Route::get('/register','showRegister')->name('show');
        Route::post('/register','register')->name('register');
    });
    Route::get('/verify-email/{hash}','verifyEmail')->name('verification.verify');
});

//changing password
Route::name('forgot.')->group(function(){
    Route::controller(ForgotPasswordController::class)->group(function(){
        Route::get('/forgot-password', 'showForgotPassword')->name('show');
        Route::post('/forgot-password','getEmail')->name('get-email');
        Route::get('/forgot-password/{hash}', 'getNewPassword')->name('get-new-password'); //accessable trought email
        Route::put('/forgot-password', 'updatePassword')->name('update-password');
    });
});
Route::name('reset.')->group(function(){
    Route::controller(ResetPasswordController::class)->group(function(){
        Route::get('/change-password','getNewPassword')->name('get-new-password'); //accessable trought email
        Route::put('/change-password','updatePassword')->name('update-password');
    });
});

// websocket ===============================================

Route::get('/conversations', function(){
    $userId = auth()->user()->id;

    //order conversations by created at time and latest message
    $conversations = Conversation::select('conversations.id', 'conversations.user_id1', 'conversations.user_id2')
        ->leftJoin('messages', 'conversations.id', '=', 'messages.conversation_id')
        ->where('user_id1', $userId)
        ->orWhere('user_id2', $userId)
        ->groupBy('conversations.id', 'conversations.user_id1', 'conversations.user_id2')
        ->orderByRaw('COALESCE(MAX(messages.created_at), conversations.created_at) DESC')
        ->get();

    return view('conversations.index', compact('conversations'));
})->name('conversation.index')->middleware('auth');

Route::get('/chat/{uid}', function ($uid) {
    $user_id1 = auth()->user()->id;
    $user_id2 = (int)$uid;

    $user = User::findOrFail($user_id2);

    $conversation = Conversation::where([
        'user_id1' => min($user_id1, $user_id2),
        'user_id2' => max($user_id1, $user_id2),
    ])->first();
    
    if (!$conversation) {
        $conversation = Conversation::create([
            'user_id1' => min($user_id1, $user_id2),
            'user_id2' => max($user_id1, $user_id2),
        ]);
    }

    return redirect()->route('conversation', $conversation->id);
})->name('chat')->middleware('auth');

Route::get('/conversation/{cid}', function($cid){
    $conversation = Conversation::findOrFail($cid);
    
    $user_id1 = $conversation->user_id1;
    $user_id2 = $conversation->user_id2;
    $other_uid = ($user_id1 == auth()->user()->id) ? $user_id2 : $user_id1;
    $other = User::findOrFail($other_uid);

    $messages = $conversation->messages->sortBy('created_at');
       
    return view('websocket', compact('cid', 'messages', 'other'));
})->middleware(['auth', 'checkConversationAccess'])->name('conversation');


Route::post('/chat-message', function(Request $request){
    $validatedData = $request->validate([
        'message' => 'required|string',
        'cid' => 'required|exists:conversations,id',
    ]);    

    $content = $validatedData['message'];
    $conversation_id = $validatedData['cid'];
    $sender = auth()->user()->id;

    event(new ChatMessageEvent($content, $conversation_id, auth()->user()));

    Message::create(compact('conversation_id', 'sender', 'content'));

    return null;
})->middleware('auth');


// notification ===========================================

Route::get('/notifications', function(){
    $notifications = Notification::whereHas('post', function ($query) {
        $query->where('user_id', auth()->id());
    })->get();

    return view('notifications', compact('notifications'));
})->name('notification.index')->middleware('auth');