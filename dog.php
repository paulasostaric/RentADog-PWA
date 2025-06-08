<?php
// dog.php
// Prikaz detalja pojedinog psa i forma za rezervaciju šetnje

session_start();
require_once __DIR__ . '/config/config.php';

if (!isset($_GET['id'])) {
    header('Location: psi.php');
    exit;
}
$dog_id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM dogs WHERE id = ?");
$stmt->execute([$dog_id]);
$dog = $stmt->fetch();
if (!$dog) {
    echo "Pas nije pronađen.";
    exit;
}

$durations = array_filter(array_map('trim', explode(',', $dog['durations']))); // moguća trajanja
$locations = array_filter(array_map('trim', explode(',', $dog['locations'])));   // dostupne lokacije

$additional = [];
$base = pathinfo($dog['image'], PATHINFO_FILENAME);
// Provjera postoje li dodatne slike uz glavnu
for ($i = 1; $i <= 3; $i++) {
    $candidate = "img/{$base}_$i.jpeg";
    if (file_exists(__DIR__ . "/$candidate")) {
        $additional[] = $candidate;
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?=htmlspecialchars($dog['name'])?> | ProšećiMe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
</head>
<body>
<?php include __DIR__.'/elementi/nav.php'; ?>
<main class="container py-5">
  <h1 class="mb-3"><?=htmlspecialchars($dog['name'])?></h1>
  <div class="row align-items-start g-4">
    <div class="col-md-4">
      <p><strong>Pasmina:</strong> <?=htmlspecialchars($dog['breed'])?><br>
         <strong>Rođendan:</strong> <?=date('j.n.Y',strtotime($dog['dob']))?><br>
         <strong>Temperament:</strong> <?=htmlspecialchars($dog['temperament'])?></p>
      <form method="post" action="rezervacije.php" class="mb-3">
        <input type="hidden" name="dog_id" value="<?=$dog['id']?>">
        <div class="mb-2">
          <label class="form-label">Trajanje šetnje</label>
          <select name="duration" class="form-select">
            <?php foreach($durations as $d): ?>
              <option value="<?=$d?>"><?=$d==30? '30 min' : ($d/60).' sat'.($d>60?'a':'')?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Lokacija</label>
          <select name="location" class="form-select">
            <?php foreach($locations as $loc): ?>
              <option value="<?=htmlspecialchars($loc)?>"><?=ucfirst($loc)?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button class="btn btn-primary">Rezerviraj šetnju</button>
      </form>
    </div>
    <div class="col-md-8 text-center">
      <img src="img/<?=htmlspecialchars($dog['image'])?>" class="img-fluid rounded mb-3" style="max-height:400px" alt="<?=htmlspecialchars($dog['name'])?>">
    </div>
  </div>
<?php if($additional): ?>
  <div class="row g-3 mt-2">
  <?php foreach ($additional as $img): ?>
    <div class="col-md-4">
      <img src="<?=htmlspecialchars($img)?>" class="img-fluid rounded" alt="<?=htmlspecialchars($dog['name'])?>">
    </div>
  <?php endforeach; ?>
  </div>
<?php endif; ?>
</main>
<?php include __DIR__.'/elementi/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
