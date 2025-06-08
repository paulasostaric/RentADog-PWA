<?php
// donacija.php
// Informacije o podršci i upute za uplatu
session_start();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donacije | ProšećiMe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php // Navigacija stranice
include('elementi/nav.php'); ?>
<main class="container py-5">
  <h1 class="fw-bold text-center mb-4">Podržite naš rad</h1>
  <p class="lead text-center mb-5">Svaka donacija pomaže Dumovcu u brizi za pse i organizaciji šetnji. Hvala što pomažete proširiti repiće sreće!</p>
  <div class="row justify-content-center mb-5">
    <div class="col-md-6">
      <div class="p-4 border rounded-4">
        <h5 class="fw-semibold mb-3">Bankovna uplata</h5>
        <p class="mb-1">Primatelj: Udruga Dumovec</p>
        <p class="mb-1">IBAN: <strong>HR12 2400 0000 0000 0000 5</strong></p>
        <p class="mb-0">Opis plaćanja: Donacija za pse</p>
      </div>
    </div>
  </div>
  <div class="text-center">
    <p class="mb-3">Radije bi nam poslali opremu ili hranu? Javite nam se putem <a href="kontakt.php">kontakta</a>.</p>
  </div>
</main>
<?php // Podnožje stranice
include('elementi/footer.php'); ?>
</body>
</html>
