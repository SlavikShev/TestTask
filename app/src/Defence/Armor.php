<?php

namespace Tournament;

class Armor extends Defence
{
    public $reduceDmg;
    public $reduceGetDamage;

    public function __construct() {
        $this->reduceDmg = 1;
        $this->reduceGetDamage = 3;
    }

    public function blockDamage(Weapon $weapon, $reducedDamage = false) {
        $reducedDamage = $reducedDamage !== false ? $weapon->getDamage() - $reducedDamage : 0;
        $resultDamage = $weapon->getDamage() - $this->reduceGetDamage - $reducedDamage;
        return $resultDamage > 0 ? $resultDamage : 0;
    }
}