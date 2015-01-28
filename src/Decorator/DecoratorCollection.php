<?php

namespace Pagekit\Decorator;

use Composer\Autoload\ClassLoader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PageKit\Decorator\Event\DecorateEvent;

class DecoratorCollection implements EventSubscriberInterface {
	protected $loader;
	protected $decorators;

	function __construct(ClassLoader $loader){
		$this->loader = $loader;
	}

	public function add($className, $decoratorClassName, $priority = 50){
		$this->decorators[$className][$priority] []= $decoratorClassName;
		ksort($this->decorators[$className]);
	}

	public function decorate($object, $context = null){
		$className = get_class($object);
		if (!empty($this->decorators[$className])){
			$decoratorClassesByPriority = $this->decorators[$className];
			foreach($decoratorClassesByPriority as $priority => $decoratorClasses){
				$object = $this->instantiateDecorators($object, $decoratorClasses, $context);
			}
		}
		return $object;
	}

	protected function instantiateDecorators($object, $decoratorClasses, $context = null){
		foreach($decoratorClasses as $class){
			$object = new $class($object, $context);
		}
		return $object;
	}

	public function onDecorateRequested(DecorateEvent $decorateEvent){
		$decorateEvent->setDecoratedObject($this->decorate($decorateEvent->getObject(), $decorateEvent->getContext()));
	}

	public static function getSubscribedEvents()
	{
		return [
			'decorators.decorate' => ['onDecorateRequested', 8]
		];
	}
}
