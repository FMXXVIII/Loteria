<?php

$numGames = 10;          // Quantidade de jogos
$numElements = 15;      // Quantidade de números únicos por jogo
$minValue = 1;          // Valor mínimo
$maxValue = 25;         // Valor máximo
$maxParticipation = 65; // % máxima que um número pode ter participação

$listNumber = range($minValue, $maxValue);
$games = array(); // Array para armazenar os jogos
$numberParticipation = array_fill($minValue, $maxValue, 0); // Contador de participação de cada número

$count = 0;

while ($count < $numGames) {
    $count++;

    $game = array();
    while (count($game) < $numElements) {
        // Escolher um número aleatório dentro do intervalo
        $randomNumber = rand($minValue, $maxValue);

        // Verificar se o número já está no jogo e se sua participação está dentro do limite
        if (!in_array($randomNumber, $game) && ($numberParticipation[$randomNumber] < ($numGames * ($maxParticipation / 100)))) {
            $game[] = ($randomNumber < 10 ? "0{$randomNumber}" : $randomNumber);
            $numberParticipation[$randomNumber]++; // Aumenta a contagem de participação do número
        }
    }

    sort($game);
    $game = implode('-', $game);

    // Adicionar o jogo à lista de jogos
    $games[] = $game;
}

sort($games);

// Exibir os jogos gerados
var_dump($games);

foreach ($numberParticipation as $key => $value) {
    echo ($key < 10 ? "0{$key}" : $key)." : ".(($value * 100) / $numGames)."%<br>";
}

var_dump($numberParticipation);
sort($numberParticipation);
var_dump($numberParticipation);