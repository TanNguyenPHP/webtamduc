<?php

namespace Coredev\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Coredev\Modeldb\Entity\Webconfig;
use Coredev\Commons\ParamsSEO;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $data = Webconfig::findFirst("id_lang = '1'");//Language
        $this->tag->setTitle($data->title);
        self::setMetaDescription($data->meta);
        return $this->view->datamain = array('data' => $data);
    }
    protected function setMetaDescription($content)
    {
        ParamsSEO::$meta_description = "$content";
    }
}
