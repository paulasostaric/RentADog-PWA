# ProšećiMe

Ovaj projekt predstavlja jednostavnu web aplikaciju za rezervaciju šetnje pasa iz skloništa. U nastavku je kratak opis
svake važne stranice i njezine uloge.

## Pregled stranica

- **index.php** – početna stranica s osnovnim informacijama, istaknutim psima i poveznicama.
- **psi.php** – prikaz svih pasa uz filtriranje po veličini, starosti i temperamentu.
- **dog.php** – detaljni prikaz odabranog psa i forma za brzu rezervaciju šetnje.
- **rezervacije.php** – vodi korisnika kroz upitnik i omogućuje odabir termina.
- **registracija.php** – forma za otvaranje korisničkog računa.
- **prijava.php** – prijava korisnika i spremanje sesije.
- **account.php** – korisnički profil s pregledom i uređivanjem vlastitih podataka te rezervacija.
- **admin.php** – administratorski panel za upravljanje psima, korisnicima i rezervacijama.
- **user_account.php** – detalji i povijest šetnji pojedinog korisnika (admin prikaz).
- **dog_form.php** – unos ili izmjena podataka o psu (admin).
- **review.php** – unos recenzije nakon odrađene šetnje.
- **donacija.php** – osnovne informacije o načinima donacije.
- **kako.php** – objašnjava proces „najma“ psa korak po korak.
- **onama.php** – kratka priča o projektu i recenzije šetača.
- **kontakt.php** – radno vrijeme, obrazac i lokacija skloništa.


## Baza podataka

Parametri za spajanje na MySQL nalaze se u `config/config.php`. Tablice se koriste
za pohranu korisnika (`users`), pasa (`dogs`), rezervacija (`reservations`) i recenzija (`reviews`).

## Struktura

U mapi `elementi` nalaze se zajednički dijelovi stranica (navigacija, naslovni
baner i footer). Svi PHP fajlovi ih uključuju po potrebi.

