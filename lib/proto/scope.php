<?php

/**
 * Part of a PHP Proto library, for more informatiom/copyright/help
 * visit https://github.com/exos/PHP-Proto
 * 
 * @package Proto
 * @author exos <tioscar@gmail.com>
 * 
 */

namespace Proto;

use \Proto\Exceptions\PropertyUndefined as PropertyUndefinedException;

class Scope {
    
    protected $_content = array();
    protected $_scope = null;
    private $_varmap = array();
    
    public function __construct (array $content = null) {
        
        if ($content) foreach ($content as $key => $value) {
            $this->$key = $value;
        }
        
    }

    public function __set($var, $value) {
        
        $this->_content[$var] = $value;

        if ( is_object($this->_content[$var]) && is_a($this->_content[$var],'\Proto\Scope')) {
            $this->_content[$var]->setScope($this);
        }
                
    }
    
    public function __isset($var) {
        return isset($this->_content[$var]);
    }
    
    public function is_set ($var) {
        
        // Search in varmap for optimized
        if (isset($this->_varmap[$var])) {
            return $this->_varmap[$var];
        }
        
        $scope = $this;
            
        while ($scope = $scope->getScope()) {
            if (isset($scope->$var)) {
                $this->_varmap[$var] = $scope;
                return $scope;
            }
        }
        
        return null;
        
    }
    
    public function listMembers() {
        $res = array();
        
       foreach ($this->_content as $key => $val) {
           $res[$key] = gettype($val);
       }
       
       return $res;
    }
    
    public function __get($var) {
        
        if ($var == 'parent') {
            return $this->getScope();
        }
        
        if (isset($this->_content[$var])) {
            return $this->_content[$var];
        }
        
        // If nothing...
        throw new PropertyUndefinedException($var . ' is not defined');

    }

    public function __call($func, $args) {
        return $this->call($func, $args);
    }
    
    public function call ($func, $args, $bind = null) {
        $self = is_null($bind) ? $this : $bind;
        
	if (isset($this->_content[$func])) {
	    if (is_callable($this->_content[$func])) {
		return call_user_func_array($this->_content[$func], array_merge(array( new SelfArgument($self)), $args));
	    } else {
		// error
	    }
	} else {
	    throw new PropertyUndefinedException($func . ' is not defined');
	}
    }

    public function getScope () {
        return $this->_scope;
    }
    
    public function setScope (Scope $scope) {
        $this->_scope = $scope;
        return $this;
    }
    
    public function cloneObject ()  {
	return new static($this->_content);
    }

    public function ____content () {
	return $this->_content;
    }
    
}
