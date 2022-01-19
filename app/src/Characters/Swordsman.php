<?php

namespace Tournament;

class Swordsman extends Hero implements IheroStartEquipment {

    public $effects;

    public function __construct($effect = null) {
        parent::__construct();
        $this->hitPoints = 100;
        if ($effect !== null) {
            $namespace = 'Tournament\\';
            $effectName = $namespace . ucfirst($effect);
            $this->effects = new $effectName;
        }

    }

    public function startEquipment() {
        $this->equip('sword');
    }

    public function damageEnemy (Hero $enemy, Hero $hero = null) {
        if (!empty($this->effects)) {
            $this->effects->damageEnemy($enemy, $this);
        } else {
            parent::damageEnemy($enemy);
        }
    }
}
