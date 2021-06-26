<?php
class Devoluciones
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function fncGrabarRegistro(
        $id_lugar_origen,
        $id_responsable_origen,
        $id_destino,
        $id_responsable_destino,
        $motivo,
        $otro,
        $devuelto,
        $estado
    ) {

        $sSQL = $this->db->generateSQLInsert("asignaciones", [
            "id_lugar_origen"          => $id_lugar_origen,
            "id_responsable_origen"    => $id_responsable_origen,
            "id_destino"               => $id_destino,
            "id_responsable_destino"   => $id_responsable_destino,
            "motivo"                   => $motivo,
            "otro"                     => $otro,
            "f_creacion"               => "NOW()",
            "devuelto"                 => $devuelto,
            "estado"                   => $estado
        ]);

        //  echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }




    public function fncActualizarRegistro(
        $idasignacion,
        $id_lugar_origen,
        $id_responsable_origen,
        $id_destino,
        $id_responsable_destino,
        $motivo,
        $otro,
        $devuelto,
        $estado
    ) {

        $sSQL = $this->db->generateSQLUpdate("asignaciones", [
            "id_lugar_origen"           => $id_lugar_origen,
            "id_responsable_origen"     => $id_responsable_origen,
            "id_destino"                => $id_destino,
            "id_responsable_destino"    => $id_responsable_destino,
            "motivo"                    => $motivo,
            "otro"                      => $otro,
            "devuelto"                  => $devuelto,
            "estado"                    => $estado,
            "f_modificar"               => "NOW()",
        ], "idasignacion = $idasignacion");

        //     echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }

    public function fncEliminarRegistro($idasignacion)
    {
        $sSQL = $this->db->generateSQLDelete("asignaciones", " idasignacion = $idasignacion ");
        $this->db->run($sSQL);
        $sSQL = $this->db->generateSQLDelete("asignaciones_bienes", " idasignacion = $idasignacion ");
        return $this->db->run($sSQL);
    }


    public function fncGetAsignacionesDevoluciones($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "idasignacion"       => null,
            "estado"             => null,
            "devuelto"           => null,

        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT     asig.idasignacion,
                            asig.id_lugar_origen,
                            asig.id_responsable_origen,
                            asig.id_destino,
                            asig.id_responsable_destino,
                            asig.motivo,
                            asig.otro,
                            asig.devuelto,
                            
                            UPPER(IFNULL(lo.nombre, '')) AS lugar_origen, 
                            UPPER(IFNULL(ro.nombre, '')) AS resposable_origen, 
                            UPPER(IFNULL(dest.dependencia, '')) AS destino, 
                            UPPER(IFNULL(resp.nombre, '')) AS responsable_destino, 

                            IFNULL( DATE_FORMAT( asig.f_creacion, '%d/%m/%Y' ), '' ) as f_creacion, 
                            IFNULL( DATE_FORMAT( asig.f_modificar, '%d/%m/%Y' ), '' ) as f_modificar,

                            asig.estado
                    FROM asignaciones AS asig
                    LEFT JOIN lugar_origen AS lo ON lo.idlugarorigen = asig.id_lugar_origen
                    LEFT JOIN responsable_origen AS ro ON ro.id = asig.id_responsable_origen
                    LEFT JOIN destino AS dest ON dest.id = asig.id_destino
                    LEFT JOIN responsable AS resp ON resp.id = asig.id_responsable_destino";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["idasignacion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " asig.idasignacion = {$this->db->quote($ary['idasignacion'])}  ");

        $sWhere .= ($this->db->isNull($ary["devuelto"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " asig.devuelto = {$this->db->quote($ary['devuelto'])}  ");

        $sWhere .= ($this->db->isNull($ary["estado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " asig.estado = {$this->db->quote($ary['estado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return ($this->db->run(trim($sSQL)));
    }






    public function fncGrabarAsigBien(
        $idasignacion,
        $idbien,
        $nombrebien,
        $estado
    ) {

        $sSQL = $this->db->generateSQLInsert("asignaciones_bienes", [
            "idasignacion"          => $idasignacion,
            "idbien"                => $idbien,
            "nombrebien"            => $nombrebien,
            "estado"                => $estado,
        ]);

        //  echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }



    public function fncActualizarAsigBien(
        $idasignacionbien,
        $idasignacion,
        $idbien,
        $nombrebien,
        $estado
    ) {

        $sSQL = $this->db->generateSQLUpdate("asignaciones_bienes", [
            "idasignacion"          => $idasignacion,
            "idbien"                => $idbien,
            "nombrebien"            => $nombrebien,
            "estado"                => $estado,
        ], "idasignacionbien = $idasignacionbien");

        //  echo $sSQL;
        // exit;

        return  $this->db->run($sSQL);
    }


    public function fncEliminarByAsig($idasignacion)
    {
        $sSQL = $this->db->generateSQLDelete("asignaciones_bienes", " idasignacion = $idasignacion ");
        return $this->db->run($sSQL);
    }


    public function fncGetAsignacionBienes($aryInput = [])
    {

        $aryAllFilters = [
            "sOrderBy"           => null,
            "sLimit"             => null,
            "idasignacionbien"    => null,

            "idasignacion"       => null,
            "idbien"             => null,
            "estado"            => null
        ];

        $ary = $this->db->filterArray($aryInput, $aryAllFilters);

        $sSQL = "SELECT     ab.idasignacionbien,
                            ab.idasignacion,
                            ab.idbien,
                            IFNULL(b.cod_patrimonio,'') AS cod_patrimonio,
                            IFNULL(b.descripcion,'') AS nombrebien,
                            IFNULL(b.cod_inventario,'') AS cod_inventario,
                            IFNULL(b.marca,'') AS marca,
                            IFNULL(b.modelo,'') AS modelo,
                            IFNULL(b.serie,'') AS serie,
                            
                            (CASE WHEN b.estado_bien = 1 THEN 'NUEVO'
                                WHEN b.estado_bien = 2 THEN 'BUENO'
                                WHEN b.estado_bien = 3 THEN 'REGULAR'
                                WHEN b.estado_bien = 4 THEN 'MALO'
                                ELSE 'INDEFINIDO'
                            END) AS nombre_estado_bien,
                            ab.estado
                    FROM asignaciones_bienes AS ab
                    LEFT JOIN bienes AS b ON ab.idbien = b.id
                    ";

        $sWhere = "";

        $sWhere .= ($this->db->isNull($ary["idasignacionbien"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ab.idasignacionbien = {$this->db->quote($ary['idasignacionbien'])}  ");

        $sWhere .= ($this->db->isNull($ary["idasignacion"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ab.idasignacion = {$this->db->quote($ary['idasignacion'])}  ");

        $sWhere .= ($this->db->isNull($ary["idbien"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " ab.idbien = {$this->db->quote($ary['idbien'])}  ");

        $sWhere .= ($this->db->isNull($ary["estado"]) ? '' : (strlen($sWhere) > 0 ? " AND " : "") . " asig.estado = {$this->db->quote($ary['estado'])}  ");

        $sSQL   .= (strlen($sWhere) > 0 ? ' WHERE ' : '') . $sWhere;

        $sSQL   .= ($this->db->isNull($ary["sOrderBy"]) ? "" : " ORDER BY " . $ary["sOrderBy"]);

        $sSQL   .= ($this->db->isNull($ary["sLimit"]) ? "" : " LIMIT " . $ary["sLimit"]);

        // echo $sSQL;
        // exit;

        return ($this->db->run(trim($sSQL)));
    }
}
