<?php
class ResponsablesOrigen
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fncGrabarRegistro(
        $nombre,
        $idlugarorigen,
        $estado
    ) {


        $sSQL = $this->db->generateSQLInsert("responsable_origen", [
            "nombre"       => $nombre,
            "idlugarorigen" => $idlugarorigen,

            "estado"       => $estado,
        ]);

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $id,
        $nombre,
        $idlugarorigen,
        $estado
    ) {

        $sSQL = $this->db->generateSQLUpdate("responsable_origen", [
             "nombre"        => $nombre,
             "idlugarorigen" => $idlugarorigen,
             "estado"        => $estado
        ], "id = $id");

        //     echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($id)
    {
        $sSQL = $this->db->generateSQLDelete("responsable_origen", " id = $id ");
        return $this->db->run($sSQL);
    }


    public function fncGetResponsable($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"        => "  r.id ASC ",
            "sLimit"          => null,
            "id"              => null,
            "idlugarorigen"   => null,
            "estado"          => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT r.id,UPPER(r.nombre) AS nombre, UPPER(IFNULL(lo.nombre,'')) AS oficina,r.idlugarorigen,r.estado
                     FROM responsable_origen AS r
                     LEFT JOIN lugar_origen AS lo ON r.idlugarorigen = lo.idlugarorigen";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["id"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " r.id = {$this->db->quote($ary['id'])}  ");

        $sWhere .= ($this->db->isNull($ary["idlugarorigen"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " r.idlugarorigen = {$this->db->quote($ary['idlugarorigen'])}  ");

        $sWhere .= ($this->db->isNull($ary["estado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " r.estado = {$this->db->quote($ary['estado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}