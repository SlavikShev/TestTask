<?php

namespace Tournament;

class Highlander extends Hero {

    public function __construct() {
        parent::__construct();
        $this->hitPoints = 150;
    }

    public function startEquipment() {
        $this->equip('GreatSword');
    }
}