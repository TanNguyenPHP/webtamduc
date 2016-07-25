<?php
namespace Coredev\Modeldb\Entity;

use Phalcon\Mvc\Model;
class Typespost extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $desc;

    /**
     *
     * @var string
     */
    public $position;

    /**
     *
     * @var string
     */
    public $seo_title;

    /**
     *
     * @var string
     */
    public $seo_desc;

    /**
     *
     * @var string
     */
    public $is_status;

    /**
     *
     * @var string
     */
    public $is_del;

    /**
     *
     * @var string
     */
    public $is_home;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'typespost';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Typespost[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    public static function findAll()
    {
        return parent::find("is_del = '0'");
    }
    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Typespost
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
