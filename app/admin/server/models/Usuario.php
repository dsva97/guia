<?php
class Usuario
{

    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }


    public function fncGrabarRegistro(
        $usuario,
        $password
    ) {


        $sSQL = $this->db->generateSQLInsert("usuarios", [
            "usuario"       => $usuario,
            "password"       => $password,
        ]);

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $id,
        $usuario,
        $password
    ) {

        $sSQL = $this->db->generateSQLUpdate("usuarios", [
            "usuario"       => $usuario ,
            "password"     => $password,
        ], "id = $id");

        //     echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($id)
    {
        $sSQL = $this->db->generateSQLDelete("usuarios", " id = $id ");
        return $this->db->run($sSQL);
    }


    public function fncActualizarClave(
        $id,
        $password
         
    ) {

        $sSQL = $this->db->generateSQLUpdate("usuarios", [
            "password"  => $password,
        ], " id = $id");

        //     echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncGetUsuarios($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "id"                 => null,
            "usuario"            => null,
          ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT usu.id,
                        usu.usuario,
                        usu.password
                     FROM usuarios AS usu";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["id"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " usu.id = {$this->db->quote($ary['id'])}  ");

        $sWhere .= ($this->db->isNull($ary["usuario"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " usu.usuario = {$this->db->quote($ary['usuario'])}  "); 
 
        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return ($this->db->run(trim($sSQL)));
    }



}
