<?php

namespace Pagekit\Decorator;

use Pagekit\Application\ServiceProviderInterface;
use Pagekit\Application;

class DecoratorServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritdoc}
	 */
	public function register(Application $app)
	{
		$app['decorators'] = function($app) {
			return new DecoratorCollection($app['autoloader']);
		};
	}

	/**
	 * {@inheritdoc}
	 */
	public function boot(Application $app)
	{
		$app->subscribe($app['decorators']);
	}
}

