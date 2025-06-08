<?php
// rezervacije.php
// Kompleksnija stranica za odabir psa i rezervaciju termina

session_start();
require_once __DIR__ . '/config/config.php';

$dog = null;
$reservations = [];
$reserved = [];
$available_dogs = [];
$duration = 60;
$location = '';
$feedback = '';

// Provjerava odgovara li pas traženom trajanju i lokaciji
function dog_matches($dog,$duration,$location){
    $durs=array_map('intval',array_map('trim',explode(',',$dog['durations'])));
    $locs=array_map('mb_strtolower',array_map('trim',explode(',',$dog['locations'])));
    return in_array((int)$duration,$durs,true) && in_array(mb_strtolower($location),$locs,true);
}

// Dohvaća psa i njegove postojeće rezervacije
function load_dog_and_reservations($dog_id, &$reservations, &$reserved, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM dogs WHERE id=?");
    $stmt->execute([$dog_id]);
    $dog = $stmt->fetch();
    if(!$dog) return null;
    $stmt = $pdo->prepare("SELECT id, reserved_for, time_slot, reserved_by_user FROM reservations WHERE dog_id=? ORDER BY reserved_for, time_slot");
    $stmt->execute([$dog_id]);
    $reservations = $stmt->fetchAll();
    $reserved = [];
    foreach($reservations as $r){
        $reserved[$r['reserved_for']][$r['time_slot']] = ['id'=>$r['id'],'user'=>$r['reserved_by_user']];
    }
    return $dog;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
// Upitnik za pronalazak psa prema energiji
    if(isset($_POST['energy'])) {
        $energy = $_POST['energy'];
        $duration = (int)($_POST['duration'] ?? 60);
        $location = $_POST['location'] ?? '';
        if($energy === 'miran') {
            $stmt = $pdo->query("SELECT * FROM dogs WHERE temperament LIKE 'Miran%' OR temperament LIKE 'Mirna%'");
        } else {
            $stmt = $pdo->query("SELECT * FROM dogs WHERE temperament LIKE 'Energi%'");
        }
        $dogs = array_filter($stmt->fetchAll(), fn($d)=>dog_matches($d,$duration,$location));
        if($dogs) {
            if(count($dogs) === 1) {
                $d = $dogs[0];
                $dog = load_dog_and_reservations($d['id'], $reservations, $reserved, $pdo);
            } else {
                $available_dogs = $dogs;
            }
        }
    // Rezervacija konkretnog termina
    } elseif(isset($_POST['reserve_slot'], $_POST['dog_id'])) {
        $dog_id = (int)$_POST['dog_id'];
        $duration = (int)($_POST['duration'] ?? 60);
        $location = $_POST['location'] ?? '';
        $dog = load_dog_and_reservations($dog_id, $reservations, $reserved, $pdo);
        if($dog && dog_matches($dog,$duration,$location)) {
            list($date,$slot) = explode('|', $_POST['reserve_slot']);
            if (!isset($reserved[$date][$slot]) && isset($_SESSION['user_id'])) {
                $pdo->prepare("INSERT INTO reservations(dog_id,reserved_for,time_slot,duration,location,reserved_by_user) VALUES(?,?,?,?,?,?)")
                    ->execute([$dog_id,$date,$slot,$duration,$location,$_SESSION['user_id']]);
                $feedback = "Rezervirano za $date ($slot).";
                $dog = load_dog_and_reservations($dog_id, $reservations, $reserved, $pdo);
            } else {
                $feedback = isset($reserved[$date][$slot]) ? 'Termin je već rezerviran.' : 'Prijavite se za rezervaciju.';
            }
        } else {
            $dog = null;
            $feedback = 'Odabrano trajanje ili lokacija nisu dostupni za ovog psa.';
        }
    // Odabir psa bez rezervacije termina
    } elseif(isset($_POST['dog_id'])) {
        $dog_id = (int)$_POST['dog_id'];
        $duration = (int)($_POST['duration'] ?? $duration);
        $location = $_POST['location'] ?? $location;
        $dog = load_dog_and_reservations($dog_id, $reservations, $reserved, $pdo);
        if($dog && !dog_matches($dog,$duration,$location)){
            $feedback = 'Odabrano trajanje ili lokacija nisu dostupni za ovog psa.';
            $dog = null;
            $available_dogs = [];
        }
    }
}

function renderCalendar($year, $month, $reserved) {
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $firstWeekday = (int)date('w', strtotime("$year-$month-01"));
    $html = '<table class="table table-bordered text-center align-middle" id="calendarTable">';
    $html .= '<thead class="table-light"><tr>';
    foreach(['Ned','Pon','Uto','Sri','Čet','Pet','Sub'] as $wd){$html .= "<th>$wd</th>";}
    $html .= '</tr></thead><tbody><tr>';
    for($i=0;$i<$firstWeekday;$i++){$html .= '<td></td>';}
    for($day=1;$day<=$days;$day++) {
        $date = sprintf('%04d-%02d-%02d',$year,$month,$day);
        $morningFree = isset($reserved[$date]['morning']) ? 0 : 1;
        $eveningFree = isset($reserved[$date]['evening']) ? 0 : 1;
        $class = 'calendar-day';
        if(!$morningFree && !$eveningFree){ $class .= ' table-danger'; }
        $html .= "<td class='$class' data-date='$date' data-morning='$morningFree' data-evening='$eveningFree'>$day</td>";
        if (date('w', strtotime($date)) == 6 && $day != $days) {$html .= '</tr><tr>';}
    }
    $lastWeekday = (int)date('w', strtotime("$year-$month-$days"));
    if ($lastWeekday < 6) { for($i=$lastWeekday+1;$i<=6;$i++){$html .= '<td></td>';}}
    $html .= '</tr></tbody></table>';
    return $html;
}
$year = date('Y');
$month = date('n');
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rezervacije | ProšećiMe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="img/paw.svg" type="image/svg+xml">
  <style>
    #calendarTable td {cursor:pointer;}
    #calendarTable td.table-danger {cursor:not-allowed;}
  </style>
