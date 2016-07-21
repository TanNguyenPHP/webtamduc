<?php
namespace Coredev\Modeldb\Entity;

use Phalcon\Mvc\Model;

class Posts extends Model
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
    public $title;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $content_short;

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
    public $seo_keyword;

    /**
     *
     * @var string
     */
    public $url;

    /**
     *
     * @var integer
     */
    public $id_lang;

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
    public $position;

    /**
     *
     * @var string
     */
    public $is_home;

    /**
     *
     * @var integer
     */
    public $id_category;

    /**
     *
     * @var string
     */
    public $avatar_image;

    /**
     *
     * @var string
     */
    public $datecreate;

    /**
     *
     * @var string
     */
    public $id_user;

    /**
     *
     * @var string
     */
    public $slug;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'posts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findPostsPaging($title = '', $is_home = '', $is_status = '', $page = '', $limit = '')
    {
        $queryBuilder = new \Phalcon\Mvc\Model\Query\Builder(self::buildparams($title, $is_home, $is_status));

        $paginator = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $queryBuilder,
            "limit" => (int)$limit,
            "page" => (int)$page
        ));
        //return $queryBuilder->getQuery()->execute();
        return $paginator->getPaginate();
    }

    private static function buildparams($title, $is_home, $is_status)
    {
        $conditions = '1=1';
        if ($title != '')
            $conditions = $conditions . " and p.title like '%$title%'";
        if ($is_home != '')
            $conditions = $conditions . " and p.is_home = '$is_home'";
        if ($is_status != '')
            $conditions = $conditions . " and p.is_status = '$is_status'";
        return $params = array(
            'models' => array('p' => 'Coredev\Modeldb\Entity\Posts'),
            'columns' => array('p.id', 'p.title', 'p.is_home', 'p.is_status', 'p.datecreate', 'c.name categoryname'),
            'joins' => array('0' => array('Coredev\Modeldb\Entity\Category', 'c.id = p.id_category', 'c', 'left')),
            'conditions' => $conditions,
            // or 'conditions' => "created > '2013-01-01' AND created < '2014-01-01'",
            'order' => 'p.datecreate desc,p.title '
            // or 'limit' => array(20, 20),
        );
    }
}
