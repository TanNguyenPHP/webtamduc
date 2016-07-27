<?php
namespace Coredev\Modeldb\Entity;

use Phalcon\Mvc\Model;
class Albums extends Model
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
    public $folder;

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
     * @var string
     */
    public $desc;

    /**
     *
     * @var string
     */
    public $is_website;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'albums';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Albums[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Albums
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function findAll()
    {
        return parent::find("is_del ='0'");
    }
    public static function findAlbumsPaging($name="", $page="", $limit="")
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($name));

        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $queryBuilder,
            "limit" => (int)$limit,
            "page" => (int)$page
        ));
        //return $queryBuilder->getQuery()->execute();
        return $paginator->getPaginate();
    }
    private static function buildparams($name = "")
    {
        $conditions = "is_del ='0'";
        if ($name != "")
            $conditions = $conditions . " and name like '%$name%' ";

        return $params = array(
            'models' => array('Coredev\Modeldb\Entity\Albums'),
            'columns' => array('id', 'name', 'datecreate'),
            'conditions' => $conditions,
            'order' => 'datecreate desc'
        );

    }

}
