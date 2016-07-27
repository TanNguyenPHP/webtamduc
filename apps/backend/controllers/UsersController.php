<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 19-07-2016
 * Time: 11:43 AM
 */
namespace Coredev\Backend\Controllers;

use Coredev\Modeldb\Entity\Users;
use Coredev\Modeldb\Entity\RoleGroup;
use Phalcon\Mvc\Controller;
use Coredev\Commons\SecuritySystem;
use Phalcon\Di;

class UsersController extends ControllerBase
{
    public function indexAction()
    {
        $limit = 50;
        $filter = "";
        if (isset($_GET["limit"]))
            $limit = $_GET["limit"];
        if (isset($_GET["filter"]))
            $filter = $_GET["filter"];

        return $this->view->data = array('data' => Users::findUsersPaging($filter, 1, $limit),
            'limit' => $limit,
            'filter' => $filter,
            'rolegroup' => RoleGroup::find());
    }

    public function newAction()
    {
        return $this->view->data = array('rolegroup' => RoleGroup::find());
    }

    public function changeactiveAction()
    {
        $id = $this->request->getPost("id");
        $user = Users::findFirstByid($id);
        if ($user->is_active == '0')
            $user->is_active = '1';
        else
            $user->is_active = '0';
        try {

            if (!$user->save()) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('Lỗi');
            }
        } catch (Exception $e) {
            return $this::sendText('Lỗi');
        }
        $data = "fa fa-check-circle";
        if ($user->is_active == '0')
            $data = 'fa fa-times';


        return $this::sendText($data);
    }

    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'create'
            ));

            return;
        }

        $users = Users::findFirstByusername($this->request->getPost("username"));
        if ($users) {
            $this->flash->error("Trùng tên đăng nhập");
            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'new'
            ));
            return;
        }
        $user = new Users;
        $user->username = $this->request->getPost("username");
        $user->password = SecuritySystem::HashPassword($this->request->getPost("password"));
        $user->name = $this->request->getPost("name");
        $user->datecreate = date('YmdHis');
        $user->is_active = isset($_POST["is_active"]) ? '1' : '0';
        $user->is_del = '0';
        $user->id_group = $this->request->getPost("id_group");

        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'new'
            ));

            return;
        }

        return $this->response->redirect('/backend/users/index');
    }
    public function changepasswordAction()
    {

    }
    public function savepassAction()
    {
        $id = Di::getDefault()->getSession()->get('sessionUser');
        $user = Users::findFirstByid($id);
        $passold = $_POST['oldpass'];
        if (SecuritySystem::CheckHashPassword($passold,$user->password)) {
            $user->password = SecuritySystem::HashPassword($_POST['newpass']);
            $user->save();
            $this->flash->success("Mật khẩu được thay đổi");
            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'changepassword'
            ));
        } else {
            $this->flash->error("Mật khẩu cũ sai");
            $this->dispatcher->forward(array(
                'controller' => "users",
                'action' => 'changepassword'
            ));
        }
    }
    public function logoffAction()
    {
        $this->session->destroy();
        return $this->response->redirect('/quanly');
    }
}