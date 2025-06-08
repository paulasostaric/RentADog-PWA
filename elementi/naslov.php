<section id="hero" class="text-center text-white position-relative">
  <!-- Tamni overlay -->
  <div class="bg-dark bg-opacity-50 position-absolute top-0 start-0 w-100 h-100"></div>

  <!-- Ovaj container sada ima 100% visine roditelja (#hero) -->
  <div class="container d-flex flex-column justify-content-center align-items-center h-100 position-relative">
    <h1 class="display-4 fw-bold mb-3">Pokloni sklonišnom psu dan za pamćenje</h1>
    <p class="lead mb-4">Dođi u naše sklonište, povedi psa u šetnju i ispuni mu srce radošću.</p>
    <a href="rezervacije.php" class="btn btn-primary btn-lg">Rezerviraj sada</a>
  </div>
</section>

<style>
  /* Postavimo hero na fiksnu visinu od 80 viewport visine (vh) */
  #hero {
    position: relative;
    height: 80vh;                            /* CORRECTION: umjesto min-height koristimo height */
    background: url('img/pozadina1.jpg') center/cover no-repeat;
  }

  /* Tamni overlay preko cijelog hero */
  #hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.45);
    z-index: 1;
  }

  /* Sve unutar hero (container, h1, p, gumb) mora imati veći z-index od overlaya */
  #hero .container,
  #hero h1,
  #hero p,
  #hero .btn {
    position: relative;
    z-index: 2;
    color: #fff;
  }

  /* Container sada popunjava 100% visine #hero, tako da flex centriranje radi vertikalno */
  #hero .container {
    height: 100%;
  }

  /* Adaptacija fonta na manjim ekranima (opcionalno) */
  @media (max-width: 575.98px) {
    #hero h1 {
      font-size: 1.75rem;
    }
    #hero p.lead {
      font-size: 1rem;
    }
  }
</style>
