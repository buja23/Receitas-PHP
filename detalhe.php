<?php
$receita_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$receita_encontrada = null;

if ($receita_id > 0) {
    $json_data = file_get_contents('data/receitas.json');
    $receitas = json_decode($json_data, true);

    if ($receitas) {
        foreach ($receitas as $receita) {
            if ($receita['id'] === $receita_id) {
                $receita_encontrada = $receita;
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title><?php echo $receita_encontrada ? htmlspecialchars($receita_encontrada['titulo']) : 'Receita não encontrada'; ?></title>
</head>
<body>
    <div class="container">
        <?php if ($receita_encontrada): ?>
            <h1><?php echo htmlspecialchars($receita_encontrada['titulo']); ?></h1>
            <img class="detalhe-img" src="<?php echo htmlspecialchars($receita_encontrada['thumbnail']); ?>" alt="<?php echo htmlspecialchars($receita_encontrada['titulo']); ?>">
            <nav class="recipe-nav">
                <ul>
                    <li><a href="#resumo">Resumo</a></li>
                    <li><a href="#ingredientes">Ingredientes</a></li>
                    <li><a href="#modo-preparo">Modo de preparo</a></li>
                </ul>
            </nav>
   
            <div class="resumo-box" id="resumo">
                <h3>Resumo</h3>
                <ul>
                    <li>Nível:</strong> <?php echo htmlspecialchars($receita_encontrada['resumo']['nivel']); ?></li>
                    <li>Tempo:</strong> <?php echo htmlspecialchars($receita_encontrada['resumo']['tempo']); ?></li>
                    <li>Pessoas:</strong> <?php echo htmlspecialchars($receita_encontrada['resumo']['pessoas']); ?></li>
                </ul>
            </div>
            <h2>Descrição</h2>
            <p><?php echo htmlspecialchars($receita_encontrada['descricao']); ?></p>
            <h2 id="ingredientes">Ingredientes</h2>
            <ul>
                <?php foreach ($receita_encontrada['ingredientes'] as $ingrediente): ?>
                    <li><?php echo htmlspecialchars($ingrediente); ?></li>
                <?php endforeach; ?>
            </ul>
            <h2 id="modo-preparo">Modo de preparo</h2>
            <div class="modo-preparo">
                <ol>
                    <?php foreach ($receita_encontrada['modo_preparo'] as $passo): ?>
                        <li><?php echo htmlspecialchars($passo); ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        <?php else: ?>
            <h1>Receita não encontrada</h1>
            <p>A receita que você procura não foi encontrada.</p>
        <?php endif; ?>
        <a href="index.php" class="back-link">Voltar para a lista</a>
    </div>
</body>
</html>