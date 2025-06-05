<?php
function getMapa() {
    return [
        'A' => ['B' => 5],
        'B' => ['A' => 5, 'C' => 7, 'D' => 3],
        'C' => ['B' => 7, 'E' => 4],
        'D' => ['B' => 3, 'E' => 10, 'F' => 8],
        'E' => ['C' => 4, 'D' => 10],
        'F' => ['D' => 8]
    ];
}

function menorDistancia($origem, $destino) {
    $mapa = getMapa();
    $distancias = [];
    $visitados = [];

    foreach ($mapa as $local => $_) {
        $distancias[$local] = INF;
    }
    $distancias[$origem] = 0;

    while (count($visitados) < count($mapa)) {
        $atual = null;
        foreach ($distancias as $local => $dist) {
            if (!isset($visitados[$local]) && ($atual === null || $dist < $distancias[$atual])) {
                $atual = $local;
            }
        }

        if ($atual === $destino) break;

        $visitados[$atual] = true;
        foreach ($mapa[$atual] as $vizinho => $distancia) {
            if (!isset($visitados[$vizinho])) {
                $novaDist = $distancias[$atual] + $distancia;
                if ($novaDist < $distancias[$vizinho]) {
                    $distancias[$vizinho] = $novaDist;
                }
            }
        }
    }
    return $distancias[$destino];
}

function calcularD($dist) {
    if ($dist <= 5) return 100;
    if ($dist <= 10) return 75;
    if ($dist <= 15) return 50;
    if ($dist <= 20) return 25;
    return 0;
}
?>