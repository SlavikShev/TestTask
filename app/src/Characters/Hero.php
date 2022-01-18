<?php

namespace Tournament;

abstract class Hero
{
    public $hitPoints;
    public $equipment;
    public $reduceDmg = 0;

    public function __construct() {
        $this->startEquipment();
    }

    abstract public function startEquipment ();

    public function hitPoints () {
        return $this->hitPoints > 0 ? $this->hitPoints : 0;
    }

    // подобавлять везде коментарии на английском
    // удалить Index.php
    // сделать нормальный неймспейсинг типа "Armor\\" : "app\src\Armor"
    // defence и weapon вынести в отдельную папку equipment
    public function engage (Hero $enemy) {
        while ($this->hitPoints > 0 && $enemy->hitPoints > 0) {
            Fight::fight($this, $enemy);
        }
    }

    // наносим урон по противнику
    public function damageEnemy (Hero $enemy, Hero $hero = null) {
        if ($this->hitPoints > 0) {
            // перебираем все чем мы можем нанести урон
            foreach ($this->equipment['Weapon'] as $weapon) {
                $damage = $weapon->makeDamage();
                // перебираем все чем противник может уменьшить урон
                if (isset($enemy->equipment['Defence'])) {
                    foreach ($enemy->equipment['Defence'] as $key => $defence) {
                        $blockResult = $defence->blockDamage($weapon);
                        if ($blockResult === true) // противник пытается блокировать урон от нас
                            return;
                        if ($blockResult === -1) {
                            $this->takeOffEquipment($defence, $enemy, $key);
                        }
                    }
                }
                $enemy->hitPoints -= (!empty($blockResult) ? $blockResult : $damage) - $this->reduceDmg;
            }
        }
    }

    // Сделать проверку существует ли такой класс
    // Сделать создание объекта без хардкода namespace
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

    //!! сделать функцию destroy внутри классов броня
    public function reduceDamageBecauseOfEquipment (Defence $defence) {
        if (isset($defence->reduceDmg))
            $this->reduceDmg += $defence->reduceDmg;
    }

    public function takeOffEquipment (Defence $defence, Hero $hero, $key) {
        if (isset($defence->reduceDmg))
            $this->reduceDmg -= $defence->reduceDmg;
        unset($hero->equipment['Defence'][$key]);
    }

    public function replaceWeapon ($currentWeapon, $newWeapon) {
        if ($currentWeapon->getDamage() < $newWeapon->getDamage())
            return true;
    }
}