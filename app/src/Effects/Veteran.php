<?php

namespace Tournament;

class Veteran extends Hero {

    public $multipleDamage = 2;
    public $healthLimitPercents = 30;
    public $startHitPoints;
    public $limit;

    public function __construct($startHitPoints) {
        parent::__construct();
        $this->startHitPoints = $startHitPoints;
        $this->limit = $this->startHitPoints * $this->healthLimitPercents / 100;
    }

    public function startEquipment() {
        // TODO: Implement startEquipment() method.
    }

    public function useEffect (Hero $hero) {
        return $hero->hitPoints() < $this->limit;
    }

    public function damageEnemy (Hero $enemy, Hero $hero = null) {
        $effectResult = $this->useEffect($hero);

        if ($hero->hitPoints > 0) {
            foreach ($hero->equipment['Weapon'] as $weapon) {
                $damage = $weapon->strike();

                if (!empty($enemy->equipment['Defence'])) {
                    $blockResult = 0;
                    foreach ($enemy->equipment['Defence'] as $key => $defence) {
                        $blockResult = $defence->blockDamage($weapon, $blockResult);
                        if ($blockResult === -1)
                            $this->takeOffEquipment($defence, $enemy, $key);
                    }
                }
                $finalDamage = (isset($blockResult) && $blockResult !== false ? $blockResult : $damage) - $hero->reduceDmg;
                $enemy->hitPoints -= $finalDamage;
            }
            if ($effectResult && $finalDamage != 0)
                $enemy->hitPoints -= $this->multipleDamage * $damage - $damage ;
        }
    }
}