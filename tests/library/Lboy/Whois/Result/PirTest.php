<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois_Result_PirTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getWhois
	 */
	public function testGetExpiryDate($domain, $expiry)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Pir($whois);
		$this->assertEquals($expiry, $result->getExpiry());
	}
	
	public function getWhois()
	{
		return array
		(
			array('pir.org', '19-Feb-2015'),
			array('slashdot.org', '04-Oct-2012'),
			array('wikipedia.org', '13-Jan-2016')
		);
	}
	
	/**
	 * @dataProvider getNameServers
	 */
	public function testGetNameServers($domain, $nameServers)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Pir($whois);
		$this->assertEquals($nameServers, $result->getNameServers());
	}
	
	public function getNameServers()
	{
		return array
		(
			array
			(
				'pir.org', array
				(
					'NS1.AMS1.AFILIAS-NST.INFO', 'NS1.MIA1.AFILIAS-NST.INFO', 
					'NS1.SEA1.AFILIAS-NST.INFO', 'NS1.YYZ1.AFILIAS-NST.INFO'
				),
				'slashdot.org', array
				(
					'NS3.P03.DYNECT.NET', 'NS1.P03.DYNECT.NET', 
					'NS2.P03.DYNECT.NET', 'NS4.P03.DYNECT.NET'
				),
				'wikipedia.org', array
				(
					'NS0.WIKIMEDIA.ORG', 'NS1.WIKIMEDIA.ORG', 
					'NS2.WIKIMEDIA.ORG'
				),
			)
		);
	}
	
	public function testIsRateLimitExceeded()
	{
		$whois = 'WHOIS LIMIT EXCEEDED';
		$result = new Lboy_Whois_Result_Pir($whois);
		$this->assertTrue($result->isRateLimitExceeded());
	}
}
