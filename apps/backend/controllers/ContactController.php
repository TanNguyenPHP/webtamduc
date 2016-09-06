<?php
namespace Coredev\Backend\Controllers;

use Coredev\Modeldb\Entity\Contact;

class ContactController extends ControllerBase
{
    public function indexAction()
    {
        $data = Contact::find();

        return $this->view->data = $data;
    }

    public function changestatusAction()
    {
        $id = $this->request->getPost("id");
        $contact = Contact::findFirstByid($id);
        $contact->is_status = '1';
        try {

            if (!$contact->save()) {
                foreach ($contact->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this::sendText('Lỗi');
            }
        } catch (Exception $e) {
            return $this::sendText('Lỗi');
        }
        $data = "fa fa-check-circle";
        return $this::sendText($data);
    }
}