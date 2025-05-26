<?php

function getConnection() {
    $host = 'localhost';
    $dbname = 'auth-api';
    $port = '5433';
    $user = 'user';
    $pass = 'password';

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    try {
        return new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        die('Erro na conexão: ' . $e->getMessage());
    }
}