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
                            $hero->takeOffEquipment($defence, $enemy, $key);
                        }
                    }
                }
                // изменять здоровье через функцию, а не напрямую
                $enemy->hitPoints -= (!empty($blockResult) ? $blockResult : $damage) - $hero->reduceDmg;
            }
            if ($effectResult)
                $enemy->hitPoints -= $this->multipleDamage * $damage - $damage;
        }
    }
}