<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois_Result_InternicTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getWhois
	 */
	public function testGetExpiryDate($domain, $expiry)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Internic($whois);
		$this->assertEquals($expiry, $result->getExpiry());
	}
	
	public function getWhois()
	{
		return array
		(
			array('amazon.com', '31-oct-2021'),
			array('apple.com', '20-feb-2020'),
			array('google.com', '14-sep-2020'),
			array('twitter.com', '21-jan-2019')
		);
	}
}
