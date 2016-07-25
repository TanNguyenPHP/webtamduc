<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 21-07-2016
 * Time: 4:06 PM
 */
namespace Coredev\Backend\Controllers;

use Coredev\Modeldb\Entity\Posts;

class PostsController extends ControllerBase
{
    public function indexAction()
    {
        $title = '';
        $limit = '50';
        if (isset($_GET["limit"]))
            $limit = $_GET["limit"];
        if (isset($_GET["filter"]))
            $title = $_GET["filter"];

        $data = Posts::findPostsPaging($title,'','',1,$limit);
        return $this->view->data = array('data' => $data,
            'limit' => $limit,
            'filter' => $title);
    }
    public function newAction()
    {

    }
    public function createAction()
    {

    }
    public function changestatusAction()
    {
        $id = $this->request->getPost("id");
        $post = Posts::findFirstByid($id);
        if ($post->is_status == '0')
            $post->is_status = '1';
        else
            $post->is_status = '0';
        try {

            if (!$post->save()) {
                foreach ($post->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('Lỗi');
            }
        } catch (Exception $e) {
            return $this::sendText('Lỗi');
        }
        $data = "fa fa-check-circle";
        if ($post->is_status == '0')
            $data = 'fa fa-times';


        return $this::sendText($data);
    }
    public function changehomeAction()
    {
        $id = $this->request->getPost("id");
        $post = Posts::findFirstByid($id);
        if ($post->is_home == '0')
            $post->is_home = '1';
        else
            $post->is_home = '0';
        try {

            if (!$post->save()) {
                foreach ($post->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('Lỗi');
            }
        } catch (Exception $e) {
            return $this::sendText('Lỗi');
        }
        $data = "fa fa-check-circle";
        if ($post->is_home == '0')
            $data = 'fa fa-times';


        return $this::sendText($data);
    }
}