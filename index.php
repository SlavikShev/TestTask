<?php

namespace Tournament;

require_once __DIR__ . '/vendor/autoload.php';

$swordsman = (new Swordsman())->equip("buckler");
$viking = (new Viking())->equip("buckler");

$swordsman->engage($viking);

//$highlander = new Highlander();
//$swordsman = (new Swordsman())
//    ->equip("buckler")
//    ->equip("armor");
//
//$swordsman->engage($highlander);

echo "<pre>";
var_dump($viking, $swordsman);
echo "</pre>";