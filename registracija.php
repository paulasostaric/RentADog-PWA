<?php
// registracija.php
// Obrada registracije novog korisnika

session_start();
require_once __DIR__ . '/config/config.php';

$errors   = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dohvati podatke iz forme
    $username  = trim($_POST['username']  ?? '');
    $email     = trim($_POST['email']     ?? '');
    $phone     = trim($_POST['phone']     ?? '');
    $password  = $_POST['password']  ?? '';
    $password2 = $_POST['password2'] ?? '';

    // 1) Osnovna validacija unesenih podataka
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Korisničko ime mora imati barem 3 znaka.";
    }
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Lozinka mora imati barem 6 znakova.";
    }
    if ($password !== $password2) {
        $errors[] = "Lozinke se ne podudaraju.";
    }

    // 2) Provjeri postoji li već korisnik s tim imenom u bazi
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = "Korisničko ime već postoji. Izaberite drugo.";
        }
    }

    // 3) Ako nema grešaka, ubaci novog korisnika u bazu
    if (empty($errors)) {
        $pw_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql     = "INSERT INTO users (username,email,phone,password_hash) VALUES (?,?,?,?)";
        $upit    = $pdo->prepare($sql);
        $upit->execute([$username,$email,$phone,$pw_hash]);

        // Pohrani u sesiju i preusmjeri na početnu
        $_SESSION['username'] = $username;
        $_SESSION['user_id']  = $pdo->lastInsertId();
        $_SESSION['role']     = 'user';
        $_SESSION['is_admin'] = 0;

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registracija | ProšećiMe</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">

  <!-- Inline CSS -->
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    main {
      flex: 1 0 auto;
      padding: 3rem 0;
    }
    #username, #password, #password2 {
      height: 48px;
    }
    .form-label {
      font-weight: 600;
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <?php include __DIR__ . '/elementi/nav.php'; ?>

  <main class="container" style="max-width: 440px;">
    <h1 class="fw-bold text-center mb-4">Registracija</h1>

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
        <input type="text"
               id="username"
               name="username"
               class="form-control"
               value="<?= htmlspecialchars($username) ?>"
               required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Mobitel</label>
        <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($phone ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Lozinka</label>
        <input type="password"
               id="password"
               name="password"
               class="form-control"
               required>
      </div>
      <div class="mb-3">
        <label for="password2" class="form-label">Ponovi lozinku</label>
        <input type="password"
               id="password2"
               name="password2"
               class="form-control"
               required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Registriraj se</button>
      </div>
      <p class="text-center mt-3 small">
        Već imaš račun? <a href="prijava.php">Prijavi se</a>
      </p>
    </form>
  </main>

  <!-- FOOTER -->
  <?php include __DIR__ . '/elementi/footer.php'; ?>

  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>