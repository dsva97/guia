<?php

function json($data)
{
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); //Técnologia
}

function fncException($sMessage)
{
    throw new Exception(json_encode(["error" => $sMessage]), 1);
}

function fncValidateArray($ary)
{
    if (is_array($ary) && count($ary) > 0) {
        return true;
    }
    return false;
}
function strup($str)
{
    return   mb_strtoupper($str, 'utf-8');
}
function uc($string)
{
    return mb_convert_case(mb_strtolower($string, "UTF-8"), MB_CASE_TITLE, "UTF-8");
}

function sp($input, $pad = 8)
{
    return str_pad($input, $pad, "0", STR_PAD_LEFT);
}
