<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Receitas</title>
</head>
<body>
    <div class="container">
        <h1>Receitas</h1>

        <form action="index.php" method="get" class="form-search">
            <input type="text" name="busca" placeholder="Buscar receita">
            <button type="submit">Buscar</button>
        </form>

    <div class="receitas">
        <?php
        $json_data = file_get_contents('receitas.json');
        $receitas = json_decode($json_data, true);

        $busca = isset($_GET['busca']) ? strtolower(trim($_GET['busca'])) : '';

        if ($receitas){
            foreach ($receitas as $receita){
                if ($busca === '' || strpos(strtolower($receita['nome']), $busca) !== false){
                    //exibir receitas

                    //delahe.php no fu
                    echo '<a href="detalhe.php?id=' . $receita['id'] . '" class="receitas">';
                    echo '<img src="' . htmlspecialchars($receita['thumbnail']) . '" alt="' . htmlspecialchars($receita['titulo']) . '">';
                    echo '<h2>' . htmlspecialchars($receita['titulo']) . '</h2>';
                    echo '<div class="tags">';
                    foreach ($receita['tags'] as $tag) {
                        echo '<span>' . htmlspecialchars(string: $tag) . '</span>';
                    }
                    echo '</div>';
                    echo '<p class="tempo-preparo">' . htmlspecialchars($receita['tempo']) . '</p>';
                    echo '</a>';
                }
            }

        }




        ?>



</body>
</html>