<?php

namespace Pagekit\Tests;

use Pagekit\Application;
use Pagekit\Config\Config;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ServiceProviderTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    protected $app;

	public function setUp()
	{
		$this->app = new Application([
			'path.cache' => __DIR__.'/cache-ignore',
			'session' => new Session(new MockArraySessionStorage),
			'request' => $this->getMock('Symfony\Component\HttpFoundation\Request')
		]);
	}

    public function tearDown()
    {
    	$this->app->reset();
    }

	public function getConfig($settings)
	{
		$config = new Config();

		foreach ($settings as $key => $value) {
			$config->set($key, $value);
		}

		return $config;
	}
}
