<?php

namespace Proto;

use Exceptions\Defintion as DefinitionException;
use Exceptions\PropertyUndefined as PropertyUndefinedException;

class Object extends Scope {
    
    private $_initialize;
    private $_prototype = array();
            
    public function __construct ($initfunction = null) {
        if ($initfunction) {
            if (is_callable($initfunction)) {
                $this->_initialize = $initfunction;
            } else {
                throw new DefintionException('The initializator is not a function');
            }
        } else {
            $this->_initialize = function () {};
        }
        
        $this->_content['prototype'] &= $this->_prototype;
        
    }
    
    // Private:
    
    private function _setPrototype (array $content) {
        foreach ($content as $key => $val) {
            if (is_string($key)) {
                $this->_prototype[$key] = $val;
            } else {
                throw new DefinitionException('Property name is a ' . gettype($key));
            }
        }
    }
    
    // Magicos:
    
    public function __set ($var,$value) {
        if ($var == 'prototype') {
            return $this->_setPrototype($value);
        } else {
            return $this->_content[$var] = $value;
        }
    }
    
    public function __call ($func, $args) {
        if ($func == 'prototype') {
            return $this->_setPrototype($args[0]);
        } else {
            throw new PropertyUndefinedException($var . ' function is not defined');
        }
    }
    
    public function __invoke () {
        return call_user_func(array($this,'create'), func_get_args());
    }
    
    // Public
    
    public function getScope () {
        return $this->_scope;
    }
    
    public function setScope (Scope $scope) {
        $this->_scope = $scope;
        return $this;
    }
    
    public function create () {
        $instance = new Instance($this->_prototype);
        call_user_func($this->_initialize, array_merge($instance, func_get_args()));
        return $instance;
    }
    
    public function cloneObject() {
        $newObject = new Object($this->_initialize);
        $newObject->prototype($this->_prototype);
        return $newObject;
    }
    
    public function extend () {
       
	$ins = $this->cloneObject();
 
        foreach (func_get_args() as $proto) { 
            
            if ( is_a ($proto, 'Proto\Object') ) {
                $ins->prototype( $proto->prototype );
            } else {
                $ins->prototype( $proto );
            }
            
        } 

	return $ins;
        
    }
    
}
