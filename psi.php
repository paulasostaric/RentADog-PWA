<?php
// psi.php
// Prikazuje sve pse uz mogućnost filtriranja po veličini, starosti i temperamentu
session_start();
require_once __DIR__ . '/config/config.php';

$size = $_GET['size'] ?? '';
$age  = $_GET['age']  ?? '';
$temp = $_GET['temp'] ?? '';

$sql = 'SELECT * FROM dogs WHERE 1';  // osnovni upit
$params = [];                          // parametri za filtriranje
// Filtriranje po veličini psa
if ($size) {
    $sql .= ' AND size = ?';
    $params[] = $size;
}
// Filtriranje po temperamentu
if ($temp) {
    $sql .= ' AND LOWER(temperament) LIKE ?';
    $params[] = $temp === 'mirna' ? 'mirn%' : 'energic%';
}
// Filtriranje po starosti
switch ($age) {
    case 'stenci': // mlađi od godine dana
        $sql .= ' AND TIMESTAMPDIFF(MONTH, dob, CURDATE()) < 12';
        break;
    case 'mlad': // 1-3 godine
        $sql .= ' AND TIMESTAMPDIFF(YEAR, dob, CURDATE()) >= 1 AND TIMESTAMPDIFF(YEAR, dob, CURDATE()) < 3';
        break;
    case 'odrasli': // 3-7 godina
        $sql .= ' AND TIMESTAMPDIFF(YEAR, dob, CURDATE()) >= 3 AND TIMESTAMPDIFF(YEAR, dob, CURDATE()) < 7';
        break;
    case 'stariji': // 7+ godina
        $sql .= ' AND TIMESTAMPDIFF(YEAR, dob, CURDATE()) >= 7';
        break;
}

// Izvršavanje pripremljenog SQL upita
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$dogs = $stmt->fetchAll(); // svi filtrirani psi
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Naši psi | ProšećiMe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
  <link rel="stylesheet" href="css/psi.css">
</head>
<body>
  <?php include __DIR__ . '/elementi/nav.php'; ?>

  <main class="container py-5">
    <h1 class="fw-bold text-center mb-4">Naši psi</h1>

    <form class="row g-3 mb-5" id="filters" method="get">
      <div class="col-md-3">
        <select name="size" class="form-select">
          <option value="">Veličina (sve)</option>
          <option value="mali" <?= $size==='mali'? 'selected':'' ?>>Mali</option>
          <option value="srednji" <?= $size==='srednji'? 'selected':'' ?>>Srednji</option>
          <option value="veliki" <?= $size==='veliki'? 'selected':'' ?>>Veliki</option>
        </select>
      </div>
      <div class="col-md-3">
        <select name="age" class="form-select">
          <option value="">Starost (sve)</option>
          <option value="stenci" <?= $age==='stenci'? 'selected':'' ?>>Štenci</option>
          <option value="mlad" <?= $age==='mlad'? 'selected':'' ?>>Mladi</option>
          <option value="odrasli" <?= $age==='odrasli'? 'selected':'' ?>>Odrasli</option>
          <option value="stariji" <?= $age==='stariji'? 'selected':'' ?>>Stariji</option>
        </select>
      </div>
      <div class="col-md-3">
        <select name="temp" class="form-select">
          <option value="">Temperament (svi)</option>
          <option value="mirna" <?= $temp==='mirna'? 'selected':'' ?>>Mirna</option>
          <option value="energicna" <?= $temp==='energicna'? 'selected':'' ?>>Energična</option>
        </select>
      </div>
      <div class="col-md-3 text-md-end">
        <button class="btn btn-primary">Filtriraj</button>
        <a href="psi.php" class="btn btn-secondary ms-2">Resetiraj</a>
      </div>
    </form>

    <div class="row g-4" id="dogsGrid">
      <?php foreach ($dogs as $d):
        $ageYears = floor((time() - strtotime($d['dob'])) / 31536000);
        if ($ageYears < 1) $ageCat = 'stenci';
        elseif ($ageYears < 3) $ageCat = 'mlad';
        elseif ($ageYears < 7) $ageCat = 'odrasli';
        else $ageCat = 'stariji';
        $tclass = (stripos($d['temperament'], 'mirn') !== false) ? 'mirna' : 'energicna';
      ?>
      <div class="col-md-3 dog-card" data-size="<?= htmlspecialchars($d['size']) ?>" data-age="<?= $ageCat ?>" data-temp="<?= $tclass ?>">
        <a href="dog.php?id=<?= $d['id'] ?>" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm">
            <img src="img/<?= htmlspecialchars($d['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($d['name']) ?>">
            <div class="card-body">
              <h5 class="card-title fw-semibold"><?= htmlspecialchars($d['name']) ?></h5>
              <p class="small mb-1"><?= htmlspecialchars($d['breed']) ?>, <?= date('j.n.Y', strtotime($d['dob'])) ?>.</p>
              <?php if ($tclass==='mirna'): ?>
                <span class="badge bg-success">Mirna</span>
              <?php else: ?>
                <span class="badge bg-info">Energična</span>
              <?php endif; ?>
            </div>
          </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </main>

  <?php include __DIR__ . '/elementi/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
