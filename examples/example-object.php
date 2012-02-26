<?php

require('../lib/autoload.php');

use \Proto\Scope;
use \Proto\ScopeVar;
use \Proto\Object;

$car = Object::create(function ($self,$model,$color) {
        $self->model = new ScopeVar($model);
        $self->color = new ScopeVar($color);
});


$car->prototype->avanzar = function ($self,$velocidad) {
        echo "avanzo a {$velocidad}km por hora\n";
};

$ka = $car(2005,'azul');

$ka->avanzar(25);
