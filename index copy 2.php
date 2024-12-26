<?php

$numGames = 10;          // Quantidade de jogos
$numElements = 15;      // Quantidade de números únicos por jogo
$minValue = 1;          // Valor mínimo
$maxValue = 25;         // Valor máximo
$maximumPercentageParticipation = 60; // % máxima que um número pode ter participação

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
        if (!in_array($randomNumber, $game)) {
            $game[] = ($randomNumber < 10 ? $randomNumber : $randomNumber);
            $numberParticipation[$randomNumber]++; // Aumenta a contagem de participação do número
        }
    }

    // sort($game);
    // $game = implode('-', $game);

    // Adicionar o jogo à lista de jogos
    $games[] = $game;
}
unset($game);

sort($games);

// Exibir os jogos gerados
// var_dump($games);

var_dump($numberParticipation);
$before = $numberParticipation;

foreach ($games as $game) {
    $minParticipation = array_search(min($numberParticipation), $numberParticipation);
    $maxParticipation = array_search(max($numberParticipation), $numberParticipation);

    if (
        (($numberParticipation[$minParticipation] * 100) / $numGames) < $maximumPercentageParticipation
        &&
        (($numberParticipation[$maxParticipation] * 100) / $numGames) > $maximumPercentageParticipation
    ) {
        var_dump(["ganhou: {$minParticipation}", "perdeu: {$maxParticipation}"]);
        // var_dump($numberParticipation);
        $numberParticipation[$minParticipation]++;
        $numberParticipation[$maxParticipation]--;
    }
    // foreach ($game as $key => $number) {

    //     if((($numberParticipation[$number] * 100) / $numGames) > $maximumPercentageParticipation){

    //     }
    //     var_dump($number);
    // }
}

var_dump($numberParticipation);
$after = $numberParticipation;


echo "<div style='display: flex;'>";
echo "
<table>
    <thead>
        <tr>
            <th>before</th>
            <th>%</th>
        </tr>
    
    </thead>
    <tbody>";

    foreach ($before as $key => $value) {
       echo "<tr><td>{$key}</td><td>" . (($value * 100) / $numGames) . "</td></tr>";
    }

echo "
    </tbody>
</table>";


echo "
<table style='margin-left: 30px;'>
    <thead>
        <tr>
            <th>before</th>
            <th>%</th>
        </tr>
    
    </thead>
    <tbody>";

    foreach ($after as $key => $value) {
       echo "<tr><td>{$key}</td><td>" . (($value * 100) / $numGames) . "</td></tr>";
    }

echo "
    </tbody>
</table>

</div>";

// foreach ($numberParticipation as $key => $value) {
//     echo ($key < 10 ? "0{$key}" : $key) . " : " . (($value * 100) / $numGames) . "%<br>";
// }

// var_dump($numberParticipation);