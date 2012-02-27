Proto
=====

***because bitches loves prototypes***

Use prototype pattern in PHP, simulate Scopes and prototype based objetcs, clones, etc.

```php
<?php

require('lib/autoload.php');

use \Proto\Scope;
use \Proto\ScopeVar;
use \Proto\Object;

```

Scopes
------
fuck off php namespaces, use scopes!

```php
<?php

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
/*

Array
(
    [medias] => string
    [getTele] => object
)

*/

echo "Aca la tele: " . $cajon->getTele() ."\n";
// Aca la tele: casa.dormitorio.tele
```

Inheritance in class-based
--------------------------

Prototype... instances...

```php
<?php

$car = Object::create(function ($self,$model,$color) {
        $self->model = new ScopeVar($model);
        $self->color = new ScopeVar($color);
});


$car->prototype->avanzar = function ($self,$velocidad) {
        echo "avanzo a {$velocidad}km por hora\n";
};

$ka = $car(2005,'azul');

$ka->avanzar(25);
// avanzo a 25km por hora
```

Extends prototypes objects
--------------------------

```php
<?php

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
//avanzo a 80km por hora
//viajando a 24/57/2012 a las 23:57:11
```

Like JavaScript!
----------------
    
See this: http://github.com/exos/PHP-Proto/wiki/From-JavaScript
    
Documentation and discution
---------------------------

- Documentation: http://github.com/exos/PHP-Proto/wiki
- Mailing list for help and discution: http://groups.google.com/group/php-proto
- For issues, bugs and ideas: http://github.com/exos/PHP-Proto/issues