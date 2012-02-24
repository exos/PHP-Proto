<?php

require('../lib/autoload.php');

use \Proto\Scope;
use \Proto\Object;


$privado = new Scope();


$privado->car = Object::create(function ($self,$model,$color) {
        $self->model = $model;
	$self->color = $color;
});


$privado->car->prototype->avanzar = function ($self,$velocidad) {
	echo "avanzo a {$velocidad}km por hora\n";
};

$ka = $privado->car(2005,'azul');

$ka->avanzar(25);
