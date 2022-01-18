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

    public function blockDamage(Weapon $weapon) {
        $reducedDamage = $weapon->getDamage() - $this->reduceGetDamage;
        return $reducedDamage > 0 ? $reducedDamage : 0;
    }
}