<?php

namespace Tournament;

class GreatSword extends Weapon
{
    public $hitsToRecharge = 2;
    private $calmDown = 2;

    public function __construct() {
        $this->dmg = 12;
    }

    public function strike() {
        if ($this->hitsToRecharge > 0) {
            $this->hitsToRecharge--;
            return $this->dmg;
        } else {
            $this->hitsToRecharge = $this->calmDown;
            return 0;
        }
    }

    public function getDamage () {
        return $this->hitsToRecharge != $this->calmDown ? $this->dmg : 0;
    }
}