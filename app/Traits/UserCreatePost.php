<?php 

namespace App\Traits;

use App\Models\Post;

trait UserCreatePost 
{
    public function createPosts($postData)
    {
        Post::insert($postData);
    }

}
