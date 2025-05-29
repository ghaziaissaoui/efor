<?php

namespace App\Core\Models;

use App\Core\Interfaces\ModelDefaultInterface;
use WP_Post;
use WP_User;

class UserModel implements ModelDefaultInterface
{
    public function findOneById(int $id): WP_User
    {
        return get_user_by('id', $id);
    }
}
