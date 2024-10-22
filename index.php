<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Moedas</title>
</head>
<body>

    <h1>Conversor de Moedas</h1>
    
    <form method="POST" action="">
        <label for="valor">Valor a ser convertido:</label>
        <input type="text" id="valor" name="valor">

        <label for="moedaOrigem">Moeda de origem:</label>
        <select id="moedaOrigem" name="moedaOrigem">
            <option value="USD">Dólar</option>
            <option value="EUR">Euro</option>
            <option value="BRL">Real</option>
        </select>

        <label for="moedaDestino">Moeda de destino:</label>
        <select id="moedaDestino" name="moedaDestino">
            <option value="USD">Dólar</option>
            <option value="EUR">Euro</option>
            <option value="BRL">Real</option>
        </select>

        <button type="submit">Converter</button>
    </form>

    <?php
    function validarEntrada($valor) {
        return is_numeric($valor) && $valor > 0;
    }

    function converterMoeda($valor, $taxaConversao) {
        return function() use ($valor, $taxaConversao) {
            return $valor * $taxaConversao;
        };
    }

    function obterTaxaConversao($moedaOrigem, $moedaDestino) {
        $taxas = [
            'USD_BRL' => 5.25,
            'BRL_USD' => 0.19,
            'USD_EUR' => 0.85,
            'EUR_USD' => 1.18,
            'EUR_BRL' => 6.20,
            'BRL_EUR' => 0.16
        ];

        $chave = "{$moedaOrigem}_{$moedaDestino}";

        return $taxas[$chave] ?? 1;
    }

    function filtrarMoedasValidas($moedaOrigem, $moedaDestino) {
        $moedasDisponiveis = ['USD', 'EUR', 'BRL'];
        return in_array($moedaOrigem, $moedasDisponiveis) && in_array($moedaDestino, $moedasDisponiveis);
    }

    function exibirResultado($moedaOrigem, $moedaDestino, $valorConvertido) {
        echo "<p>Valor convertido de $moedaOrigem para $moedaDestino: $valorConvertido</p>";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $valor = $_POST['valor'];
        $moedaOrigem = $_POST['moedaOrigem'];
        $moedaDestino = $_POST['moedaDestino'];

        if (!validarEntrada($valor)) {
            echo "<p style='color: red;'>Por favor, insira um valor numérico positivo.</p>";
        } elseif (!filtrarMoedasValidas($moedaOrigem, $moedaDestino)) {
            echo "<p style='color: red;'>Seleção de moedas inválida.</p>";
        } else {
            $taxaConversao = obterTaxaConversao($moedaOrigem, $moedaDestino);

            $valorConvertido = converterMoeda($valor, $taxaConversao)();

            exibirResultado($moedaOrigem, $moedaDestino, $valorConvertido);
        }
    }
    ?>

    <footer>
        <p>Desenvolvido por: <a href="https://github.com/PauloWarmling">Paulo Warmling</a></p>
    </footer>

</body>
</html>
