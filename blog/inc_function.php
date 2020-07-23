<?php

// prevoir d'autres fonctions pour proteger ses entrees et sorties ...

function protect_montexte($montexte)
{
    $montexte = trim($montexte);
    $montexte = stripslashes($montexte);
    $montexte = htmlspecialchars($montexte);
    return $montexte;
}
