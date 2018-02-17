<?php namespace League\PHPUnitCoverageListener\Tests\Hook;

use Monad\Collection;
use League\PHPUnitCoverageListener\Hook\Travis;
use \PHPUnit_Framework_TestCase;

/**
 * Travis hook class test
 *
 * @package  League\PHPUnitCoverageListener
 * @author   Taufan Aditya <toopay@taufanaditya.com>
 */

class TravisTest extends PHPUnit_Framework_TestCase
{
	public function testIntegrity()
	{
		$travis = new Travis();

		$this->assertInstanceOf('League\PHPUnitCoverageListener\HookInterface', $travis);
	}

	public function testBeforeCollectCallback()
	{
		// Emulate travis environment
		$_ENV['TRAVIS_JOB_ID'] = 'some-fake-id';

		// Payload data
		$data = new Collection(['repo_token' => 's3cr3t']);

		$this->assertTrue($data->offsetExists('repo_token'));

		$travis = new Travis();

		$data = $travis->beforeCollect($data);

		// Repo token will removed
		$this->assertFalse($data->offsetExists('repo_token'));

		// And Travis specific keys will be added
		// with above data assigned respectively
		$this->assertTrue($data->offsetExists('service_name'));
		$this->assertTrue($data->offsetExists('service_job_id'));

		$values = $data->toArray();

		$this->assertEquals('travis-ci', $values['service_name']);
		$this->assertEquals('some-fake-id', $values['service_job_id']);

		unset($_ENV['TRAVIS_JOB_ID']);

	}

	public function testAfterCollectCallback()
	{
		// Payload data
		$data = new Collection(['repo_token' => 's3cr3t']);

		$this->assertTrue($data->offsetExists('repo_token'));

		// Nothing happens on after callback
		$travis = new Travis();

		$data = $travis->afterCollect($data);

		$this->assertTrue($data->offsetExists('repo_token'));
	}
}