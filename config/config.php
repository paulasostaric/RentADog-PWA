<?php
// config.php
// Postavke povezivanja na MySQL bazu
$host   = '127.0.0.1';       // adresa servera baze
$db     = 'rentadog';        // naziv baze podataka
$user   = 'root';            // korisničko ime
$pass   = '';                // lozinka
$charset= 'utf8mb4';         // korišteni skup znakova

$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // DSN string za PDO
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // bacanje iznimki na pogrešku
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // podatke dohvaćamo kao asoc. polje
  PDO::ATTR_EMULATE_PREPARES   => false,                  // koristimo prave prepared statments
];

// Kreiramo PDO instancu i hvatamo eventualne pogreške
try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  exit("DB error: " . $e->getMessage());
}
