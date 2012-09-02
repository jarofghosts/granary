<?php

class Anonymous
{
	public static function post_list( $take = 15, $skip = 0 )
	{
		return Post::where('posts.active', '=', 1)
        ->left_join('categories', 'posts.category_id', '=', 'categories.id')
        ->left_join('users', 'posts.author_id', '=', 'users.id')
        ->where('categories.access_required', '=', 0)
        ->order_by('posts.created_at', 'desc')
        ->take($take)
        ->skip($skip)
        ->get(array('posts.*'));
	}
}