<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=snake_and_ladder', 'ashwin', 'dev');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>