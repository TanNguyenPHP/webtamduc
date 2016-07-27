<?php
namespace Coredev\Modeldb\Entity;

use Phalcon\Mvc\Model;

class Pictures extends Model
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
    public $dir;

    /**
     *
     * @var string
     */
    public $is_del;

    /**
     *
     * @var string
     */
    public $datecreate;

    /**
     *
     * @var integer
     */
    public $id_album;

    /**
     *
     * @var string
     */
    public $position;

    /**
     *
     * @var string
     */
    public $is_show;

    /**
     *
     * @var string
     */
    public $alt;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pictures';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pictures[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pictures
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function findPicsPaging($id_album="", $page="", $limit="")
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($id_album));

        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $queryBuilder,
            "limit" => (int)$limit,
            "page" => (int)$page
        ));
        //return $queryBuilder->getQuery()->execute();
        return $paginator->getPaginate();
    }
    private static function buildparams($id_album = "")
    {
        $conditions = "p.is_del ='0'";
        if ($id_album != "")
            $conditions = $conditions . " and a.id_album = '$id_album' ";

        return $params = array(
            'models' => array('p' => 'Coredev\Modeldb\Entity\Pictures'),
            'columns' => array('p.name', 'p.id', 'p.dir', 'p.id_album','p.position','a.name aname','p.is_show'),
            'joins' => array('0' => array('Coredev\Modeldb\Entity\Albums', 'a.id = p.id_album', 'a','left')),
            'conditions' => $conditions,
            'order' => 'a.datecreate desc'
        );

    }
}
