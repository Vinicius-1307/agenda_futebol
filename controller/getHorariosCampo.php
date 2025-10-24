<?php
include_once '../model/Campos.php';
session_start();

if (!isset($_GET['id_campo']) || !isset($_GET['data'])) {
    echo json_encode([]);
    exit;
}

$id_campo = intval($_GET['id_campo']);
$data = $_GET['data'];

$campo = new Campos();
$horarios = $campo->getHorariosDisponiveis($id_campo, $data);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($horarios);
