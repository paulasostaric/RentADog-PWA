<?php
// logout.php
// Odjavljuje korisnika brisanjem svih podataka iz sesije

session_start();            // pokrećemo sesiju ako već nije pokrenuta
session_unset();            // brišemo sve varijable spremljene u sesiji
session_destroy();          // potpuno uništavamo sesiju

// Nakon odjave vraćamo korisnika na početnu stranicu
header('Location: index.php');
exit;
