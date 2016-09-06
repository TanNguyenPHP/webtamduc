<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 03-08-2016
 * Time: 12:01 PM
 */
namespace Coredev\Frontend\Controllers;

use Coredev\Modeldb\Entity\Contact;

class ContactController extends ControllerBase
{
    public function createAction()
    {
        $contact = new Contact();
        $contact->email = $this->request->getPost("emailcontact");
        $contact->name = $this->request->getPost("namecontact");
        $contact->content = $this->request->getPost("messagecontact");
        $contact->is_status = "0";
        $contact->date = date('YmdHis');
        if (!$contact->save()) {
            foreach ($contact->getMessages() as $message) {
                $this->flash->error($message);
            }

            return;
        }

        return $this->response->redirect('/index');
    }
}