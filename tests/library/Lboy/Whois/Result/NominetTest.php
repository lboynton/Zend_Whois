<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois_Result_NominetTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getWhois
	 */
	public function testGetExpiryDate($domain, $expiry)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Nominet($whois);
		$this->assertEquals($expiry, $result->getExpiry());
	}
	
	public function getWhois()
	{
		return array
		(
			array('amazon.co.uk', '05-Dec-2012'),
			array('bbc.co.uk', '13-Dec-2012')
		);
	}
}
