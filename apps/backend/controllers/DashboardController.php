<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 17-07-2016
 * Time: 11:11 AM
 */
namespace Coredev\Backend\Controllers;

use Coredev\Modeldb\Entity\Webconfig;

class DashboardController extends ControllerBase
{

    public function indexAction()
    {
        return $this->view->data = $this::LoadWebConfig();
    }

    public function saveconfigAction()
    {
        $config = $this::LoadWebConfig();

        if (!$config) {
            $this->flash->error("Cấu hình không tồn lại");

            $this->dispatcher->forward(array(
                'controller' => "webconfig",
                'action' => 'index'
            ));

            return;
        }

        $config->title = $this->request->getPost("title");
        $config->meta = $this->request->getPost("description");
        $config->address = $this->request->getPost("address");
        $config->companyname = $this->request->getPost("companyname");
        $config->cellphone = $this->request->getPost("cellphone");
        $config->email = $this->request->getPost("email");
        $config->facebook = $this->request->getPost("facebook");
        $config->fax =$this->request->getPost("fax");

        if (!$config->save()) {

            foreach ($config->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "webconfig",
                'action' => 'edit',
                'params' => array($config->id_lang)
            ));

            return;
        }

        $this->flash->success("Đã lưu");
        $this->dispatcher->forward(array(
            'controller' => "dashboard",
            'action' => 'index'
        ));
        //return $this->response->redirect('/backend/dashboard/index');
    }

    private function LoadWebConfig()
    {
        $webconfig = Webconfig::findFirst();
        return $webconfig;
    }
}
