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
	
	/**
	 * @dataProvider getNameServers
	 */
	public function testGetNameServers($domain, $nameServers)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Internic($whois);
		$this->assertEquals($nameServers, $result->getNameServers());
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
	
	public function getNameServers()
	{
		return array
		(
			array
			(
				'amazon.com', array
				(
					'NS1.P31.DYNECT.NET', 'NS2.P31.DYNECT.NET', 
					'NS3.P31.DYNECT.NET', 'NS4.P31.DYNECT.NET', 
					'PDNS1.ULTRADNS.NET','PDNS2.ULTRADNS.NET', 
					'PDNS3.ULTRADNS.ORG', 'PDNS4.ULTRADNS.ORG', 
					'PDNS5.ULTRADNS.INFO', 'PDNS6.ULTRADNS.CO.UK'
				)
			),
			array
			(	
				'twitter.com', array
				(
					'NS1.P34.DYNECT.NET', 'NS2.P34.DYNECT.NET', 
					'NS3.P34.DYNECT.NET', 'NS4.P34.DYNECT.NET'
				)
			)
		);
	}
}