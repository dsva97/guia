<?php
class Destinos
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fncGrabarRegistro(
        $dependencia,
        $estado
    ) {


        $sSQL = $this->db->generateSQLInsert("destino", [
            "dependencia"       => $dependencia,
            "estado"       => $estado,
        ]);

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $id,
        $dependencia,
        $estado
    ) {

        $sSQL = $this->db->generateSQLUpdate("destino", [
             "dependencia"      => $dependencia,
             "estado"      => $estado
        ], "id = $id");

        //     echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($id)
    {
        $sSQL = $this->db->generateSQLDelete("destino", " id = $id ");
        return $this->db->run($sSQL);
    }


    public function fncGetDestinos($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"        => "  d.id ASC ",
            "sLimit"          => null,
            "id"              => null,
            "estado"          => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  d.id,
                         d.dependencia,
                         d.estado
                     FROM destino AS d";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["id"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " d.id = {$this->db->quote($ary['id'])}  ");

        $sWhere .= ($this->db->isNull($ary["estado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " d.estado = {$this->db->quote($ary['estado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }

    public function fncGetDestinosDevoluciones($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"        => "  d.id ASC ",
            "sLimit"          => null,
            "id"              => null,
            "estado"          => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  a.idasignacion, 
                         a.id_destino as id,
                         d.dependencia,
                         d.estado
                     FROM asignaciones  AS a
                     LEFT JOIN destino AS d ON a.id_destino=d.id";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["id"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " d.id = {$this->db->quote($ary['id'])}  ");

        $sWhere .= ($this->db->isNull($ary["estado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " d.estado = {$this->db->quote($ary['estado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}