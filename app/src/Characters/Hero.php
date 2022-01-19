<?php

namespace Tournament;

abstract class Hero
{
    public $hitPoints;
    public $equipment;
    public $reduceDmg = 0;

    public function hitPoints () {
        return $this->hitPoints > 0 ? $this->hitPoints : 0;
    }

    // fight
    public function engage (Hero $enemy) {
        while ($this->hitPoints > 0 && $enemy->hitPoints > 0) {
            Fight::fight($this, $enemy);
        }
    }

    // damage enemy
    public function damageEnemy (Hero $enemy, Hero $hero = null) {
        if ($this->hitPoints > 0) {
            foreach ($this->equipment['Weapon'] as $weapon) {
                $damage = $weapon->strike();
                $blockResult = $this->processingBlockDamage($enemy, $weapon);
                $enemy->hitPoints -= (isset($blockResult) && $blockResult !== false ? $blockResult : $damage) - $this->reduceDmg;
            }
        }
    }

    public function processingBlockDamage ($enemy, $weapon) {
        if (!empty($enemy->equipment['Defence'])) {
            $blockResult = 0;
            foreach ($enemy->equipment['Defence'] as $key => $defence) {
                $blockResult = $defence->blockDamage($weapon, $blockResult);
                if ($blockResult === -1)
                    $this->takeOffEquipment($defence, $enemy, $key);
            }
            return $blockResult;
        }
    }

    // equip hero
    public function equip ($equip) {
        $namespace = 'Tournament\\';
        $equip = $namespace . ucfirst($equip);
        $equipType = (new \ReflectionClass($equip))->getParentClass()->getShortName();
        if ($equipType == 'Weapon') {
            if ($this->equipment[$equipType] == null || $this->replaceWeapon($this->equipment[$equipType][0], new $equip)) {
                $this->equipment[$equipType] = null;
                $this->equipment[$equipType][] = new $equip;
            }
        } elseif ($equipType == 'Defence') {
            $this->equipment[$equipType][] = new $equip;
            $this->reduceDamageBecauseOfEquipment(new $equip);
        }
        return $this;
    }

    // reduce base hero damage
    public function reduceDamageBecauseOfEquipment (Defence $defence) {
        if (isset($defence->reduceDmg))
            $this->reduceDmg += $defence->reduceDmg;
    }

    // unset equipment from inventory
    public function takeOffEquipment (Defence $defence, Hero $hero, $key) {
        if (isset($defence->reduceDmg))
            $this->reduceDmg -= $defence->reduceDmg;
        unset($hero->equipment['Defence'][$key]);
    }

    // replace old weapon if equip weapon with more damage
    public function replaceWeapon ($currentWeapon, $newWeapon) {
        if ($currentWeapon->getDamage() < $newWeapon->getDamage())
            return true;
    }
}