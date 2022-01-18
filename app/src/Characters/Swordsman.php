<?php

namespace Tournament;

class Swordsman extends Hero {

    public function __construct() {
        parent::__construct();
        $this->hitPoints = 100;

    }

    public function startEquipment() {
        $this->equip('sword');
    }
}
