<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 16-07-2016
 * Time: 4:23 PM
 */
namespace Coredev\Backend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
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
