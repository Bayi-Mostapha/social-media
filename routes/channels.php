<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence.chat.{id}', function ($user, $id) {
    $conversation = Conversation::findOrFail($id);

    if ($user->id === $conversation->user_id1 || $user->id === $conversation->user_id2) {
        return $user;
    }
});

Broadcast::channel('private.user.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});
