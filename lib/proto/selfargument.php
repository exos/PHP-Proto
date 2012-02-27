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

use \Proto\Exceptions\Defintion as DefinitionException;

class SelfArgument extends Scope {
        
    public function __construct(Scope $scope) {
        $this->setScope($scope);
    }
    
    function __get ($var) {
        
        if (isset($this->_scope->$var)) {
            return $this->_scope->$var;
        } elseif ($scope = $this->_scope->is_set($var)) {
            return $scope->$var;
        } else {
            throw new DefinitionException ($var . " dont exist in this scope space");
        }
        
    }
    
    function __set ($var, $value) {
    
        if (is_object($value) && is_a($value,'\Proto\ScopeVar')) {
            parent::__set($var, $value->value);
            unset($value);
        } else {

            if ($scope = $this->is_set($var)) {
                $scope->$var = $value;
            } else {
                parent::__set($var,$value);
            }

        }
    }
    
    function call ($func, $args, $bind = null) {
        
        $self = is_null($bind) ? $this : $bind;
        
        if (isset($this->_scope->$func)) {
            if (is_callable($this->_scope->$func)) {
                return $this->_scope->call($func, $args, $self);
            }
        } elseif ($scope = $this->_scope->is_set($func)) {
            return $scope->call($func, $args, $self);
        } else {
            throw new DefinitionException ($func . " dont exist in this scope space");
        }
    }
    
}
