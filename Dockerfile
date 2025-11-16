FROM php:8.2-apache

# Instala as extensões PHP necessárias para o projeto
# mysqli para a conexão com o banco de dados
# zip para o Composer
RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
    && docker-php-ext-install mysqli zip && docker-php-ext-enable mysqli

# Define o diretório de trabalho
WORKDIR /var/www/html

