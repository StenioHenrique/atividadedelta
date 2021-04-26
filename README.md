# crud-alunos

## Requisitos
* XAMPP
* Php
* MySQL

## Como instalar

1. Ter o XAMPP configurado e funcionando;

2. Acessar como administrador e editar o arquivo C:\Windows\System32\drivers\etc\hosts 

* Adicionar ao final do arquivo a seguinte linha
    127.0.0.1	atividadedeltastansilvateste.000webhostapp.com

3. Acessar o arquivo C:\xampp\apache\conf\extra\httpd-vhosts.conf
    <VirtualHost *:80>
        ServerAdmin webmaster@dummy-host2.example.com
        DocumentRoot "C:/xampp/htdocs/atividadedelta/public"
        ServerName atividadedeltastansilvateste.000webhostapp.com
        ErrorLog "logs/atividadedeltastansilvateste.000webhostapp.com-error.log"
        CustomLog "logs/atividadedeltastansilvateste.000webhostapp.com--access.log" common
    </VirtualHost> 

## Como executar


* É necessário executar os códigos para a criação do banco de dados/tabelas no cliente SQL, o arquivo contendo os códigos está em /sql/instituicao.sql
* É necessário configurar as credenciais do banco de dados no arquivo app/config/Database.php

4. Após a criação do VirtualHost e configuração do bando de dados acessar o link: 
* http://atividadedeltastansilvateste.000webhostapp.com/