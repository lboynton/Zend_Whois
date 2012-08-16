<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois_Result_NeustarTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider getWhois
	 */
	public function testGetExpiryDate($domain, $expiry)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Neustar($whois);
		$this->assertEquals($expiry, $result->getExpiry());
	}
	
	public function getWhois()
	{
		return array
		(
			array('neustar.biz', 'Tue Nov 06 23:59:00 GMT 2012')
		);
	}
	
	/**
	 * @dataProvider getNameServers
	 */
	public function testGetNameServers($domain, $nameServers)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Neustar($whois);
		$this->assertEquals($nameServers, $result->getNameServers());
	}
	
	public function getNameServers()
	{
		return array
		(
			array
			(
				'neustar.biz', array
				(
					'PDNS1.ULTRADNS.NET', 'PDNS2.ULTRADNS.NET', 
					'PDNS3.ULTRADNS.ORG', 'PDNS4.ULTRADNS.ORG',
					'PDNS5.ULTRADNS.INFO', 'PDNS6.ULTRADNS.CO.UK'
				)
			)
		);
	}
}
