<?php

namespace Tournament;

class Vicious extends Hero {

    public $additionalDamage = 20;
    public $duration = 2;

    public function __construct() {
        parent::__construct();
    }

    public function startEquipment() {
        // TODO: Implement startEquipment() method.
    }

    public function useEffect () {
        if ($this->duration > 0) {
            $this->duration--;
            return true;
        }
        return false;
    }

    public function damageEnemy (Hero $enemy, Hero $hero = null) {
        $effectResult = $this->useEffect();

        if ($hero->hitPoints > 0) {
            // перебираем все чем мы можем нанести урон
            foreach ($hero->equipment['Weapon'] as $weapon) {
                $damage = $weapon->makeDamage();
                // перебираем все чем противник может уменьшить урон
                if (isset($enemy->equipment['Defence'])) {
                    foreach ($enemy->equipment['Defence'] as $key => $defence) {
                        $blockResult = $defence->blockDamage($weapon);
                        if ($blockResult === true) // противник пытается блокировать урон от нас
                            return;
                        if ($blockResult === -1) {
                            unset($enemy->equipment['Defence'][$key]);
                            $hero->takeOffEquipment($defence);
                        }
                    }
                }
                // изменять здоровье через функцию, а не напрямую
                $enemy->hitPoints -= (!empty($blockResult) ? $blockResult : $damage) - $hero->reduceDmg;
            }
            if ($effectResult)
                $enemy->hitPoints -= $this->additionalDamage;
        }
    }
}