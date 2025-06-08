<?php
// admin.php
// Administratorski panel za upravljanje psima, korisnicima i rezervacijama

session_start();
require_once __DIR__ . '/config/config.php';
// Pristup dozvoljen samo administratoru
if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit;
}
$tab = $_GET['tab'] ?? 'dogs';

// Obrada akcija iz obrazaca (brisanje/označavanje)
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if(isset($_POST['delete_dog'])){
        $stmt = $pdo->prepare('DELETE FROM dogs WHERE id=?');
        $stmt->execute([(int)$_POST['delete_dog']]);
    } elseif(isset($_POST['delete_user'])){
        $stmt = $pdo->prepare('DELETE FROM users WHERE id=?');
        $stmt->execute([(int)$_POST['delete_user']]);
    } elseif(isset($_POST['delete_res'])){
        $stmt = $pdo->prepare('DELETE FROM reservations WHERE id=?');
        $stmt->execute([(int)$_POST['delete_res']]);
    } elseif(isset($_POST['complete_res'])){
        $stmt = $pdo->prepare('UPDATE reservations SET completed=1 WHERE id=?');
        $stmt->execute([(int)$_POST['complete_res']]);
    }
}

// Dohvat podataka za tablice
$dogs = $pdo->query('SELECT * FROM dogs')->fetchAll();
$users = $pdo->query("SELECT id, username FROM users WHERE role='user'")->fetchAll();
$reservations = $pdo->query('SELECT r.id,d.name,u.username,r.reserved_for,r.time_slot,r.duration,r.location,r.completed FROM reservations r JOIN dogs d ON r.dog_id=d.id LEFT JOIN users u ON r.reserved_by_user=u.id ORDER BY r.reserved_for DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
</head>
<body>
<?php include __DIR__.'/elementi/nav.php'; ?>
<div class="container py-5">
<h1 class="mb-4">Admin panel</h1>
<ul class="nav nav-tabs mb-4">
  <li class="nav-item"><a class="nav-link <?= $tab==='dogs'?'active':'' ?>" href="?tab=dogs">Psi</a></li>
  <li class="nav-item"><a class="nav-link <?= $tab==='users'?'active':'' ?>" href="?tab=users">Korisnici</a></li>
  <li class="nav-item"><a class="nav-link <?= $tab==='reservations'?'active':'' ?>" href="?tab=reservations">Rezervacije</a></li>
</ul>
<?php if($tab==='dogs'): ?>
  <h2>Upravljanje psima</h2>
  <p><a href="dog_form.php" class="btn btn-sm btn-success">Dodaj psa</a></p>
  <table class="table table-bordered">
  <thead><tr><th>ID</th><th>Ime</th><th>Pasmina</th><th>Veličina</th><th>Akcije</th></tr></thead>
  <tbody>
  <?php foreach($dogs as $d): ?>
    <tr>
      <td><?= $d['id'] ?></td>
      <td><?= htmlspecialchars($d['name']) ?></td>
      <td><?= htmlspecialchars($d['breed']) ?></td>
      <td><?= htmlspecialchars($d['size']) ?></td>
      <td>
        <a href="dog_form.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-secondary">Uredi</a>
        <form method="post" class="d-inline">
          <button name="delete_dog" value="<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Brisanje?')">Obriši</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody></table>
<?php elseif($tab==='users'): ?>
  <h2>Korisnici</h2>
  <table class="table table-bordered">
  <thead><tr><th>ID</th><th>Korisničko ime</th><th>Pregled</th><th></th></tr></thead>
  <tbody>
  <?php foreach($users as $u): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td><a class="btn btn-sm btn-secondary" href="user_account.php?id=<?= $u['id'] ?>">Pregled</a></td>
      <td>
        <form method="post" class="d-inline">
          <button name="delete_user" value="<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Brisanje?')">Obriši</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody></table>
<?php else: ?>
  <h2>Rezervacije</h2>
  <table class="table table-bordered">
  <thead><tr><th>ID</th><th>Pas</th><th>Korisnik</th><th>Datum</th><th>Termin</th><th>Trajanje</th><th>Lokacija</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach($reservations as $r): ?>
    <tr>
      <td><?= $r['id'] ?></td>
      <td><?= htmlspecialchars($r['name']) ?></td>
      <td><?= htmlspecialchars($r['username'] ?? '') ?></td>
      <td><?= htmlspecialchars($r['reserved_for']) ?></td>
      <td><?= $r['time_slot']==='morning'?'Jutro':'Večer' ?></td>
      <td><?= (int)$r['duration'] ?> min</td>
      <td><?= htmlspecialchars($r['location']) ?></td>
      <td><?= $r['completed']? 'Odrađeno':'Čeka' ?></td>
      <td>
        <form method="post" class="d-inline">
          <?php if(!$r['completed']): ?>
          <button name="complete_res" value="<?= $r['id'] ?>" class="btn btn-sm btn-success">Označi odrađeno</button>
          <?php endif; ?>
          <button name="delete_res" value="<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Brisanje?')">Obriši</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody></table>
<?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
