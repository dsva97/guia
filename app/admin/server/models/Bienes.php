<?php
class Bienes
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fncGrabarRegistro(
        $cod_patrimonio,
        $descripcion,
        $cod_inventario,
        $marca,
        $modelo,
        $serie,
        $estado_bien,
        $estado
    ) {
        $sSQL = $this->db->generateSQLInsert("bienes", [
            "cod_patrimonio"             => $cod_patrimonio,
            "descripcion"                => $descripcion,
            "cod_inventario"             => $cod_inventario,
            "marca"                      => $marca,
            "modelo"                     => $modelo,
            "serie"                      => $serie,
            "estado_bien"                => $estado_bien,
            "estado"                     => $estado,
            "f_registro"                 => "NOW()"
        ]);

        // echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncActualizarRegistro(
        $id,
        $cod_patrimonio,
        $descripcion,
        $cod_inventario,
        $marca,
        $modelo,
        $serie,
        $estado_bien,
        $estado
    ) {
        $sSQL = $this->db->generateSQLUpdate("bienes", [
            "cod_patrimonio"             => $cod_patrimonio,
            "descripcion"                => $descripcion,
            "cod_inventario"             => $cod_inventario,
            "marca"                      => $marca,
            "modelo"                     => $modelo,
            "serie"                      => $serie,
            "estado_bien"                => $estado_bien,
            "estado"                     => $estado,
            "f_modifica"                 => "NOW()"
        ], "id = $id");

        //     echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($id)
    {
        $sSQL = $this->db->generateSQLDelete("bienes", " id = $id ");
        return $this->db->run($sSQL);
    }


    public function fncGetBienes($aryInput = [])
    {
        $aryAllFilters = [
            "sOrderBy"        => "  b.id ASC ",
            "sLimit"          => null,
            "id"              => null,
            "aryNotId"        => null,
            "estado"          => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT  b.id,
                         b.cod_patrimonio,
                         b.descripcion,
                         b.cod_inventario,
                         b.marca,
                         b.modelo,
                         b.serie,
                         b.estado,
                         b.estado_bien,
                        (CASE   WHEN estado_bien = 1 THEN 'NUEVO'
                                WHEN estado_bien = 2 THEN 'BUENO'
                                WHEN estado_bien = 3 THEN 'REGULAR'
                                WHEN estado_bien = 4 THEN 'MALO'
                                ELSE 'INDEFINIDO'
                            END) AS nombre_estado_bien,
                        IFNULL( DATE_FORMAT( b.f_registro, '%d/%m/%Y' ), '' ) as f_registro, 
                        IFNULL( DATE_FORMAT( b.f_modifica, '%d/%m/%Y' ), '' ) as f_modifica
                     FROM bienes AS b";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["id"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.id = {$this->db->quote($ary['id'])}  ");

        $sWhere .= ($this->db->isNull($ary["aryNotId"]) && !is_array($ary["aryNotId"])) ? "" : ((strlen($sWhere) > 0 ? " AND " : '') . ' b.id NOT IN (' . implode(",", $ary['aryNotId']) . ')');

        $sWhere .= ($this->db->isNull($ary["estado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " b.estado = {$this->db->quote($ary['estado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return $this->db->run(trim($sSQL));
    }
}
