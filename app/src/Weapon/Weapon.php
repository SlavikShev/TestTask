<?php

namespace Tournament;

abstract class Weapon
{
    public $handed;
    protected $dmg;

    // переименовать на strike или makeHit
    abstract function makeDamage ();

    abstract function getDamage();
}