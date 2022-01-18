<?php

namespace Tournament;

class Highlander extends Hero {

    public $effects;

    public function __construct($effect = null) {
        parent::__construct();
        $this->hitPoints = 150;
        if ($effect !== null) {
            $namespace = 'Tournament\\';
            $effectName = $namespace . ucfirst($effect);
            $this->effects = new $effectName($this->hitPoints);
        }
    }

    public function startEquipment() {
        $this->equip('GreatSword');
    }

    public function damageEnemy (Hero $enemy, Hero $hero = null) {
        // проверить содержит ли класс еффекта такой метод
        if ($this->effects)
            $this->effects->damageEnemy($enemy, $this);
        else
            parent::damageEnemy($enemy);
    }
}