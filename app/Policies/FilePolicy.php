<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    public function modify(User $user, File $file): Response
    {
        return $user->id === $file->user_id
            ? Response::allow() :
            Response::deny('You suck');
    }
}
