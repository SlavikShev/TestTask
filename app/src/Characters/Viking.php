<?php

namespace Tournament;

class Viking extends Hero {

    public function __construct() {
        $this->startEquipment();
        $this->hitPoints = 120;
    }

    public function startEquipment() {
        $this->equip('axe');
    }
}