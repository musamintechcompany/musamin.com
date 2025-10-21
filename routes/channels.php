<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = \App\Models\Conversation::find($conversationId);
    return $conversation && ($conversation->user_one_id === $user->id || $conversation->user_two_id === $user->id);
});

Broadcast::channel('App.Models.Admin.{id}', function ($admin, $id) {
    return (int) $admin->id === (int) $id;
});

Broadcast::channel('admin.{id}', function ($admin, $id) {
    return auth('admin')->check() && (int) auth('admin')->id() === (int) $id;
});

Broadcast::channel('affiliate.{id}', function ($user, $id) {
    return $user->isAffiliate() && (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = \App\Models\Conversation::find($conversationId);
    return $conversation && ($conversation->user_one_id === $user->id || $conversation->user_two_id === $user->id);
});
