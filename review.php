<?php
// review.php
// Omogućuje korisniku ostavljanje recenzije nakon obavljene šetnje

session_start();
require_once __DIR__.'/config/config.php';

// Samo prijavljeni korisnici mogu ostaviti recenziju
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '')!=='user'){
    header('Location: index.php');
    exit;
}
$user_id=$_SESSION['user_id'];
$res_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// ID rezervacije obavezno mora postojati
if(!$res_id){
    echo 'Nepoznata rezervacija.';
    exit;
}

// Provjera da li je rezervacija korisnika odrađena
$stmt=$pdo->prepare('SELECT completed FROM reservations WHERE id=? AND reserved_by_user=?');
$stmt->execute([$res_id,$user_id]);
$res=$stmt->fetch();
if(!$res || !$res['completed']){
    echo 'Rezervacija nije pronađena ili nije odrađena.';
    exit;
}
// Provjeri postoji li već recenzija za tu rezervaciju
$exists=$pdo->prepare('SELECT id FROM reviews WHERE reservation_id=? AND user_id=?');
$exists->execute([$res_id,$user_id]);
$rev=$exists->fetch();
if($_SERVER['REQUEST_METHOD']==='POST' && !$rev){
    $content=trim($_POST['content'] ?? '');
    if($content!==''){
        $pdo->prepare('INSERT INTO reviews(reservation_id,user_id,content) VALUES(?,?,?)')
            ->execute([$res_id,$user_id,$content]);
        $rev=['id'=>$pdo->lastInsertId()];
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Recenzija</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
</head>
<body>
<?php // Navigacija
include __DIR__.'/elementi/nav.php'; ?>
<div class="container py-5">
<h1 class="mb-4">Ostavite recenziju</h1>
<?php if($rev): ?>
<div class="alert alert-success">Hvala na recenziji!</div>
<?php else: ?>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Vaša recenzija</label>
    <textarea name="content" class="form-control" required></textarea>
  </div>
  <button class="btn btn-primary">Pošalji</button>
</form>
<?php endif; ?>
<p class="mt-3"><a href="account.php?tab=history" class="btn btn-secondary">Natrag</a></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
