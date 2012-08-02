<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois_Result_InfoTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getWhois
	 */
	public function testGetExpiryDate($domain, $expiry)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Info($whois);
		$this->assertEquals($expiry, $result->getExpiry());
	}
	
	public function getWhois()
	{
		return array
		(
			array('info.info', '08-Oct-2012')
		);
	}
	
	/**
	 * @dataProvider getNameServers
	 */
	public function testGetNameServers($domain, $nameServers)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Info($whois);
		$this->assertEquals($nameServers, $result->getNameServers());
	}
	
	public function getNameServers()
	{
		return array
		(
			array
			(
				'info.info', array
				(
					'NS1.AMS1.AFILIAS-NST.INFO', 'NS1.MIA1.AFILIAS-NST.INFO', 
					'NS1.SEA1.AFILIAS-NST.INFO', 'NS1.YYZ1.AFILIAS-NST.INFO',
					'NS1.HKG1.AFILIAS-NST.INFO'
				)
			)
		);
	}
}
