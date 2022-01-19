<?php

namespace Tournament;

class Sword extends Weapon
{
    public function __construct() {
        $this->dmg = 5;
    }

    public function strike() {
        return $this->dmg;
    }

    public function getDamage () {
        return $this->dmg;
    }
}