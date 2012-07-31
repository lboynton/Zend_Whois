<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_WhoisTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Lboy_Whois 
	 */
	protected $whois;
	
	public function setUp()
	{
		$this->whois = new Lboy_Whois();
	}
	
	public function testQuery()
	{
		$result = $this->whois->query("test.com");
		$this->assertInstanceOf('Lboy_Whois_Result_AbstractResult', $result);
	}
}
