<?php
// Define o número de jogos, o número de elementos por jogo e o intervalo dos números
// NUM_GAMES = 10;          // Quantidade de jogos
// NUM_ELEMENTS = 15;      // Quantidade de números únicos por jogo
// MIN_VALUE = 1;          // Valor mínimo
// MAX_VALUE = 25;         // Valor máximo
// MAX_PARTICIPATION = 30;

define("NUM_GAMES", 48);
define("NUM_ELEMENTS", 6);
define("MIN_VALUE", 1);
define("MAX_VALUE", 60);
define("MAX_PARTICIPATION", 12);


// Função para gerar um array de números únicos
function generateUniqueNumbers($numElements, $minValue, $maxValue)
{
    $allNumbers = range($minValue, $maxValue);
    shuffle($allNumbers);
    return array_slice($allNumbers, 0, $numElements);
}

// Cria o array de jogos
$games = array();
for ($i = 0; $i < NUM_GAMES; $i++) {
    $gameNumbers = generateUniqueNumbers(NUM_ELEMENTS, MIN_VALUE, MAX_VALUE);
    sort($gameNumbers);
    $games[] = $gameNumbers;
}

// Função para calcular a porcentagem de participação de cada número
function calculateParticipationPercentage($games)
{
    $totalGames = count($games);
    $frequency = array_fill(MIN_VALUE, MAX_VALUE, 0); // Frequência de cada número (1 a 25)

    // Contar a frequência de cada número
    foreach ($games as $game) {
        foreach ($game as $number) {
            $frequency[$number]++;
        }
    }

    // Calcular a porcentagem de participação
    $participation = array();
    foreach ($frequency as $number => $count) {
        $participation[$number] = ($count / $totalGames) * 100;
    }

    return $participation;
}


function substituirValor(array $array, $valorAntigo, $valorNovo)
{
    // Itera sobre o array
    foreach ($array as $chave => $valor) {
        // Verifica se o valor atual é igual ao valor a ser substituído
        if ($valor === $valorAntigo) {
            // Substitui o valor antigo pelo valor novo
            $array[$chave] = $valorNovo;
            // var_dump(['array: ', $array]);
        }
    }
    // Retorna o array modificado
    return $array;
}


// Calcular a porcentagem de participação
$participation = calculateParticipationPercentage($games);


// Cria o array de jogos | String
$games_strings = array();
foreach ($games as $game) {
    $games_strings[] = implode('-', $game);
}

sort($games_strings);

echo "<h2>Jogos</h2>";
$counter = 1;
foreach ($games_strings as $string) {
    echo "#" . $counter++ . ": {$string}<br>";
}

// Exibir a porcentagem ajustada de participação
echo "<h2>Porcentagem de Participação | Inicial</h2>";
asort($participation);
foreach ($participation as $number => $percentage) {
    echo "<div " . ($percentage >= MAX_PARTICIPATION ? "style='color: red;'" : '') . ">Número: $number - " . number_format($percentage, 1) . "%</div>";
}

// Refazer jogos | Ajustar a Participação dos números
asort($participation);
// var_dump($games);
for ($i = 0; $i < count($games); $i++) {
    $game = $games[$i];

    for ($j = 0; $j < count($game); $j++) {
        $number = $game[$j];
        $alterado = false;

        if ($participation[$number] >= MAX_PARTICIPATION) {

            // $maiorValor = max($participation);
            // $key = array_search($maiorValor, $participation);

            // arsort($participation);

            // if (!in_array($key, $game)) {
            //     $game = substituirValor($game, $number, $key);

            //     $games[$i] = $game;
            //     sort($games[$i]);
            //     $alterado = true;
            // }


            for ($k = 0; $k < count($participation); $k++) {

                $key = array_keys($participation)[$k];

                if (!in_array($key, $game)) {
                    // echo "====================================================<br>";
                    // var_dump($games[$i]);

                    // Substitui o valor e atualiza o array
                    echo "{$number} => {$key}<br>";
                    $game = substituirValor($game, $number, $key);

                    $games[$i] = $game;
                    sort($games[$i]);
                    // var_dump($games[$i]);
                    // echo "====================================================<br>";
                    $alterado = true;
                    break;
                }
            }
        }

        if ($alterado) {
            break;
        }
    }

    // Atualiza a participação após o loop interno
    $participation = calculateParticipationPercentage($games);
    asort($participation);

    // var_dump($participation);

}

$participation = calculateParticipationPercentage($games);
asort($participation);



// Exibir a porcentagem ajustada de participação
echo "<h1>=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=</h1>";
echo "<h2>Porcentagem de Participação | Ajustada</h2>";
foreach ($participation as $number => $percentage) {
    echo "<div " . ($percentage >= MAX_PARTICIPATION ? "style='color: red;'" : '') . ">Número: $number - " . number_format($percentage, 1) . "%</div>";
}


// Cria o array de jogos | String
$games_strings = array();
foreach ($games as $game) {

    foreach ($game as $key => $value) {
        $game[$key] = ($value < 10 ? "0{$value}" : $value);
    }

    $games_strings[] = implode('-', $game);
}

sort($games_strings);

echo "<h2>Jogos | aJUSTADOS</h2>";
$counter = 1;
foreach ($games_strings as $string) {
    echo "#" . ($counter < 10 ? "0{$counter}" : $counter) . ": {$string}<br>";

    $counter++;
}
