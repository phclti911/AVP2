<?php
require 'conexao.php';
require 'distancias.php';

header('Content-Type: application/json');

$id_vaga = $_GET['id'] ?? '';

$stmtVaga = $pdo->prepare("SELECT * FROM vagas WHERE id = ?");
$stmtVaga->execute([$id_vaga]);
$vaga = $stmtVaga->fetch(PDO::FETCH_ASSOC);

if (!$vaga) {
    http_response_code(404);
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.*, c.id as candidatura_id 
    FROM candidaturas c 
    JOIN pessoas p ON c.id_pessoa = p.id 
    WHERE c.id_vaga = ?
");
$stmt->execute([$id_vaga]);
$candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$resultado = [];

foreach ($candidatos as $cand) {
    $dist = menorDistancia($vaga['localizacao'], $cand['localizacao']);
    $D = calcularD($dist);
    $N = 100 - 25 * abs($vaga['nivel'] - $cand['nivel']);
    $score = intval(($N + $D) / 2);

    $resultado[] = [
        'id_candidatura' => $cand['candidatura_id'],
        'id_pessoa' => $cand['id'],
        'nome' => $cand['nome'],
        'profissao' => $cand['profissao'],
        'localizacao' => $cand['localizacao'],
        'nivel' => intval($cand['nivel']),
        'score' => $score
    ];
}

usort($resultado, fn($a, $b) => $b['score'] <=> $a['score']);

echo json_encode($resultado);
?>