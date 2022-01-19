<?php

namespace Tournament;

class Buckler extends Defence
{
    private $hitsToBlock = 0;
    private $strength = 100;
    private $blockEveryThHit = 2;

    public function hitByAxe () {
        $this->strength -= 33.33333;
    }

    public function ruinShieldFromWeapon (Weapon $weapon) {
        $className = (new \ReflectionClass($weapon))->getShortName();
        $functionName = 'hitBy' . $className;
        if (method_exists(__CLASS__, $functionName))
            $this->$functionName();
    }

    public function blockDamage(Weapon $weapon, $reducedDamage = null) {
        if ($this->strength < 1)
            return -1;
        if ($weapon->getDamage() === 0) // if getting 0 damage
            return 0;
        if ($this->hitsToBlock != 0) { // not turn to block
            $this->hitsToBlock--;
            return false;
        } else { // block damage
            $this->hitsToBlock = $this->blockEveryThHit - 1; // if block every second hit, next block turn 2 - 1 = 1 hit
            $this->ruinShieldFromWeapon($weapon);
            return 0;
        }
    }
}