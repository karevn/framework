<?php

namespace Pagekit\Decorator;


class Decorator {
	protected $decorated_object;
	protected $decoration_context;

	function __construct($object, $context = null){
		$this->decorated_object = $object;
		$this->decoration_context = $context;
	}

	function __call($method, $arguments){
		call_user_func_array([$this->decorated_object, $method], $arguments);
	}

	function __get($property){
		return $this->decorated_object->$property;
	}

	function __set($property, $value){
		$this->decorated_object->$property = $value;
	}
}
