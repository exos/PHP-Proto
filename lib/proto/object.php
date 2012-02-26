<?php

namespace Proto;

use Exceptions\Defintion as DefinitionException;
use Exceptions\PropertyUndefined as PropertyUndefinedException;

class Object extends Scope {
    
    private $_initialize;
    private $_prototype = null;
            
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
       
	$this->_prototype = new Scope(); 
        $this->_content['prototype'] = &$this->_prototype;
        
    }
    
    // Private:
    
    private function _setPrototype (\Proto\Scope $content) {
	$this->_prototype = $content;
    }
    
    // Magicos:
    
    public function __set ($var,$value) {
        if ($var == 'prototype') {
            return $this->_prototype = new Scope($value);
        }
        
        parent::__set($var,$value);
                
    }
    
    public function __invoke () {
        return call_user_func_array(array($this,'instanced'), func_get_args());
    }
    
    // Public
    
    public static function create ($func) {
	return new static($func);
    }
    
    public function call ($func, $args, $bind = null) {
        if ($func == 'prototype') {

	    if (is_array($args[0])) {
		$proto = new Scope($args[0]);
	    } else {
		$proto = $args[0];
	    }

            return $this->_setPrototype($proto);
        }

	parent::call($func, $args, $bind);
    }
 
    public function instanced () {
        $instance = new Instance($this->_prototype);
        call_user_func_array($this->_initialize, array_merge(array($instance), func_get_args()));
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
		$content = $proto->prototype->____content();
            } else {
		$content = $proto;
            }

	    foreach ($content as $key => $val) {
		$ins->prototype->$key = $val;
	    }
            
        } 

	return $ins;
        
    }
    
}
