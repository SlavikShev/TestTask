<?php

namespace Tournament;

class Veteran extends Hero {

    public $multipleDamage = 2;
    public $healthLimitPercents = 30;
    public $startHitPoints;
    public $limit;

    public function __construct($startHitPoints) {
        $this->startHitPoints = $startHitPoints;
        $this->limit = $this->startHitPoints * $this->healthLimitPercents / 100;
    }

    public function useEffect (Hero $hero) {
        return $hero->hitPoints() < $this->limit;
    }

    public function damageEnemy (Hero $enemy, Hero $hero = null) {
        $effectResult = $this->useEffect($hero);

        if ($hero->hitPoints > 0) {
            foreach ($hero->equipment['Weapon'] as $weapon) {
                $damage = $weapon->strike();

                $blockResult = $this->processingBlockDamage($enemy, $weapon);

                $finalDamage = (isset($blockResult) && $blockResult !== false ? $blockResult : $damage) - $hero->reduceDmg;
                $enemy->hitPoints -= $finalDamage;
            }
            if ($effectResult && $finalDamage != 0)
                $enemy->hitPoints -= $this->multipleDamage * $damage - $damage ;
        }
    }
}