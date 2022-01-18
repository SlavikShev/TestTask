<?php

namespace Tournament;

require_once __DIR__ . '/vendor/autoload.php';

//$highlander = new Highlander();
//$swordsman = (new Swordsman())
//    ->equip("buckler")
//    ->equip("armor");
//
//$swordsman->engage($highlander);

$swordsman = (new Swordsman("Vicious"))
    ->equip("axe")
    ->equip("buckler")
    ->equip("armor");

$highlander = new Highlander("Veteran");

$swordsman->engage($highlander);

echo "<pre>";
var_dump($highlander, $swordsman);
echo "</pre>";