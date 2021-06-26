<?php
class Responsables
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fncGrabarRegistro(
        $nombre,
        $id_destino,
        $estado
    ) {


        $sSQL = $this->db->generateSQLInsert("responsable", [
            "nombre"       => $nombre,
            "id_destino"   => $id_destino,
            "estado"       => $estado,
        ]);

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $id,
        $nombre,
        $id_destino,
        $estado
    ) {

        $sSQL = $this->db->generateSQLUpdate("responsable", [
             "nombre"      => $nombre,
             "id_destino"  => $id_destino,
             "estado"      => $estado
        ], "id = $id");

        //     echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($id)
    {
        $sSQL = $this->db->generateSQLDelete("responsable", " id = $id ");
        return $this->db->run($sSQL);
    }


    public function fncGetResponsable($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"        => "  r.id ASC ",
            "sLimit"          => null,
            "id"              => null,
            "id_destino"      => null,
            "estado"          => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  r.id,
                         UPPER(r.nombre) AS nombre,
                         r.id_destino,
                         UPPER(IFNULL(d.dependencia,'')) as dependencia,
                         r.estado
                     FROM responsable AS r
                     LEFT JOIN destino AS d ON r.id_destino = d.id

                     ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["id"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " r.id = {$this->db->quote($ary['id'])}  ");

        $sWhere .= ($this->db->isNull($ary["id_destino"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " r.id_destino = {$this->db->quote($ary['id_destino'])}  ");

        $sWhere .= ($this->db->isNull($ary["estado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " r.estado = {$this->db->quote($ary['estado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}