</head>
<body>
<?php // Navigacija
include __DIR__ . '/elementi/nav.php'; ?>
<main class="container py-5">
  <h1 class="fw-bold text-center mb-4">Rezervacije</h1>
<?php if(!$dog && empty($available_dogs)): ?>
  <form method="post" class="mb-4">
    <div class="mb-3">
      <label class="form-label">Koliko želite da traje šetnja?</label>
      <select name="duration" class="form-select">
        <option value="30">30 min</option>
        <option value="60">1 sat</option>
        <option value="90">1.5 sata</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Gdje planirate ići?</label>
      <select name="location" class="form-select">
        <option value="park">Park</option>
        <option value="suma">Šuma</option>
        <option value="grad">Grad</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Željena energija psa</label>
      <select name="energy" class="form-select">
        <option value="miran">Mirniji pas</option>
        <option value="energetic">Energican pas</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Pronađi psa</button>
  </form>
<?php elseif(!empty($available_dogs)): ?>
  <h2 class="mb-3">Odaberite psa</h2>
  <div class="row">
  <?php foreach($available_dogs as $d): ?>
    <div class="col-md-4 text-center mb-3">
      <img src="img/<?=htmlspecialchars($d['image'])?>" class="img-fluid mb-2" style="max-height:150px" alt="<?=htmlspecialchars($d['name'])?>">
      <p class="fw-semibold mb-1"><?=htmlspecialchars($d['name'])?></p>
      <form method="post">
        <input type="hidden" name="dog_id" value="<?=$d['id']?>">
        <input type="hidden" name="duration" value="<?=$duration?>">
        <input type="hidden" name="location" value="<?=htmlspecialchars($location)?>">
        <button class="btn btn-primary" type="submit">Odaberi</button>
      </form>
    </div>
  <?php endforeach; ?>
  </div>
<?php else: ?>
  <h2 class="mb-3">Preporučeni pas: <?=htmlspecialchars($dog['name'])?></h2>
  <p><strong>Pasmina:</strong> <?=htmlspecialchars($dog['breed'])?>,<br>
     <strong>Temperament:</strong> <?=htmlspecialchars($dog['temperament'])?></p>
  <img src="img/<?=htmlspecialchars($dog['image'])?>" class="img-fluid mb-4" style="max-width:300px" alt="<?=htmlspecialchars($dog['name'])?>">
  <?php if ($feedback): ?>
    <div class="alert alert-info"><?=htmlspecialchars($feedback)?></div>
  <?php endif; ?>
  <form method="post" id="resForm">
    <input type="hidden" name="dog_id" value="<?=$dog['id']?>">
    <input type="hidden" name="duration" value="<?=$duration?>">
    <input type="hidden" name="location" value="<?=htmlspecialchars($location)?>">
    <?= renderCalendar($year,$month,$reserved) ?>
    <div id="timeOptions" class="d-none mt-3">
      <p class="mb-2">Odabrani datum: <span id="selDate"></span></p>
      <button class="btn btn-outline-primary me-2" id="morningBtn" name="reserve_slot" value="" type="submit">Jutarnja (9:00)</button>
      <button class="btn btn-outline-primary" id="eveningBtn" name="reserve_slot" value="" type="submit">Večernja (18:00)</button>
    </div>
  </form>
  <?php if (empty($_SESSION['user_id'])): ?>
    <p class="text-warning mt-3">Za rezervaciju se <a href="prijava.php">prijavite</a>.</p>
  <?php endif; ?>
<?php endif; ?>
</main>
<?php // Footer stranice
include __DIR__ . '/elementi/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('#calendarTable td[data-date]').forEach(td=>{
  const mBtn=document.getElementById('morningBtn');
  const eBtn=document.getElementById('eveningBtn');
  const sel=document.getElementById('selDate');
  const opt=document.getElementById('timeOptions');
  if(td.dataset.morning==='1' || td.dataset.evening==='1'){
    td.addEventListener('click',()=>{
      document.querySelectorAll('#calendarTable .table-primary').forEach(c=>c.classList.remove('table-primary'));
      td.classList.add('table-primary');
      const d=td.dataset.date.split('-').reverse().join('.');
      sel.textContent=d;
      mBtn.disabled = td.dataset.morning!=='1';
      eBtn.disabled = td.dataset.evening!=='1';
      mBtn.value=td.dataset.date+'|morning';
      eBtn.value=td.dataset.date+'|evening';
      opt.classList.remove('d-none');
    });
  } else {
    td.classList.add('table-danger');
  }
});
</script>
</body>
</html>
