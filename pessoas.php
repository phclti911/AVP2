<?php
require 'conexao.php';
require 'distancias.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['nome'], $data['profissao'], $data['localizacao'], $data['nivel'])) {
    http_response_code(400);
    exit;
}

$id = uniqid();
$nome = $data['nome'];
$profissao = $data['profissao'];
$localizacao = strtoupper($data['localizacao']);
$nivel = intval($data['nivel']);

if (!in_array($localizacao, array_keys(getMapa())) || $nivel < 1 || $nivel > 5) {
    http_response_code(422);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO pessoas (id, nome, profissao, localizacao, nivel) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id, $nome, $profissao, $localizacao, $nivel]);
    http_response_code(201);
} catch (Exception $e) {
    http_response_code(422);
}
?>