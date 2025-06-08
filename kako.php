<?php
// kako.php
// Informativna stranica koja objašnjava proces najma psa
session_start();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kako funkcionira | ProšećiMe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
  <link rel="stylesheet" href="kako.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include('elementi/nav.php')?>

<main class="container py-5 kako-main">
  <h1 class="fw-bold text-center mb-5">Kako funkcionira?</h1>
  <div class="row g-4 text-center mb-5">
    <div class="col-md-4"><div class="p-4 border rounded-4 h-100"><div class="display-5 mb-3">1</div><h5 class="fw-semibold mb-2">Rezerviraj termin</h5><p>Online kalendar ili telefonski poziv.</p></div></div>
    <div class="col-md-4"><div class="p-4 border rounded-4 h-100"><div class="display-5 mb-3">2</div><h5 class="fw-semibold mb-2">Upoznaj psa</h5><p>Na licu mjesta ti pomažemo odabrati pravog prijatelja.</p></div></div>
    <div class="col-md-4"><div class="p-4 border rounded-4 h-100"><div class="display-5 mb-3">3</div><h5 class="fw-semibold mb-2">Pokloni šetnju</h5><p>Šetnja, igra i povratak veselog psa.</p></div></div>
  </div>
  <p class="text-center bold mb-5">Nakon što rezervirate termin i dođete u Dumovec, naši volonteri će vam pokazati osnovne upute o psu kojeg vodite. Šetnja obično traje sat vremena, a po povratku psa možete nagraditi poslasticom i dogovoriti novi dolazak.</p>
  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <p>Program šetnji nastao je kako bismo psima pružili više druženja i lakšu prilagodbu na gradske uvjete. Volonteri vam uvijek stoje na raspolaganju za savjete o ponašanju i skrbi o psima.</p>
    </div>
    <div class="col-md-6 text-center">
      <img src="img/volonter1.jpg" class="img-fluid rounded-4" alt="Volonter sa psom">
    </div>
  </div>

  <h2 class="text-center fw-bold mb-4">Česta pitanja</h2>
  <div class="accordion" id="faqAcc">
    <div class="accordion-item"><h2 class="accordion-header" id="q1"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a1">Trebam li iskustvo sa psima?</button></h2><div id="a1" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Dovoljna je dobra volja. Tim će dati brze upute.</div></div></div>
    <div class="accordion-item"><h2 class="accordion-header" id="q2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">Jeli moguće unajmiti više od jednog psa u isto vrijeme?</button></h2><div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Naš program radi tako da psi dobivaju šetnju 1 na 1 sa šetačem zato nije moguće unajmiti više pasa odjednom.</div></div></div>
    <div class="accordion-item"><h2 class="accordion-header" id="q3"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3">Mogu li povesti djecu?</button></h2><div id="a3" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Djeca 10+ mogu sudjelovati uz odraslu osobu.</div></div></div>
    <div class="accordion-item"><h2 class="accordion-header" id="q4"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a4">Koliko traje šetnja?</button></h2><div id="a4" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Standardno 30‑120 minuta, po dogovoru.</div></div></div>
    <div class="accordion-item"><h2 class="accordion-header" id="q5"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a5">Smijem li povesti svog psa sa sobom?</button></h2><div id="a5" class="accordion-collapse collapse" data-bs-parent="#faqAcc"><div class="accordion-body">Neki od naših pasa se ne slažu dobro sa drugim psima pa Vaši psi nisu dozovljeni u šetnjama.</div></div></div>
  </div>
</main>

<?php include('elementi/footer.php')?>
</body>
</html>
