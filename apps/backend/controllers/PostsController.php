<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 21-07-2016
 * Time: 4:06 PM
 */
namespace Coredev\Backend\Controllers;

use Coredev\Modeldb\Entity\Posts;
use Coredev\Modeldb\Entity\Typespost;
use Coredev\Commons\UtilsSEO;
use Coredev\Commons\ParamsConstant as Params;
use Phalcon\Di;

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

        $data = Posts::findPostsPaging($title, '', '', 1, $limit);
        return $this->view->data = array('data' => $data,
            'limit' => $limit,
            'filter' => $title);
    }

    public function newAction()
    {
        return $this->view->data = Typespost::findAll('1');

    }

    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $post = Posts::findFirstByid($id);
            if (!$post) {
                $this->flashSession->error("post was not found");
                return $this->response->redirect('/backend/posts/index');
            }

            $this->view->data = array("post" => $post, "typeposts" => Typespost::findAll('1'));
        }
    }

    public function saveAction()
    {
        $post = Posts::findFirstByid($this->request->getPost('id'));
        if (!$post) {
            $this->flashSession->error("Bài viết không tồn tại");
            return $this->response->redirect('/backend/news/index');
        }

        $post->title = $this->request->getPost('title');
        $post->content_short = $this->request->getPost('content_short');
        $post->content = $this->request->getPost('content');
        $post->position = $this->request->getPost('position');
        $post->id_typespost = $this->request->getPost('id_typespost');
        $post->seo_title = $this->request->getPost('seo_title');
        $post->seo_desc = $this->request->getPost('seo_desc');
        $post->datecreate = date('YmdHis');
        $post->id_user = Di::getDefault()->getSession()->get('sessionUser');
        //$post->slug = UtilsSEO::CreateSlug($post->title) . '-' . date('YmdHis');
        try {
            if (isset($_FILES['avatar_image'])) {
                if ($_FILES['avatar_image']['size'] != 0) {
                    $this::saveImg($_FILES['avatar_image']);
                    $post->avatar_image = Params::pathfolderavatarimage . $_FILES['avatar_image']['name'];
                }
            }
            if (!$post->save()) {
                foreach ($post->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward(array(
                    'controller' => "posts",
                    'action' => 'index'
                ));
            }
        } catch (Exception $e) {
            $this->flash->error(var_dump($e));
            $this->dispatcher->forward(array(
                'controller' => "posts",
                'action' => 'index'
            ));
        }

        return $this->response->redirect('/backend/posts/index');
    }

    public function createAction()
    {

        $post = new Posts();
        $post->title = $this->request->getPost('title');
        $post->content_short = $this->request->getPost('content_short');
        $post->content = $this->request->getPost('content');
        $post->position = $this->request->getPost('position');
        $post->id_typespost = $this->request->getPost('id_typespost');
        $post->seo_title = $this->request->getPost('seo_title');
        $post->seo_desc = $this->request->getPost('seo_desc');
        $post->datecreate = date('YmdHis');
        $post->id_user = Di::getDefault()->getSession()->get('sessionUser');
        $post->is_del = '0';
        $post->is_status = '1';
        $post->is_home = '1';
        $post->slug = UtilsSEO::CreateSlug($post->title) . '-' . date('YmdHis');

        try {
            $this::saveImg($_FILES['avatar_image']);
            $post->avatar_image = Params::pathfolderavatarimage . $_FILES['avatar_image']['name'];
            if (!$post->save()) {
                foreach ($post->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->dispatcher->forward(array(
                    'controller' => "news",
                    'action' => 'new'
                ));
            }
        } catch (Exception $e) {
            $this->flash->error(var_dump($e));
            $this->dispatcher->forward(array(
                'controller' => "news",
                'action' => 'new'
            ));
        }

        return $this->response->redirect('/backend/posts/index');
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

    private function saveImg($file)
    {
        $target = join(DIRECTORY_SEPARATOR, array(Params::folderimg, Params::folderimgavatar, basename($file['name'])));
        $this::saveFile($file['tmp_name'], $target);
    }
}