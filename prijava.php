<?php
// prijava.php
// Skripta za prijavu korisnika

session_start();
require_once __DIR__ . '/config/config.php';

// U razvojnoj okolini uključujemo prikaz grešaka
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ako je korisnik već prijavljen, preusmjeri ga na početnu
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$errors   = [];
$username = '';

// Obrada POST zahtjeva
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']  ?? '');
    $password =        $_POST['password'] ?? '';

    // Validacija polja
    if ($username === '' || $password === '') {
        $errors[] = 'Oba polja su obavezna.';
    } else {
        // Dohvati korisnika iz baze (samo id, lozinku i is_admin)
        $stmt = $pdo->prepare("
            SELECT id, password_hash, is_admin
            FROM users
            WHERE username = ?
            LIMIT 1
        ");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Provjera lozinke i postavljanje sesijskih varijabli
        if ($user && password_verify($password, $user['password_hash'])) {
            // Spremi podatke u sesiju
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $username;
            $_SESSION['is_admin']  = (bool)$user['is_admin'];
            $_SESSION['role']      = $user['is_admin'] ? 'admin' : 'user';

            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Neispravno korisničko ime ili lozinka.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Prijava | Rent a Dog</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">

  <!-- Eventualni custom CSS -->
  <link rel="stylesheet" href="css/prijava.css">
</head>
<body>

  <!-- Navigacija -->
  <?php include __DIR__ . '/elementi/nav.php'; ?>

  <main class="container" style="max-width: 400px; padding-top: 3rem;">
    <h1 class="fw-bold text-center mb-4">Prijava</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" novalidate>
      <div class="mb-3">
        <label for="username" class="form-label">Korisničko ime</label>
        <input
          type="text"
          id="username"
          name="username"
          class="form-control"
          value="<?= htmlspecialchars($username) ?>"
          required
        >
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Lozinka</label>
        <input
          type="password"
          id="password"
          name="password"
          class="form-control"
          required
        >
      </div>
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Prijavi se</button>
      </div>
      <p class="text-center small">
        Nemaš račun? <a href="registracija.php">Registriraj se</a>
      </p>
    </form>
  </main>

  <!-- Footer -->
  <?php include __DIR__ . '/elementi/footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
