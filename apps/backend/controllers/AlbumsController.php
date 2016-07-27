<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 27-07-2016
 * Time: 6:01 PM
 */
namespace Coredev\Backend\Controllers;

use Coredev\Modeldb\Entity\Albums;
use Coredev\Commons\ParamsConstant as params;
use Coredev\Commons\RemoveUnicode;
class AlbumsController extends ControllerBase
{
    public function indexAction()
    {
        $limit = '50';
        $filter = '';
        if (isset($_GET["limit"]))
            $limit = $_GET["limit"];
        if (isset($_GET["filter"]))
            $filter = $_GET["filter"];

        return $this->view->data = array("data" => Albums::findAlbumsPaging($filter, "1", $limit),
            "limit" => $limit,
            "filter" => $filter);
    }

    public function newAction()
    {

    }

    public function createAction()
    {
        $album = new Albums();

        $album->name = $this->request->getPost("title");
        $folder = RemoveUnicode::stripUnicode($album->name);
        $dir = params::pathfolderpicture . $folder;
        $result = parent::createFolder($dir);
        $is_website = isset($_POST["website"]) ? '1' : '0';
        if ($result == 1) {
            $album->folder = $folder;
            $album->dir = $dir;
            $album->desc = $this->request->getPost("description");
            $album->datecreate = date('YmdHis');
            $album->is_del = '0';
            $album->is_website = $is_website;
            if ($album->save())
                return $this->response->redirect('/backend/albums/index');
        } else if ($result == 0 || $result == 3) {
            $this->flash->error("Không tạo folder");
            return $this->dispatcher->forward('/backend/albums/index');
        } else if ($result == 2) {
            $this->flash->error("Folder đã được tạo");
            return $this->dispatcher->forward('/backend/albums/index');
        }
    }
    public function delAction()
    {
        $id = $this->request->getPost("id");
        $album = Albums::findFirstByid($id);
        $album->is_del = '1';
        if (!$album) {
            $this->flash->error("Album không tồn tại");

            $this->dispatcher->forward(array(
                'controller' => "album",
                'action' => 'index'
            ));

            return;
        }
        try {

            if (!$album->save()) {
                foreach ($album->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('fa fa-times');
            }
        } catch (Exception $e) {
            return $this::sendText('fa fa-times');
        }

        return $this::sendText('fa fa-check-circle');
    }
}