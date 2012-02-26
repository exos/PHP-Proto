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

    public function call($func, $args, $bind = null) {
        $self = is_null($bind) ? ($this->_bind ? $this->_bind : $this) : $bind;
        parent::call($func, $args, $bind);
    }

}
