<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user-logedd.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
