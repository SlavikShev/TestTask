<?php

namespace Tournament;

class Viking extends Hero implements IheroStartEquipment {

    public function __construct() {
        parent::__construct();
        $this->hitPoints = 120;
    }

    public function startEquipment() {
        $this->equip('axe');
    }
}