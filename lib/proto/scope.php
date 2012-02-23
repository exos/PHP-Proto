<?php

/**
 * Description of scope
 *
 * @author exos
 */

namespace Proto;

use Exceptions\PropertyUndefined as PropertyUndefinedException;

class Scope {
    
    private $_content = array();
    private $_scope = null;
    
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
    
}