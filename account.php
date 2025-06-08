<?php
// account.php
// Korisnički panel za pregled i uređivanje podataka te rezervacija

session_start();
require_once __DIR__.'/config/config.php';
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '')!=='user'){
    header('Location: index.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$tab = $_GET['tab'] ?? 'profile';
$feedback='';
$errors=[];
$stmt = $pdo->prepare('SELECT username,email,phone FROM users WHERE id=?');
$stmt->execute([$user_id]);
$u = $stmt->fetch();
if(!$u){
    echo 'Korisnik nije pronađen';
    exit;
}
if($_SERVER['REQUEST_METHOD']==='POST' && $tab==='profile'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'] ?? '';
    if($username==='') $errors[]='Korisničko ime je obavezno.';
    if($password!=='' && strlen($password)<6) $errors[]='Lozinka mora imati barem 6 znakova.';
    if(empty($errors)){
        if($password!==''){
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $pdo->prepare('UPDATE users SET username=?,email=?,phone=?,password_hash=? WHERE id=?')
                ->execute([$username,$email,$phone,$hash,$user_id]);
        }else{
            $pdo->prepare('UPDATE users SET username=?,email=?,phone=? WHERE id=?')
                ->execute([$username,$email,$phone,$user_id]);
        }
        $_SESSION['username']=$username;
        $feedback='Podaci ažurirani.';
        $u['username']=$username; $u['email']=$email; $u['phone']=$phone;
    }
}
// Dohvat svih rezervacija korisnika
$all=$pdo->prepare('SELECT r.id,d.name,r.reserved_for,r.time_slot,r.duration,r.location,r.completed FROM reservations r JOIN dogs d ON r.dog_id=d.id WHERE r.reserved_by_user=? ORDER BY r.reserved_for DESC');
$all->execute([$user_id]);
$resAll=$all->fetchAll();

// Pregled rezervacija koje su već recenzirane
$revStmt=$pdo->prepare('SELECT reservation_id FROM reviews WHERE user_id=?');
$revStmt->execute([$user_id]);
$reviewed=[];
foreach($revStmt->fetchAll() as $rv){$reviewed[$rv['reservation_id']]=true;}
$my=[];$history=[];
foreach($resAll as $r){
    if($r['completed']){$history[]=$r;}else{$my[]=$r;}
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Vaš račun</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
</head>
<body>
<?php include __DIR__.'/elementi/nav.php'; ?>
<div class="container py-5">
<h1 class="mb-4">Vaš račun</h1>
<ul class="nav nav-tabs mb-4">
 <li class="nav-item"><a class="nav-link <?= $tab==='profile'?'active':'' ?>" href="?tab=profile">Uređivanje profila</a></li>
 <li class="nav-item"><a class="nav-link <?= $tab==='reservations'?'active':'' ?>" href="?tab=reservations">Moje rezervacije</a></li>
 <li class="nav-item"><a class="nav-link <?= $tab==='history'?'active':'' ?>" href="?tab=history">Povijest šetnji</a></li>
</ul>
<?php if($tab==='profile'): ?>
  <?php if($feedback): ?><div class="alert alert-success"><?= htmlspecialchars($feedback) ?></div><?php endif; ?>
  <?php if($errors): ?><div class="alert alert-danger"><ul><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
  <form method="post">
    <div class="mb-3"><label class="form-label">Korisničko ime</label><input type="text" name="username" class="form-control" value="<?= htmlspecialchars($u['username']) ?>" required></div>
    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($u['email']) ?>"></div>
    <div class="mb-3"><label class="form-label">Mobitel</label><input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($u['phone']) ?>"></div>
    <div class="mb-3"><label class="form-label">Nova lozinka</label><input type="password" name="password" class="form-control"></div>
    <button class="btn btn-primary">Spremi</button>
  </form>
<?php elseif($tab==='reservations'): ?>
  <?php if($my): ?>
  <table class="table table-bordered">
    <thead><tr><th>Pas</th><th>Datum</th><th>Termin</th><th>Trajanje</th><th>Lokacija</th></tr></thead>
    <tbody>
    <?php foreach($my as $r): ?>
      <tr><td><?= htmlspecialchars($r['name']) ?></td><td><?= htmlspecialchars($r['reserved_for']) ?></td><td><?= $r['time_slot']==='morning'?'Jutro':'Večer' ?></td><td><?= (int)$r['duration'] ?> min</td><td><?= htmlspecialchars($r['location']) ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?><p>Nema rezervacija.</p><?php endif; ?>
<?php else: ?>
  <?php if($history): ?>
  <table class="table table-bordered">
    <thead><tr><th>Pas</th><th>Datum</th><th>Termin</th><th>Trajanje</th><th>Lokacija</th><th>Recenzija</th></tr></thead>
    <tbody>
    <?php foreach($history as $r): ?>
      <tr><td><?= htmlspecialchars($r['name']) ?></td><td><?= htmlspecialchars($r['reserved_for']) ?></td><td><?= $r['time_slot']==='morning'?'Jutro':'Večer' ?></td><td><?= (int)$r['duration'] ?> min</td><td><?= htmlspecialchars($r['location']) ?></td><td><?php if(isset($reviewed[$r['id']])): ?>Hvala!<?php else: ?><a href="review.php?id=<?= $r['id'] ?>">Ostavi recenziju</a><?php endif; ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <p class="text-muted">Hvala što ste prošetali psa!</p>
  <?php else: ?><p>Nema povijesti šetnji.</p><?php endif; ?>
<?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
