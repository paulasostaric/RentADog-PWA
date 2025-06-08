<?php
// index.php
// Početna stranica aplikacije – ovdje samo pokrećemo sesiju i učitavamo dijelove stranice
session_start();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ProšećiMe – Početna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
  <link rel="stylesheet" href="index.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <!-- NAVBAR -->
  <?php include('elementi/nav.php')?>

  <!-- HERO -->
  <?php include('elementi/naslov.php')?>

  

  <!-- FEATURED DOGS -->
  <section id="featured" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center fw-bold mb-2">Istaknuti psi</h2>
      <p class="text-center text-muted mb-4">Psi koji nisu šetani više od tjedan dana – povedi ih!</p>
      <div id="dogsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active text-center"><img src="img/Zetta.jpeg" class="d-block mx-auto rounded-4" style="max-height:300px" alt="Zetta"><div class="mt-3"><h5 class="fw-semibold mb-1">Zetta</h5><p class="small fst-italic mb-0">9 dana bez šetnje</p></div></div>
          <div class="carousel-item text-center"><img src="img/melly.jpeg" class="d-block mx-auto rounded-4" style="max-height:300px" alt="Melly"><div class="mt-3"><h5 class="fw-semibold mb-1">Melly</h5><p class="small fst-italic mb-0">11 dana bez šetnje</p></div></div>
          <div class="carousel-item text-center"><img src="img/sniper.jpeg" class="d-block mx-auto rounded-4" style="max-height:300px" alt="Sniper"><div class="mt-3"><h5 class="fw-semibold mb-1">Sniper</h5><p class="small fst-italic mb-0">8 dana bez šetnje</p></div></div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#dogsCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#dogsCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
      </div>
      <div class="text-center mt-4"><a href="psi.php" class="btn btn-outline-primary">Pogledaj sve pse</a></div>
    </div>
  </section>

  <!-- HOW -->
  <section id="kako" class="py-5">
    <div class="container">
      <h2 class="text-center fw-bold mb-5">Kako funkcionira?</h2>
      <div class="row g-4 text-center">
        <div class="col-md-4"><div class="p-4 border rounded-4 h-100"><div class="display-5 mb-3">1</div><h5 class="fw-semibold mb-2">Rezerviraj termin</h5><p>Odaberi dan i vrijeme online ili telefonom.</p></div></div>
        <div class="col-md-4"><div class="p-4 border rounded-4 h-100"><div class="display-5 mb-3">2</div><h5 class="fw-semibold mb-2">Upoznaj psa</h5><p>Pomažemo ti pronaći savršenog prijatelja.</p></div></div>
        <div class="col-md-4"><div class="p-4 border rounded-4 h-100"><div class="display-5 mb-3">3</div><h5 class="fw-semibold mb-2">Pokloni šetnju</h5><p>Prošeći, poigraj se i vrati veselog psa.</p></div></div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section id="iskustva" class="py-5">
    <div class="container"><h2 class="text-center fw-bold mb-5">Iskustva šetača</h2>
      <div class="row g-4">
        <div class="col-md-6"><div class="p-4 border rounded-4 h-100 shadow-sm"><p class="fst-italic mb-0">„Luna me razveselila u samo sat vremena – dolazim svaki tjedan!“</p><div class="d-flex align-items-center mt-3"><img src="img/marija.jpeg" class="rounded-circle me-2" width="48" height="48" alt="Marija"><div><h6 class="fw-semibold mb-0">Marija</h6><small class="text-muted">Google recenzija</small></div></div></div></div>
        <div class="col-md-6"><div class="p-4 border rounded-4 h-100 shadow-sm"><p class="fst-italic mb-0">„Savršeno iskustvo s Milom – preporučam svima.“</p><div class="d-flex align-items-center mt-3"><img src="img/ivan.jpeg" class="rounded-circle me-2" width="48" height="48" alt="Ivan"><div><h6 class="fw-semibold mb-0">Ivan</h6><small class="text-muted">Facebook recenzija</small></div></div></div></div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section id="rezervacija" class="py-5 text-center">
      <div class="container"><h2 class="fw-bold mb-4">Spreman/na pokloniti šetnju?</h2><p class="lead mb-4">Rezerviraj termin ili podrži nas donacijom – svaki korak znači veseli repić više.</p><div class="d-flex justify-content-center gap-3 flex-wrap"><a href="rezervacije.php" class="btn btn-primary btn-lg">Rezerviraj šetnju</a><a href="donacija.php" class="btn btn-outline-secondary btn-lg">Doniraj</a></div></div>
  </section>

  <!-- FOOTER -->
   <?php include('elementi/footer.php')?>

</body>


<style>
  /* Primjer: napravimo da strelice budu plave */
  #dogsCarousel .carousel-control-prev-icon,
  #dogsCarousel .carousel-control-next-icon {
    filter: invert(29%) sepia(96%) saturate(4899%) hue-rotate(200deg) brightness(98%) contrast(92%);
    /* gornji filter daje tamno-plavu boju; možeš ga prilagoditi pomoću alata poput https://codepen.io/sosuke/pen/Pjoqqp */
  }
</style>
</html>

