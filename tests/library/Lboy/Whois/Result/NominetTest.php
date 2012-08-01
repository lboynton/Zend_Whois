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
	
	/**
	 * @dataProvider getNameServers
	 */
	public function testGetNameServers($domain, $nameServers)
	{
		$whois = file_get_contents(dirname(__FILE__) . '/resources/' . $domain); 
		$result = new Lboy_Whois_Result_Nominet($whois);
		$this->assertEquals($nameServers, $result->getNameServers());
	}
	
	public function getWhois()
	{
		return array
		(
			array('amazon.co.uk', '05-Dec-2012'),
			array('bbc.co.uk', '13-Dec-2012')
		);
	}
	
	public function getNameServers()
	{
		return array
		(
			array
			(
				'amazon.co.uk', array
				(
					'ns1.p31.dynect.net', 'ns2.p31.dynect.net', 
					'ns3.p31.dynect.net', 'ns4.p31.dynect.net', 
					'pdns1.ultradns.net','pdns2.ultradns.net', 
					'pdns3.ultradns.org', 'pdns4.ultradns.org', 
					'pdns5.ultradns.info', 'pdns6.ultradns.co.uk'
				)
			),
			array
			(	
				'bbc.co.uk', array
				(
					'ns1.rbsov.bbc.co.uk', 'ns1.tcams.bbc.co.uk', 
					'ns1.thdow.bbc.co.uk'
				)
			)
		);
	}
}
