Proto
#####

because bitches lives prototypes

Use prototype pattern in PHP

```php
<?php

require('lib/autoload.php');

use \Proto\Scope;
use \Proto\Object;

```

Scopes
------
fuck off namespaces, use scopes!

```php
$user = new Scope();

$user->nombre = 'Jhon';

$user->identificate = function ($self) {
        echo "me llamo " . $self->nombre;
};

$user->identificate();
```

```
me llamo Jhon
```

Instances based programming
---------------------------

Prototype... prototypes...

```php
<?php

$car = Object::create(function ($self,$model,$color) {
        $self->model = $model;
        $self->color = $color;
});


$car->prototype->avanzar = function ($self,$velocidad) {
        echo "avanzo a {$velocidad}km por hora\n";
};

$ka = $car(2005,'azul');

$ka->avanzar(25);

```

```
avanzo a 25km por hora
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
```

```
avanzo a 80km por hora
viajando a 24/57/2012 a las 23:57:11
```
