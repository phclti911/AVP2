<?php
require 'conexao.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id_vaga'], $data['id_pessoa'])) {
    http_response_code(400);
    exit;
}

$id = uniqid();
$id_vaga = $data['id_vaga'];
$id_pessoa = $data['id_pessoa'];

$stmtVaga = $pdo->prepare("SELECT id FROM vagas WHERE id = ?");
$stmtVaga->execute([$id_vaga]);
if ($stmtVaga->rowCount() === 0) {
    http_response_code(404);
    exit;
}

$stmtPessoa = $pdo->prepare("SELECT id FROM pessoas WHERE id = ?");
$stmtPessoa->execute([$id_pessoa]);
if ($stmtPessoa->rowCount() === 0) {
    http_response_code(404);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO candidaturas (id, id_vaga, id_pessoa) VALUES (?, ?, ?)");
    $stmt->execute([$id, $id_vaga, $id_pessoa]);
    http_response_code(201);
} catch (Exception $e) {
    http_response_code(400);
}
?>