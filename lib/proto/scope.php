<?php

/**
 * Description of scope
 *
 * @author exos
 */

namespace Proto;

use \Proto\Exceptions\PropertyUndefined as PropertyUndefinedException;

class Scope {
    
    protected $_content = array();
    protected $_scope = null;
    
    public function __construct (array $content = null) {
	if (!is_null($content)) {
	     $this->_content = $content;
	}
    }

    public function __set($var, $value) {
        $this->_content[$var] = $value;
    }
    
    public function __get($var) {
        if (isset($this->_content[$var])) {
            return $this->_content[$var];
        } else {
            throw new PropertyUndefinedException($var . ' is not defined');
        }
    }

    public function __call($func, $args) {
	if (isset($this->_content[$func])) {
	    if (is_callable($this->_content[$func])) {
		return call_user_func_array($this->_content[$func], array_merge(array($this), $args));
	    } else {
		// error
	    }
	} else {
	    throw new PropertyUndefinedException($func . ' is not defined');
	}
    }

    public function cloneObject ()  {
	return new static($this->_content);
    }

    public function ____content () {
	return $this->_content;
    }
    
}
