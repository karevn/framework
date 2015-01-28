<?php

namespace Pagekit\Decorator\Event;

use Symfony\Component\EventDispatcher\Event;

class DecorateEvent extends Event{
	protected $object;
	protected $decoratedObject;
	protected $context;

	function __construct($object, $context = null){
		$this->object = $object;
		$this->decoratedObject = $object;
		$this->context = $context;
	}

	function getContext(){
		return $this->context;
	}
	function getObject(){
		return $this->object;
	}

	function setDecoratedObject($decoratedObject){
		$this->decoratedObject = $decoratedObject;
	}

	function getDecoratedObject(){
		return $this->decoratedObject;
	}
}
