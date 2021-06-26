<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>
</head>

<style>
    .text-center {
        text-align: center;
    }

    .border-negro {
        border: 1px solid black;
    }

    body {
        margin: 0 !important;
        padding: 0 !important;
        color: #001028;
        background: #ffffff;
        font-family: Arial, sans-serif;
        font-size: 12px;
        font-family: Arial;
    }

    .row {
        display: table;
        content: " ";
    }

    .col-xs-1,
    .col-sm-1,
    .col-md-1,
    .col-lg-1,
    .col-xs-2,
    .col-sm-2,
    .col-md-2,
    .col-lg-2,
    .col-xs-3,
    .col-sm-3,
    .col-md-3,
    .col-lg-3,
    .col-xs-4,
    .col-sm-4,
    .col-md-4,
    .col-lg-4,
    .col-xs-5,
    .col-sm-5,
    .col-md-5,
    .col-lg-5,
    .col-xs-6,
    .col-sm-6,
    .col-md-6,
    .col-lg-6,
    .col-xs-7,
    .col-sm-7,
    .col-md-7,
    .col-lg-7,
    .col-xs-8,
    .col-sm-8,
    .col-md-8,
    .col-lg-8,
    .col-xs-9,
    .col-sm-9,
    .col-md-9,
    .col-lg-9,
    .col-xs-10,
    .col-sm-10,
    .col-md-10,
    .col-lg-10,
    .col-xs-11,
    .col-sm-11,
    .col-md-11,
    .col-lg-11,
    .col-xs-12,
    .col-sm-12,
    .col-md-12,
    .col-lg-12 {
        float: left;
        position: relative;
        border: 0;
        padding: 0;
    }

    .row>div {
        margin: 0px !important;
        padding: 0px !important;
    }

    .col-xs-1 {
        width: 7.83333333% !important;
    }

    .col-xs-2 {
        width: 16.16666667% !important;
    }

    .col-xs-3 {
        width: 24.5% !important;
    }

    .col-xs-4 {
        width: 33.33% !important;
    }

    .col-xs-5 {
        width: 41.16666667% !important;
    }

    .col-xs-6 {
        width: 49.5% !important;
    }

    .col-xs-7 {
        width: 57.83333333% !important;
    }

    .col-xs-8 {
        width: 66.16666667% !important;
    }

    .col-xs-9 {
        width: 74.5% !important;
    }

    .col-xs-10 {
        width: 82.83333333% !important;
    }

    .col-xs-11 {
        width: 91, 16666666% !important;
    }

    .col-xs-12 {
        width: 99.5% !important;
    }

    .card-header {
        padding: 1rem 1.35rem;
        margin-bottom: 0;
        background-color: rgba(33, 40, 50, 0.03);
        border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        font-weight: 500;
        color: #0061f2;
    }

    .cuerpo {
        padding: 1.35rem;
    }

    .sbp-preview {
        border-radius: 0.35rem;
        border: 0.25rem solid #e0e5ec;
        border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        border-left-style: solid;
        border-style: solid;
    }

    .font-weight-500 {
        font-weight: 500 !important;
    }

    .text-muted {
        color: #a7aeb8 !important;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    small,
    .small {
        font-size: 0.875em;
        font-weight: 400;
    }

    .p-lados {
        padding-left: 15px;
        padding-right: 15px;

    }


    /* table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
    }



    table th,
    table td {
        text-align: left;
        padding: 0.75rem;
        border: 1px solid #e0e5ec;
        border-bottom-style: solid;
        border-bottom-width: 1px;
    } */

    .bold {
        font-weight: bold;
    }

    .text-right {
        text-align: right;
    }

    .table-bienes td,
    .table-bienes th,
    .table-origen td {
        border: 1px solid #000;
        padding: 5px;
    }

    .bg-plomo {
        background-color: #c0c0c0;
    }

    .table-bienes th,
    .bg-azulclaro {
        background-color: #00ccff;
    }

    .table-bienes td {
        text-align: center;
    }
</style>


<body>



    <div style="padding:10px;" class="row border-negro">
        <div class="col-xs-12">
            <img width="auto" height="35px" src="../img/iconos/logo-mimpv.png">
        </div>
    </div>

    <div style="padding:10px;" class=" row border-negro text-center">
        <div class="col-xs-12 bold">
            GUIA DE DESPLAZAMIENTO DE BIENES
        </div>
    </div>

    <div style="padding:10px;" class="row bold border-negro">
        <div class="col-xs-9 text-right">
            <div style="padding:2px; padding-right: 25px;"> NRO. </div>
        </div>
        <div class="col-xs-3">
            <div style="padding:2px;" class="border-negro"> <?= str_pad($aryAsig["idasignacion"], 8, "0", STR_PAD_LEFT)  ?> </div>
        </div>
    </div>

    <div style="padding:10px;" class="row bold border-negro">
        <div class="col-xs-6">
            <div style="padding:2px;"> ORIGEN <?= $aryAsig["lugar_origen"] ?> </div>
            <table class="table-origen" style="border: 1px solid black; width: 100%; border-collapse: collapse;border-spacing: 0;">
                <tr>
                    <td class="bg-plomo">DEPENDENCIA : </td>
                    <td> <?= $aryAsig["lugar_origen"] ?> </td>
                </tr>
                <tr>
                    <td class="bg-plomo">RESPONSABLE : </td>
                    <td> <?= $aryAsig["resposable_origen"] ?> </td>
                </tr>
            </table>



            <table class="table-origen" style="margin-top: 5px; border: 1px solid black; width: 100%; border-collapse: collapse;border-spacing: 0;">
                <tr>
                    <td class="bg-plomo">EXTERNO[2] : </td>
                    <td style="color:white"> <?= $aryAsig["lugar_origen"] ?> </td>
                </tr>
                <tr>
                    <td class="bg-plomo">RESPONSABLE : </td>
                    <td style="color:white"> <?= $aryAsig["resposable_origen"] ?> </td>
                </tr>
            </table>

        </div>

        <div class="col-xs-6">
            <div style="padding:2px;"> DESTINO <?= $aryAsig["destino"] ?> </div>
            <table class="table-origen" style="border: 1px solid black; width: 100%; border-collapse: collapse;border-spacing: 0;">
                <tr>
                    <td class="bg-plomo">DEPENDENCIA : </td>
                    <td> <?= $aryAsig["destino"] ?> </td>
                </tr>
                <tr>
                    <td class="bg-plomo">RESPONSABLE : </td>
                    <td> <?= $aryAsig["responsable_destino"] ?> </td>
                </tr>
            </table>

            <table class="table-origen" style="margin-top: 5px; border: 1px solid black; width: 100%; border-collapse: collapse;border-spacing: 0;">
                <tr>
                    <td class="bg-plomo">EXTERNO[3] : </td>
                    <td style="color:white;"><?= $aryAsig["destino"] ?> </td>
                </tr>
                <tr>
                    <td class="bg-plomo">RESPONSABLE : </td>
                    <td style="color:white;"> <?= $aryAsig["responsable_destino"] ?> </td>
                </tr>
            </table>

        </div>


    </div>


    <div style="padding:10px;" class="row border-negro">
        <div class="col-xs-12">
            <span class="bold">MOTIVO </span> <?= mb_strtoupper($aryAsig["motivo"], 'utf-8') ?>
        </div>
    </div>

    <div style="padding:10px;" class="row border-negro">
        <div class="col-xs-12">
            <span class="bold">OTRO </span> <span style="border-bottom: 1px solid #000;"><?= mb_strtoupper($aryAsig["otro"], 'utf-8') ?></span>
        </div>
    </div>

    <div style="padding:10px;" class="row border-negro">
        <div class="col-xs-12">
            <span class="bold">BIENES</span>

            <table class="table-bienes" style="border: 1px solid black; width: 100%; margin-top: 5px; border-collapse: collapse;border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Código Patrimonial</th>
                        <th>Descripción</th>
                        <th>Código Inventario</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Serie</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($aryDetalle) && count($aryDetalle) > 0) : ?>
                        <?php foreach ($aryDetalle as $aryLoop) : ?>
                            <tr>
                                <td><?= $aryLoop["cod_patrimonio"] ?></td>
                                <td><?= $aryLoop["nombrebien"] ?></td>
                                <td><?= $aryLoop["cod_inventario"] ?></td>
                                <td><?= $aryLoop["marca"] ?></td>
                                <td><?= $aryLoop["modelo"] ?></td>
                                <td><?= $aryLoop["serie"] ?></td>
                                <td><?= $aryLoop["nombre_estado_bien"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

    <div style="padding:10px;" class="border-negro">

        <div style="padding:10px;" class="row  text-center">
            <div class="col-xs-6 text-center" style="padding-top: 50px;">
                <div style="margin-left:15%; width: 70%; text-align: center;  ">
                    <div style="padding-top: 5px; border-top: 1px solid #000; font-size: 12px; text-align: center;" class="bold">Vo Bo DE LA OFICINA DE CONTROL PATRIMONIAL</div>
                </div>
            </div>
            <div class="col-xs-6 text-center" style="padding-top: 50px;">

                <div style="margin-left:15%; width: 70%; text-align: center; ">
                    <div style="padding-top: 5px; border-top: 1px solid #000; font-size: 12px; text-align: center;" class="bold">JEFE/DIRECTOR DE LA DEPENDENCIA QUE ENTREGA</div>
                </div>
            </div>
        </div>


        <div style="padding:10px;" class="row  text-center">
            <div class="col-xs-6 text-center" style="padding-top: 50px;">
                <div style="margin-left:15%; width: 70%; text-align: center;  ">
                    <div style="padding-top: 5px; border-top: 1px solid #000; font-size: 12px; text-align: center;" class="bold">
                        Vo Bo DIRECTOR II <?= $aryAsig["lugar_origen"] ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 text-center" style="padding-top: 50px;">

                <div style="margin-left:15%; width: 70%; text-align: center; ">
                    <div style="padding-top: 5px; border-top: 1px solid #000; font-size: 12px; text-align: center;" class="bold">JEFE/ DIRECTOR/PERSONA DE LA DEPENDENCIA QUE RECEPCIONA</div>
                </div>
            </div>
        </div>


        <div style="padding:10px;" class="row  text-center">
            <div class="col-xs-8 text-center">

                <table class="table-bienes" style="border: 1px solid black; width: 100%; margin-top: 5px; border-collapse: collapse;border-spacing: 0;">
                    <tr>
                        <td class="bg-azulclaro">REINGRESO</td>
                        <td class="bg-azulclaro"> VoBo OCP</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>

                    <tr>
                        <td>FECHA : __ / __ / __</td>
                        <td class="bg-azulclaro">VoBo [1]</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                </table>


            </div>
            <div class="col-xs-4 text-center">
                <div style="padding-top: 10px;">
                    FECHA : <?= date("d/m/Y") ?>
                </div>
            </div>
        </div>

        <div style="color:blue;padding:10px; font-size: 9px !important; ">
            <p style="font-size: 9px;">
                [1] El Vo Bo del Jefe de <?= $aryAsig["lugar_origen"] ?> sólo es necesario en el caso de desplazamiento de equipos informáticos
            </p>
            <p style="font-size: 9px;">
                [2] En el caso que el bien es de propiedad de un tercero
            </p>
            <p style="font-size: 9px;">
                [3] En el caso de tratarse de un desplazamiento externo

            </p>

        </div>


    </div>
</body>

</html>