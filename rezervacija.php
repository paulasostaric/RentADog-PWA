<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rezervacija | ProšećiMe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
  <link rel="stylesheet" href="rezervacija.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php // Uključujemo navigaciju
include('elementi/nav.php')?>

<main class="container py-5">
  <h1 class="fw-bold text-center mb-4">Rezerviraj šetnju</h1>
  <div id="authNotice" class="alert alert-warning text-center d-none">Za rezervaciju se najprije <a href="prijava.php" class="alert-link">prijavi</a>.</div>
  <div id="bookingForm" class="d-none">
    <!-- Filters -->
    <div class="row g-3 mb-4">
      <div class="col-md-4"><select id="bSize" class="form-select"><option value="">Veličina</option><option value="mali">Mali</option><option value="srednji">Srednji</option><option value="veliki">Veliki</option></select></div>
      <div class="col-md-4"><select id="bAge" class="form-select"><option value="">Starost</option><option value="mlad">&lt;1 god</option><option value="odrasli">1–5 god</option><option value="stariji">&gt;5 god</option></select></div>
      <div class="col-md-4"><select id="bTemp" class="form-select"><option value="">Temperament</option><option value="mirna">Mirna</option><option value="energicna">Energicna</option></select></div>
    </div>
    <!-- Calendar -->
    <div class="table-responsive"><table class="table table-bordered text-center align-middle" id="calendarTable"><thead class="table-light"><tr><th>Pon</th><th>Uto</th><th>Sri</th><th>Čet</th><th>Pet</th><th>Sub</th><th>Ned</th></tr></thead><tbody></tbody></table></div>
    <div id="timeOptions" class="d-none mt-3">
      <p class="mb-2">Odabrani datum: <span id="selDate"></span></p>
      <button class="btn btn-outline-primary me-2" id="morningBtn">Jutarnja (9:00)</button>
      <button class="btn btn-outline-primary" id="eveningBtn">Večernja (18:00)</button>
    </div>
    <p class="mt-4">Lokacija preuzimanja psa: <strong>Sklonište Dumovec</strong></p>
  </div>
</main>

<?php // Zajednički footer
include('elementi/footer.php')?>

<script>
  const u=localStorage.getItem('username');if(u){document.getElementById('loginBtn').textContent=u;document.getElementById('bookingForm').classList.remove('d-none');}else{document.getElementById('authNotice').classList.remove('d-none');}
  // simple calendar
  function genCal(){
    const tbody=document.querySelector('#calendarTable tbody');
    tbody.innerHTML='';
    const d=new Date();
    const year=d.getFullYear(),month=d.getMonth();
    const first=new Date(year,month,1).getDay();
    const days=new Date(year,month+1,0).getDate();
    let date=1;
    for(let i=0;i<6;i++){
      const row=document.createElement('tr');
      for(let j=1;j<=7;j++){
        const cell=document.createElement('td');
        if(i===0&&j<(first||7)){
          cell.textContent='';
        }else if(date>days){
          cell.textContent='';
        }else{
          cell.textContent=date;
          if(Math.random()<0.2){
            cell.classList.add('busy');
          }else{
            cell.classList.add('free');
            cell.style.cursor='pointer';
            cell.addEventListener('click',e=>{
              if(e.target.classList.contains('busy'))return;
              document.querySelectorAll('.selected').forEach(c=>c.classList.remove('selected'));
              e.target.classList.add('selected');
              document.getElementById('selDate').textContent=`${e.target.textContent}.${month+1}.${year}`;
              document.getElementById('timeOptions').classList.remove('d-none');
            });
          }
          date++;
        }
        row.appendChild(cell);
      }
      tbody.appendChild(row);
    }
  }
  genCal();
</script>
</body>
</html>
