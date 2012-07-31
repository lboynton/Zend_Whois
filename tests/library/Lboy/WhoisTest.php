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
	
	/**
	 * @dataProvider getDomains
	 */
	public function testQuery($domain)
	{
		$result = $this->whois->query($domain);
		$this->assertInstanceOf('Lboy_Whois_Result_AbstractResult', $result);
	}
	
	/**
	 * @dataProvider getDomains
	 * @param string $domain
	 * @param string $tld
	 */
	public function testGetTld($domain, $tld)
	{
		$this->assertEquals($tld, $this->whois->getTld($domain));
	}
	
	public function getDomains()
	{
		return array
		(
			array('google.com', 'com', 'whois.internic.net'),
			array('subdomain.test.com', 'com', 'whois.internic.net'),
			array('test.co.uk', 'co.uk', 'whois.nic.uk'),
			array('test.org', 'org', 'whois.pir.org')
		);
	}
	
	/**
	 * @dataProvider getDomains
	 * @param string $domain
	 * @param string $tld
	 * @param string $whois
	 */
	public function testGetWhoisServer($domain, $tld, $whois)
	{
		$this->assertEquals($whois, $this->whois->getWhoisServer($domain));
	}
}
