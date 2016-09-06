<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 16-07-2016
 * Time: 4:23 PM
 */
namespace Coredev\Backend\Controllers;
use Coredev\Commons\Authentication;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function  initialize()
    {
        if (!Authentication::CheckAuth())
            return $this->response->redirect('/quanly');

    }
    protected final function createFolder($path)
    {
        try {
            if (!is_dir($path)) {
                if (mkdir($path))
                    return 1;//run on server linux add params 0777, true
                else
                    return 0;//not create folder
            }
            return 2;//exist
        } catch (Exception $e) {
            return 3;
        }

    }

    protected final function saveFile($path, $destination)
    {
        try {
            move_uploaded_file($path, $destination);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    protected function sendJson($data)
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent(json_encode($data));
        return $this->response;
    }
    protected function sendJsonNoConvert($data)
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent($data);
        return $this->response;
    }
    protected function sendText($data)
    {
        $this->view->disable();
        $this->response->setContentType('text/plain', 'UTF-8');
        $this->response->setContent($data);
        return $this->response;
    }
}
