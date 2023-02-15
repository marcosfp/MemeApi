<?php
class memeController extends Methods
{
    public function crear_meme()
    {
        require("conexion.php");
        require_once 'meme.php';

        $meme = json_decode(file_get_contents('php://input'), true);

        $nombre = $meme['nombre'];
        $url = $meme['url'];
        $titSup = $meme['tSuperior'];
        $titInf = $meme['tInferior'];
        $tags = $meme['tags'];

        $datos_insert = array('nombre' => $nombre, 'titSup' => $titSup, 'titInf' => $titInf, 'url' => $url);

        $STH = $DBH->prepare("INSERT INTO memes(nombre, titulo_superior, titulo_inferior, url) VALUES (:nombre,  :titSup, :titInf, :url)");
        $STH->execute($datos_insert);

        $meme_insertado = $DBH->lastInsertId();

        $array_de_tags = explode(",", $tags);

        foreach ($array_de_tags as $t) {
            $STH = $DBH->prepare("INSERT INTO meme_tag VALUES  (:idMeme, :idTag)");
            $datos_insert = array('idMeme' => $meme_insertado, 'idTag' => $t);
            $STH->execute($datos_insert);
        }



        $memeN = new Meme();
        $memeN->setIdMeme($meme_insertado);
        $memeN->setNombre($nombre);
        $memeN->setTSuperior($titSup);
        $memeN->setTInferior($titInf);
        $memeN->setUrl($url);

        return array(
            'idMeme' => $meme_insertado,
            'nombre' => $nombre,
            'url' => $url,
            'tSuperior' => $titSup,
            'tInferior' => $titInf
        );
    }



    public function editar_meme()
    {
        require("conexion.php");
        require_once 'meme.php';

        $meme = json_decode(file_get_contents('php://input'), true);

        $idMeme = $meme['idMeme'];
        $nombre = $meme['nombre'];
        $titSup = $meme['tSuperior'];
        $titInf = $meme['tInferior'];
        $url = $meme['url'];
        $tags = $meme['tags'];



        $datos_update = array(
            'idMeme' => $idMeme,
            'nombre' => $nombre,
            'titSup' => $titSup,
            'titInf' => $titInf,
            'url' => $url
        );



        $STH = $DBH->prepare(
            "UPDATE memes 
            SET nombre=:nombre, titulo_superior=:titSup, titulo_inferior=:titInf, url=:url 
            WHERE idMeme=:idMeme ;"
        );
        $STH->execute($datos_update);



        $memeN = new Meme();
        $memeN->setIdMeme($idMeme);
        $memeN->setNombre($nombre);
        $memeN->setTSuperior($titSup);
        $memeN->setTInferior($titInf);
        $memeN->setUrl($url);

        return array(
            'idMeme' => $idMeme,
            'nombre' => $nombre,
            'url' => $url,
            'tSuperior' => $titSup,
            'tInferior' => $titInf
        );
    }

    public function obtener_memes_lista()
    {
        require("conexion.php");
        require_once 'meme.php';



        $page = isset($_GET['page']) ? intval($_GET['page']) : 0;
        $count = isset($_GET['count']) ? intval($_GET['count']) : 5;
        $tag = isset($_GET['tag']) ? $_GET['tag'] : "";

        if ($page > 0)
            $page = $page * $count;

        if ($tag != "") {
            $query = "SELECT * FROM memes m JOIN tiene t JOIN tag ta ON m.idMeme = t.idMeme AND t.idTag = ta.idTag WHERE ta.texto = " . $tag . " LIMIT " . $page . ", " . $count . " ;";
            $data_query = array("page" => $page, "count" => $count, "tag" => $tag);
        } else {
            $query = "SELECT * FROM memes ORDER BY idMeme ASC LIMIT " . $page . ", " . $count . " ;";
        }



        $STH = $DBH->prepare($query);
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $STH->execute();

        $arrayMemes = array();





        while ($row = $STH->fetch()) {
            $meme = new Meme();
            $meme->setIdMeme($row['idMeme']);
            $meme->setNombre($row['nombre']);
            $meme->setTSuperior($row['titulo_superior']);
            $meme->setTInferior($row['titulo_inferior']);
            $meme->setUrl($row['url']);
            array_push($arrayMemes, $meme->toArray());
        }
        return $arrayMemes;
    }



    public function obtener_meme_id()
    {
        require("conexion.php");
        require_once 'meme.php';

        //Si la peticion no contiene parametro id devolvemos un nulo
        if (!isset($_GET["id"]))
            return null;

        $data_query = array("id" => $_GET['id']);

        $STH = $DBH->prepare("SELECT * FROM memes WHERE idMeme=:id");

        try {
            $STH->setFetchMode(PDO::FETCH_ASSOC);
            $STH->execute($data_query);

            $meme = new Meme();

            while ($row = $STH->fetch()) {
                $meme->setIdMeme($row['idMeme']);
                $meme->setNombre($row['nombre']);
                $meme->setTSuperior($row['titulo_superior']);
                $meme->setTInferior($row['titulo_inferior']);
                $meme->setUrl($row['url']);
            }



            return array(
                'idMeme' => $meme->getIdMeme(),
                'nombre' => $nombre,
                'url' => $meme->getUrl(),
                'tSuperior' => $meme->getTSuperior(),
                'tInferior' => $meme->getTInferior()
            );
        } catch (PDOException $e) {
            return array("error" => $e);
        }
    }

    public function borrar_meme_id()
    {
        require("conexion.php");
        require_once 'meme.php';

        //Si la peticion no contiene parametro id devolvemos un nulo

        if (!isset($_GET["id"]))
            return null;
        $data_delete = array("id" => $_GET['id']);


        $STH = $DBH->prepare("DELETE FROM memes WHERE idMeme=:id");
        try {

            $STH = $DBH->prepare("DELETE FROM meme_tag WHERE idMeme=:id");
            $STH->execute($data_delete);
            $STH = $DBH->prepare("DELETE FROM memes WHERE idMeme=:id");
            $STH->execute($data_delete);
            
            if ($rowdeleted == 1) {
                return array('deleted' => true);
            } else {
                return array('deleted' => false);
            }
        } catch (PDOException $e) {
            return array("error" => $e);
        }
    }
}
