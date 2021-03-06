<?php
namespace Coredev\Modeldb\Entity;

use Phalcon\Mvc\Model;

class Users extends Model
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
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $datecreate;

    /**
     *
     * @var string
     */
    public $is_active;

    /**
     *
     * @var string
     */
    public $is_del;

    /**
     *
     * @var string
     */
    public $room;

    /**
     *
     * @var string
     */
    public $desc;

    /**
     *
     * @var string
     */
    public $group;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $dob;
    public $id_group;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users
     */
    public static function

    findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findUsersPaging($name, $page, $limit)
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($name, $page, $limit));

        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $queryBuilder,
            "limit" => (int)$limit,
            "page" => (int)$page
        ));
        //return $queryBuilder->getQuery()->execute();
        return $paginator->getPaginate();
    }

    private static function buildparams($name, $page, $limit)
    {
        $conditions = '1=1';
        if ($name != '')
            $conditions = $conditions . " and u.username like '%$name%' or u.name like '%$name%'";
        return $params = array(
            'models' => array('u' => 'Coredev\Modeldb\Entity\Users'),
            'columns' => array('u.id', 'u.username', 'u.name', 'u.is_active', 'u.datecreate', 'g.name gname'),
            'joins' => array('0' => array('Coredev\Modeldb\Entity\RoleGroup', 'g.id = u.id_group', 'g', 'left')),
            'conditions' => $conditions,
            // or 'conditions' => "created > '2013-01-01' AND created < '2014-01-01'",
            'order' => 'u.name'
            // or 'limit' => array(20, 20),
        );
    }
}
