<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>O nama | ProšećiMe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
  <link rel="stylesheet" href="onama.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
 <?php // Uključujemo zajednički navigacijski izbornik
 include('elementi/nav.php')?>


<main class="container py-5 about-us">
  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <h1 class="fw-bold mb-4">Naša priča</h1>
      <p id="tekst">Projekt ProšećiMe pokrenut je 2024. kako bismo sklonišnim psima pružili više šetnji i brže udomljenje.</p>
      <p id="tekst">Tijekom godina okupili smo stotine volontera i organizirali tisuće šetnji koje pse pripremaju za novo obiteljsko okruženje.</p>
      <p id="tekst">Svaki novi šetač pomaže u socijalizaciji pasa i povećava im šanse za pronalaskom trajnog doma.</p>
    </div>
    <div class="col-md-6 text-md-end text-center">
      <div class="ratio ratio-16x9 video-container">
       <iframe width="560" height="315" src="https://www.youtube.com/embed/qfSmo2DqJbU?si=_VMdPlna-PSz6GYp" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      </div>
    </div>
  </div>
  <h2 class="text-center fw-bold mb-4">Recenzije šetača</h2>
  <div class="row g-4">
    <div class="col-md-4"><div class="card h-100 shadow-sm p-3"><p class="fst-italic mb-2">„Subotnja šetnja s Askom mi je uljepšala tjedan!“</p><h6 class="fw-semibold mb-0">Ana</h6><small class="text-muted">Google</small></div></div>
    <div class="col-md-4"><div class="card h-100 shadow-sm p-3"><p class="fst-italic mb-2">„Odlično organizirano, psi presretni.“</p><h6 class="fw-semibold mb-0">Marko</h6><small class="text-muted">Facebook</small></div></div>
    <div class="col-md-4"><div class="card h-100 shadow-sm p-3"><p class="fst-italic mb-2">„Najbolji način za provesti aktivno popodne.“</p><h6 class="fw-semibold mb-0">Sara</h6><small class="text-muted">Instagram</small></div></div>
  </div>
</main>

 <?php // Zajednički footer sa skriptom
 include('elementi/footer.php')?>

<script>const u=localStorage.getItem('username');if(u){document.getElementById('loginBtn').textContent=u;}</script>
</body>
</html>
