<?php

namespace App\Manager;

use \App;


class PostManager
{

    protected $request;


    public function __construct($request)
    {
        $this->request = $request;
        $this->post = App::getInstance()->getTable('post');
    }

    public function update($post_id)
    {
        $post = [
            'title' => $this->request->getPostValue('title'),
            'content' => $this->request->getPostValue('content'),
            'category_id' => $this->request->getPostValue('category_id')
        ];
        return $this->post->update($post_id, $post);
    }
}
