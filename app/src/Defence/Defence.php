<?php

namespace Tournament;

abstract class Defence
{
    abstract function blockDamage (Weapon $weapon);
}