<?php

namespace Coredev\Frontend\Controllers;

use Coredev\Modeldb\Entity\Posts;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $posts = Posts::findPosts("", "1", "1");
        return $this->view->data = array("posts" => $posts);
    }

}

