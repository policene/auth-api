<?php

function getConnection() {
    $host = 'postgres';
    $dbname = 'auth-db';
    $port = '5432';
    $user = 'user';
    $pass = 'password';

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    try {
        return new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        die('Erro na conexão: ' . $e->getMessage());
    }
}

function initializeTables() {
    try {
        $pdo = getConnection();
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL
            );
        ";
        
        $pdo->exec($sql);
    } catch (PDOException $e) {
        die('Error initializing tables: ' . $e->getMessage());
    }
    
}

initializeTables();