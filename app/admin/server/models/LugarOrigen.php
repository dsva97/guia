<?php
class LugarOrigen
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function fncGrabarRegistro(
        $nombre,
        $estado
    ) {

        $sSQL = $this->db->generateSQLInsert("lugar_origen", [
            "nombre"          => $nombre,
            "estado"          => $estado,
        ]);

        //  echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }




    public function fncActualizarRegistro(
        $idlugarorigen,
        $nombre,
        $estado
    ) {

        $sSQL = $this->db->generateSQLUpdate("lugar_origen", [
            "nombre"          => $nombre,
            "estado"          => $estado,
        ], "idlugarorigen = $idlugarorigen");

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($idlugarorigen)
    {
        $sSQL = $this->db->generateSQLDelete("lugar_origen", " idlugarorigen = $idlugarorigen ");
        return $this->db->run($sSQL);
    }


    public function fncGetLugarOrigen($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "idlugarorigen"       => null,
            "estado"             => null,
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT     lo.idlugarorigen,
                            lo.nombre,
                            lo.estado
                    FROM lugar_origen AS lo";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["idlugarorigen"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " lo.idlugarorigen = {$this->db->quote($ary['idlugarorigen'])}  ");

        $sWhere .= ($this->db->isNull($ary["estado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " lo.estado = {$this->db->quote($ary['estado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return ($this->db->run(trim($sSQL)));
    }
}
