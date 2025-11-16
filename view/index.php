<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Receitas</title>
</head>
<body>
    <div class="container">
        <h1>Receitas</h1>

        <div class="header-actions">
            <form action="index.php" method="get" class="form-search">
                <input type="text" name="busca" placeholder="Buscar receita">
                <button type="submit">Buscar</button>
            </form>
            <a href="view/crud.php" class="btn-adicionar">+ Adicionar Receita</a>
        </div>

        <?php
        require __DIR__ . '/../db/conexao.php';
        $busca = isset($_GET['busca']) ? strtolower(trim($_GET['busca'])) : '';
        $json_data = file_get_contents(__DIR__ . '/../data/receitas.json');
        $receitas_json = json_decode($json_data, true) ?: [];

        
        $todas_receitas = [];

        // JSON
        foreach ($receitas_json as $receita) {
            $receita['source'] = 'json';
            $todas_receitas[] = $receita;
        }

        // banco de Dados
        $query = "SELECT * FROM receitas ORDER BY id DESC";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($receita = mysqli_fetch_assoc($result)) {
                $receita['source'] = 'db'; 
                $receita['resumo'] = ['tempo' => $receita['tempo']];
                $receita['tags'] = !empty($receita['tags']) ? explode(',', $receita['tags']) : [];
                $todas_receitas[] = $receita;
            }
        }
        mysqli_close($conn);
        ?>

        <div class="receitas">
            <?php
            foreach ($todas_receitas as $receita) {
                
                if ($busca === '' || strpos(strtolower($receita['titulo']), $busca) !== false) {
                    echo '<a href="view/detalhe.php?id=' . $receita['id'] . '&source=' . $receita['source'] . '" class="receita-card">';
                    
                    if (!empty($receita['thumbnail'])) {
                        echo '<img src="' . htmlspecialchars($receita['thumbnail']) . '" alt="' . htmlspecialchars($receita['titulo']) . '">';
                    } else {
                        echo '<img src="assets/img/placeholder.png" alt="Sem imagem" style="background-color: #e0c9f0;">';
                    }
                    
                    echo '<div class="receita-card-content">'; 
                    echo '<h2>' . htmlspecialchars($receita['titulo']) . '</h2>';                  
                    echo '<div class="tags">';                        
                    foreach ($receita['tags'] as $tag) {
                        echo '<span>' . htmlspecialchars(trim($tag)) . '</span>';
                    }
                    echo '</div>';                        
                    echo '<p class="tempo-preparo">' . htmlspecialchars($receita['resumo']['tempo']) .  '</p>';
                    echo '</div>'; 
                    echo '</a>';
                }
            }
            ?>
        </div>

</body>
</html>