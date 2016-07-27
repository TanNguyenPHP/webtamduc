<?php
/**
 * Created by PhpStorm.
 * User: SONY
 * Date: 27-07-2016
 * Time: 5:10 PM
 */
namespace Coredev\Backend\Controllers;

use Coredev\Modeldb\Entity\Pictures as Picture;
use Coredev\Modeldb\Entity\Albums;
use Coredev\Commons\UploadHandler;
use Coredev\Commons\ParamsConstant as params;
class PicturesController extends ControllerBase
{
    public function indexAction()
    {
        $idalbum = '';
        $limit = '50';
        if (isset($_GET["limit"]))
            $limit = $_GET["limit"];
        if (isset($_GET["idalbum"]))
            $idalbum = $_GET["idalbum"];
        return $this->view->data = array("data" => Pictures::findPicsPaging($idalbum, "1", $limit),
            "limit" => $limit,
            "idalbum" => $idalbum);
    }
    public function newAction()
    {
        return $this->view->data = Albums::findAll();
    }
    public function createAction()
    {
        $uploader = new UploadHandler();

        // Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array(); // all files types allowed by default

        // Specify max file size in bytes.
        $uploader->sizeLimit = null;

        // Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

        // If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "chunks";

        $method = $_SERVER["REQUEST_METHOD"];
        try {
            if ($method == "POST") {
                header("Content-Type: text/plain");

                // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
                // For example: /myserver/handlers/endpoint.php?done
                if (isset($_GET["done"])) {
                    $result = $uploader->combineChunks(params::pathfolderpicture);
                } // Handles upload requests
                else {
                    // Call handleUpload() with the name of the folder, relative to PHP's getcwd()

                    $result = $uploader->handleUpload(str_replace("\\", "", params::pathfolderpicture));
                    // To return a name used for uploaded file you can use the following line.
                    $result["uploadName"] = $uploader->getUploadName();
                    $pic = new Picture();
                    $pic->id_album = $_REQUEST['albumid'];
                    $pic->datecreate = date('YmdHis');
                    $pic->position = '0';
                    $pic->is_del = '0';
                    $pic->name = $result["name"];
                    $pic->dir = $result["target"];
                    $pic->is_show = '1';
                    if (!$pic->save())
                        return $this->response->redirect('/backend/pictures/new');

                }

                return json_encode($result);
            } // for delete file requests
            else if ($method == "DELETE") {
                $result = $uploader->handleDelete("files");
                return json_encode($result);
            } else {
                header("HTTP/1.0 405 Method Not Allowed");
            }
        } catch (Exception $e) {
            return $this->response->redirect('/backend/pictures/new');
        }
    }
}