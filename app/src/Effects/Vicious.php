<?php

namespace Tournament;

class Vicious extends Hero {

    public $additionalDamage = 20;
    public $duration = 2;

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
            foreach ($hero->equipment['Weapon'] as $weapon) {
                $damage = $weapon->strike();
                $blockResult = $this->processingBlockDamage($enemy, $weapon);

                $enemy->hitPoints -= (isset($blockResult) && $blockResult !== false ? $blockResult : $damage) - $hero->reduceDmg;
            }
            if ($effectResult)
                $enemy->hitPoints -= $this->additionalDamage;
        }
    }
}