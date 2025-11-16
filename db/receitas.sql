-- Tabela de Receitas
-- Esta estrutura corresponde ao que o código PHP em view/crud.php espera.
CREATE TABLE IF NOT EXISTS receitas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    thumbnail VARCHAR(255),
    tags VARCHAR(255),
    ingredientes TEXT,
    modo_preparo TEXT,
    tempo VARCHAR(50),
    pessoas VARCHAR(50),
    nivel VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Você pode adicionar aqui alguns dados iniciais se desejar, por exemplo:
-- INSERT INTO receitas (titulo, descricao, tags, ingredientes, modo_preparo, tempo, pessoas, nivel) VALUES 
-- ('Bolo de Cenoura', 'Bolo de cenoura com cobertura de chocolate.', 'bolo,doce,café', 'Cenoura\nOvos\nFarinha', 'Bata tudo e asse.', '40 min', '8 porções', 'Fácil');

