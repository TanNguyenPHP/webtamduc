<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 04-08-2016
 * Time: 5:05 PM
 */
namespace Coredev\Frontend\Controllers;

use Coredev\Modeldb\Entity\Posts;

class PostsController extends ControllerBase
{
    public function detailAction($id)
    {
        $post = Posts::findFirstByslug("$id");
        if (!$post) {
            return $this->response->redirect('/index');
        }
        $this->tag->prependTitle($post->seo_title . " | ");
        self::setMetaDescription($post->seo_desc);
        return $this->view->data = $post;
    }
}