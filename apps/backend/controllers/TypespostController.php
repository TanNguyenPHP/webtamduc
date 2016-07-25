<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 25-07-2016
 * Time: 2:54 PM
 */
namespace Coredev\Backend\Controllers;

use Coredev\Modeldb\Entity\Typespost;

class TypespostController extends ControllerBase
{
    public function indexAction()
    {
        return $this->view->data = Typespost::findAll();
    }
    public function newAction()
    {

    }
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "typespost",
                'action' => 'create'
            ));

            return;
        }

        $typepost = new Typespost();
        $typepost->name = $this->request->getPost("name");
        $typepost->position = $this->request->getPost("position");
        $typepost->seo_title = $this->request->getPost("seo_title");
        $typepost->seo_desc = $this->request->getPost("seo_desc");
        $typepost->is_del = "0";
        $typepost->is_status = "0";
        $typepost->is_home = "0";

        if (!$typepost->save()) {
            foreach ($typepost->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "typespost",
                'action' => 'new'
            ));

            return;
        }

        return $this->response->redirect('/backend/typespost/index');
    }
}