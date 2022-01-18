<?php

namespace Tournament;

abstract class Hero
{
    public $hitPoints;
    public $equipment;
    private $reduceDmg = 0;

    public function __construct() {
        $this->startEquipment();
    }

    abstract public function startEquipment ();

    public function hitPoints () {
        return $this->hitPoints > 0 ? $this->hitPoints : 0;
    }

    // пересмотреть спецификаторы доступов у всех свойств и методов
    // сделать функцию что возвращает здоровье после удара
    // подобавлять везде коментарии на английском
    // удалить Index.php
    // возможно переделать методы в статические
    // Доработать чтобы учитавалось одноручное или дворучное оружие
    // сделать проверку что нельзя добавлять при дворучном орижии еще оружие
    // создать класс для работы с инвентарем
    // попробовать переделать создание оружие и брони на фабрику
    // сделать нормальный неймспейсинг типа "Armor\\" : "app\src\Armor"
    // убрать передачу всего объекта персонажа где нужно только его оружие или броня и передать конкретно их
    // defence и weapon вынести в отдельную папку equipment
    public function engage (Hero $enemy) {
        while ($this->hitPoints > 0 && $enemy->hitPoints > 0) {
            $this->damageEnemy($enemy); // пытаемся нанести урон по противнику
            $enemy->damageEnemy($this);
        }
    }

    // наносим урон по противнику
    private function damageEnemy (Hero $enemy) {
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
                            unset($enemy->equipment['Defence'][$key]);
                        }
                    }
                }
                // изменять здоровье через функцию, а не напрямую
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
        $this->equipment[$equipType][] = new $equip;
        if ($equipType == 'Defence')
            $this->reduceDamageBecauseOfEquipment(new $equip);
        return $this;
    }

    //!! сделать функцию destroy внутри классов броня
    public function reduceDamageBecauseOfEquipment (Defence $defence) {
        if (isset($defence->reduceDmg))
            $this->reduceDmg += $defence->reduceDmg;
    }
}