<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor e interpretador de Logs</title>
    <?php require 'funcoes.php'; ?>
    <?php require 'class_piloto.php'; ?>
</head>

<body>
    <?php

    $aquivo_array = ler_arquivo("files/a.log");
    $array_pilotos = preenche_objeto_piloto($aquivo_array);
    $pilotos_resultados = processar_dados($array_pilotos);
    ?>
    <hr>
 
    <table style="width: 70%; margin: 0px auto ;">
        <tr>
            <th style="text-align: left;">Posição de Chegada</th>
            <th style="text-align: left;">Cod.</th>
            <th style="text-align: left;">Nome</th>
            <th style="text-align: left;">Voltas completadas</th>
            <th style="text-align: left;">Melhor Volta</th>
            <th style="text-align: left;">Tempo de Prova</th>
        </tr>
        <?php foreach ($pilotos_resultados as $piloto_resultado) { ?>
        <tr>
            <td><?php echo $piloto_resultado["Posição de Chegada"]; ?></td>
            <td><?php echo $piloto_resultado["Cod. Piloto"]; ?></td>
            <td><?php echo $piloto_resultado["Nome Piloto"]; ?></td>
            <td><?php echo $piloto_resultado["Voltas completadas"]; ?></td>
            <td><?php echo $piloto_resultado["Melhor Volta"]; ?></td>
            <td><?php echo $piloto_resultado["Tempo de Prova"]; ?></td>
        </tr>
        <?php } ?>
    </table>
 <hr>
</body>

</html>