<?php

namespace Tournament;

abstract class Weapon
{
    protected $dmg;

    abstract function makeDamage ();

    abstract function getDamage();
}