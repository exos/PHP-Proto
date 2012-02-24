<?php

require('../lib/autoload.php');

date_default_timezone_set('UTC');

use \Proto\Scope;
use \Proto\Object;



$car = Object::create(function ($self,$model,$color) {
        $self->model = $model;
        $self->color = $color;
});


$car->prototype->avanzar = function ($self,$velocidad) {
        echo "avanzo a {$velocidad}km por hora\n";
};


$timeMachine = $car->extend(array(

	'fechaActual' => time(),

	'viajarPorElTiempo' => function ($self, $fecha) {
		$self->avanzar(80);
		echo "viajando a " . date('d/i/Y \a \l\a\s H:i:s',$fecha) . "\n";
		$self->fechaActual = $fecha;
	}

));

$delorean = $timeMachine(1985,'gris');

$delorean->viajarPorElTiempo( time() + 3600 ); // Una hora en el futuro

