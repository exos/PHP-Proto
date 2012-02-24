<?php

require('../lib/autoload.php');

use \Proto\Scope;
use \Proto\Object;

$user = new Scope();

$user->nombre = 'Jhon';

$user->identificate = function ($self) {
        echo "me llamo " . $self->nombre;
};

$user->identificate();

