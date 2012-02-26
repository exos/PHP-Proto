<?php

require('../lib/autoload.php');

set_exception_handler(function ($exp) {

        echo "Exception: ". $exp->getMessage() . "\n";

        print_r($exp->getTrace());

});


use \Proto\Scope;
use \Proto\ScopeVar;
use \Proto\Object;


$casa = new Scope();

$casa->puerta = "casa.puerta";

$casa->dormitorio = new Scope();

$casa->dormitorio->tele = "casa.dormitorio.tele";

$casa->dormitorio->cajonera = new Scope(array(
        'cajon1' => new Scope(),
        'cajon2' => new Scope(),
        'cajon3' => new Scope()
));

$casa->dormitorio->cajonera->cajon1->medias = "casa.dormitorio.cajonera.cajon1.medias";

$casa->dormitorio->cajonera->abrir = function ($self, $cajon) {

	if ($cajon < 0 || $cajon > 3) {
		throw new Exception("Only cajon 1,2 and 3");
	}

	$name = 'cajon' . $cajon;

	return $self->$name;

};

$casa->dormitorio->cajonera->cajon1->getTele = function ($self) {
	return $self->tele;
};

$cajon = $casa->dormitorio->cajonera->abrir(1);

print_r($cajon->listMembers());

echo "Aca la tele: " . $cajon->getTele() ."\n";
