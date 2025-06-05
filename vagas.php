<?php
require 'conexao.php';
require 'distancias.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['empresa'], $data['titulo'], $data['localizacao'], $data['nivel'])) {
    http_response_code(400);
    exit;
}

$id = uniqid();
$empresa = $data['empresa'];
$titulo = $data['titulo'];
$descricao = $data['descricao'] ?? null;
$localizacao = strtoupper($data['localizacao']);
$nivel = intval($data['nivel']);

if (!in_array($localizacao, array_keys(getMapa())) || $nivel < 1 || $nivel > 5) {
    http_response_code(422);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO vagas (id, empresa, titulo, descricao, localizacao, nivel) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id, $empresa, $titulo, $descricao, $localizacao, $nivel]);
    http_response_code(201);
} catch (Exception $e) {
    http_response_code(422);
}
?>