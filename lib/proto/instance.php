<?php

namespace Proto;

use \Proto\Exceptions\Defintion as DefinitionException;
use \Proto\Exceptions\PropertyUndefined as PropertyUndefinedException;

class Instance extends Scope {
    
    private $_bind = null;

    public function __construct (Scope $prototype) {
        $this->_content = $prototype->____content();
    }
    
    public function bind (Scope $Scope) {
	$this->_bind = $Scope;
    }

    public function __call($func, $args) {
        if (isset($this->_content[$func])) {
            if (is_callable($this->_content[$func])) {

		$self = $this->_bind ? $this->_bind : $this;

                return call_user_func_array($this->_content[$func], array_merge(array($self), $args));
            } else {
                // error
            }
        } else {
            throw new PropertyUndefinedException($func . ' is not defined');
        }
    }

}
