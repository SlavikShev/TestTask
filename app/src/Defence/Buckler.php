<?php

namespace Tournament;

class Buckler extends Defence
{
    private $hitsToBlock = 0;
    private $strength = 100;
    public $reduceIncomingDamage;
    private $blockEveryThHit = 2;

    public function __construct() {
        $this->reduceIncomingDamage = 'all'; // возможно убрать
    }

    // сделать сеттер для was hit before с проверкой на boolean
    // тогда прийдется делать проверку на тип для каждого свойства
    public function hitByAxe () {
        $this->strength -= 33.33333;
    }

    public function ruinShieldFromAxe (Weapon $weapon) {
        // получаем название класса оружия которым нанесен удар, и если есть метод снятия прочности щита, вызываем его
        $className = (new \ReflectionClass($weapon))->getShortName();
        $functionName = 'hitBy' . $className;
        if (method_exists(__CLASS__, $functionName))
            $this->$functionName();
    }

    // !!!сделать чтобы функция возвращала колличество урона которое осталось после блокировки
    // !!!!сделать чтобы отнималась прочность только если урон нанесен по первонажу
    public function blockDamage(Weapon $weapon) {
        if ($this->strength < 1)
            return -1;
        if ($weapon->getDamage() === 0)
            return true;
        if ($this->hitsToBlock != 0) { // наступил ли ход для блокировки
            $this->hitsToBlock--;
            return false;
        } else { // ход блокировки наступил
            $this->hitsToBlock = $this->blockEveryThHit - 1; // если блокируем каждый второй удар, то до следующего блока 2 - 1 = 1 удар
            // !!!!!переделать чтобы вызов функции не был захардкожен
            $this->ruinShieldFromAxe($weapon);
            return true;
        }
    }
}