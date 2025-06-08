<?php
// dog_form.php
// Obrazac za dodavanje ili uređivanje podataka o psu (samo za admina)

session_start();
require_once __DIR__.'/config/config.php';
if(($_SESSION['role'] ?? '') !== 'admin'){
    header('Location: index.php');
    exit;
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$dog = ['name'=>'','breed'=>'','dob'=>'','temperament'=>'','size'=>'srednji','image'=>'','durations'=>'60','locations'=>'park'];
if($id){
    $stmt = $pdo->prepare('SELECT * FROM dogs WHERE id=?');
    $stmt->execute([$id]);
    $dog = $stmt->fetch();
    if(!$dog){
        echo 'Pas nije pronađen.';
        exit;
    }
}
// Slanje forme
if($_SERVER['REQUEST_METHOD']==='POST'){
    $data = [
        $_POST['name'] ?? '',
        $_POST['breed'] ?? '',
        $_POST['dob'] ?? '',
        $_POST['temperament'] ?? '',
        $_POST['size'] ?? 'srednji',
        $_POST['image'] ?? '',
        $_POST['durations'] ?? '60',
        $_POST['locations'] ?? 'park'
    ];
    if($id){
        $stmt = $pdo->prepare('UPDATE dogs SET name=?,breed=?,dob=?,temperament=?,size=?,image=?,durations=?,locations=? WHERE id=?');
        $data[] = $id;
        $stmt->execute($data);
    }else{
        $stmt = $pdo->prepare('INSERT INTO dogs(name,breed,dob,temperament,size,image,durations,locations) VALUES(?,?,?,?,?,?,?,?)');
        $stmt->execute($data);
    }
    header('Location: admin.php?tab=dogs');
    exit;
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $id? 'Uredi' : 'Dodaj' ?> psa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
</head>
<body>
<?php include __DIR__.'/elementi/nav.php'; ?>
<div class="container py-5">
<h1 class="mb-4"><?= $id? 'Uredi' : 'Dodaj' ?> psa</h1>
<form method="post">
  <div class="mb-3"><label class="form-label">Ime</label><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($dog['name']) ?>" required></div>
  <div class="mb-3"><label class="form-label">Pasmina</label><input type="text" name="breed" class="form-control" value="<?= htmlspecialchars($dog['breed']) ?>" required></div>
  <div class="mb-3"><label class="form-label">Datum rođenja</label><input type="date" name="dob" class="form-control" value="<?= htmlspecialchars($dog['dob']) ?>" required></div>
  <div class="mb-3"><label class="form-label">Temperament</label><input type="text" name="temperament" class="form-control" value="<?= htmlspecialchars($dog['temperament']) ?>" required></div>
  <div class="mb-3">
    <label class="form-label">Veličina</label>
    <select name="size" class="form-select">
      <?php $sizes=['mali'=>'Mali','srednji'=>'Srednji','veliki'=>'Veliki']; ?>
      <?php foreach($sizes as $val=>$label): ?>
        <option value="<?= $val ?>" <?= $dog['size']===$val?'selected':'' ?>><?= $label ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3"><label class="form-label">Slika (naziv datoteke)</label><input type="text" name="image" class="form-control" value="<?= htmlspecialchars($dog['image']) ?>" required></div>
  <div class="mb-3"><label class="form-label">Trajanja (npr. 60,90)</label><input type="text" name="durations" class="form-control" value="<?= htmlspecialchars($dog['durations']) ?>" required></div>
  <div class="mb-3"><label class="form-label">Lokacije (npr. park,suma)</label><input type="text" name="locations" class="form-control" value="<?= htmlspecialchars($dog['locations']) ?>" required></div>
  <button class="btn btn-primary">Spremi</button>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
