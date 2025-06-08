<?php
// elementi/nav.php
// Generira navigacijski izbornik i prikazuje korisničko ime ako je prijavljen

// Ako sesija još nije pokrenuta, pokrećemo je
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Trenutna PHP datoteka kako bismo označili aktivnu stavku izbornika
$current = basename($_SERVER['PHP_SELF']);
// Korisnik iz sesije (ako je prijavljen)
$user    = $_SESSION['username'] ?? null;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
      <img src="img/paw.svg" alt="" width="24" class="me-1">
      ProšećiMe
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php
          // Popis osnovnih linkova u navigaciji
          $links = [
            'index.php'       => 'Početna',
            'psi.php'         => 'Naši psi',
            'kako.php'        => 'Kako funkcionira?',
            'rezervacije.php' => 'Rezervacije',
            'onama.php'       => 'O nama',
            'kontakt.php'     => 'Kontakt'
          ];
          // Generiramo <li> elemente i označavamo onaj čija je datoteka trenutno aktivna
          foreach ($links as $file => $title) {
            $active = ($current === $file) ? 'active' : '';
            echo "<li class='nav-item'><a class='nav-link $active' href='$file'>$title</a></li>";
          }
        ?>

        <?php if ($user): ?>
          <!-- Ako je korisnik prijavljen prikazujemo izbornik s odjavom i poveznicama -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= htmlspecialchars($user) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="logout.php">Odjava</a></li>
              <?php $role = $_SESSION['role'] ?? ''; if ($role === 'admin'): ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="admin.php">Admin panel</a></li>
              <?php else: ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="account.php">Vaš račun</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link <?= ($current==='prijava.php'?'active':'') ?>" href="prijava.php">Prijava</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

