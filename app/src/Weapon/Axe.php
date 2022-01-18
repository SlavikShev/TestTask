<?php

namespace Tournament;

class Axe extends Weapon
{
    public function __construct() {
        $this->dmg = 6;
    }

    public function makeDamage() {
        return $this->dmg;
    }

    public function getDamage () {
        return $this->dmg;
    }
}