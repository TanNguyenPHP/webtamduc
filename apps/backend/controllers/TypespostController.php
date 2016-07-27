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
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $typepost = Typespost::findFirstByid($id);
            if (!$typepost) {
                $this->flash->error("typepost was not found");
                return $this->response->redirect('/backend/typespost/index');
            }

            return $this->view->data =$typepost;
        }

    }
    public function newAction()
    {

    }
    public function saveAction()
    {
        $id = $this->request->getPost("idtypes");
        $typepost = Typespost::findFirstByid($id);

        if (!$typepost) {
            $this->flash->error("Không tìm thấy danh mục");

            $this->dispatcher->forward(array(
                'controller' => "typespost",
                'action' => 'index'
            ));

            return;
        }

        $typepost->name = $this->request->getPost("name");
        $typepost->position = $this->request->getPost("position");
        $typepost->seo_title = $this->request->getPost("seo_title");
        $typepost->seo_desc = $this->request->getPost("seo_desc");

        if (!$typepost->save()) {

            foreach ($typepost->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "typespost",
                'action' => 'edit',
                'params' => array($typepost->id)
            ));

            return;
        }

        $this->flash->success("Đã lưu");
        return $this->response->redirect('/backend/typespost/index');
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
        $typepost->is_status = "1";
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
    public function changehomeAction()
    {
        $id = $this->request->getPost("id");
        $typepost = Typespost::findFirstByid($id);
        if ($typepost->is_home == '0')
            $typepost->is_home = '1';
        else
            $typepost->is_home = '0';
        try {

            if (!$typepost->save()) {
                foreach ($typepost->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('Lỗi');
            }
        } catch (Exception $e) {
            return $this::sendText('Lỗi');
        }
        $data = "fa fa-check-circle";
        if ($typepost->is_home == '0')
            $data = 'fa fa-times';


        return $this::sendText($data);
    }
    public function changestatusAction()
    {
        $id = $this->request->getPost("id");
        $typepost = Typespost::findFirstByid($id);
        if ($typepost->is_status == '0')
            $typepost->is_status = '1';
        else
            $typepost->is_status = '0';
        try {

            if (!$typepost->save()) {
                foreach ($typepost->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('Lỗi');
            }
        } catch (Exception $e) {
            return $this::sendText('Lỗi');
        }
        $data = "fa fa-check-circle";
        if ($typepost->is_status == '0')
            $data = 'fa fa-times';


        return $this::sendText($data);
    }
}