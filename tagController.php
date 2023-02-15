<?php

class tagController extends Methods
{

    public function obtener_tags()
    {
        require("conexion.php");
        require_once 'tag.php';

        $query = "SELECT * FROM tags ORDER BY texto DESC";


        $STH = $DBH->query($query);
        $STH->execute();
        $STH->setFetchMode(PDO::FETCH_ASSOC);


        $listaTags = array();
        $tag = new Tag();

        while ($row = $STH->fetch()) {
            $tag->setIdTag($row['idTag']);
            $tag->setTexto($row['texto']);
            array_push($listaTags, $tag->toArray());

        }

        return $listaTags;
    }

    public function crear_tag()
    {
        require("conexion.php");
        require_once 'tag.php';

        $data = json_decode(file_get_contents('php://input'), true);
        $texto = strtoupper($data['tagNombre']);


        $datos_insert = array('texto' => $texto);

        $STH = $DBH->prepare("INSERT INTO tags(texto) VALUES (:texto)");
        try {
            $STH->execute($datos_insert);

            $idInsertado = $DBH->lastInsertId();

            $tag = new Tag();
            $tag->setIdTag($idInsertado);
            $tag->setTexto($texto);
            return $tag->toArray();

        } catch (PDOException $e) {
            return array('error' => "Este tag ya existe");
        }

    }
}
?>