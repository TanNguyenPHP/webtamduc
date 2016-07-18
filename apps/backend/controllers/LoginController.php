<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 16-07-2016
 * Time: 4:50 PM
 */
namespace Coredev\Backend\Controllers;

use Phalcon\Mvc\View;

class LoginController extends ControllerBase
{
    public function initialize()
    {
       /* $this->assets
            ->addJs('/js/jquery-1.12.4.min.js')
            ->addJs('/js/jquery.validate.min.js')
            ->addJs('/js/jquery.datetimepicker.full.min.js')
            ->addJs('/js/fine-uploader.min.js')
            ->addJs('/js/alertify.min.js')
            ->addJs('/ckeditor/tinymce.min.js');*/
    }
    public function indexAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
}
