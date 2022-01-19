<?php

namespace Tournament;

abstract class Weapon
{
    protected $dmg;

    abstract function strike ();

    abstract function getDamage();
}