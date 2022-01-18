<?php

namespace Tournament;

class Fight {
    static function fight (Hero $hero, Hero $enemy) {
        $hero->damageEnemy($enemy);
        $enemy->damageEnemy($hero);
    }
}