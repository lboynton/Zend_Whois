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
	 * @dataProvider getValidDomains
	 */
	public function testQuery($domain)
	{
		$result = $this->whois->query($domain);
		$this->assertInstanceOf('Lboy_Whois_Result_AbstractResult', $result);
		
		$expiry = $result->getExpiry();
		$nameservers = $result->getNameservers();
		
		$this->assertTrue(is_int(strtotime($expiry)), sprintf(
			'Could not get expiry time (got "%s")', $expiry));
		$this->assertTrue(is_array($nameservers), 'Could not get nameservers');
	}
	
	/**
	 * @dataProvider getFakeDomains
	 * @param string $domain
	 * @param string $tld
	 */
	public function testGetTld($domain, $tld)
	{
		$this->assertEquals($tld, $this->whois->getTld($domain));
	}
	
	public function getFakeDomains()
	{
		return array
		(
			array('google.com', 'com', 'whois.internic.net'),
			array('subdomain.test.com', 'com', 'whois.internic.net'),
			array('test.co.uk', 'co.uk', 'whois.nic.uk'),
			array('test.org', 'org', 'whois.pir.org'),
			array('php.net', 'net', 'whois.internic.net'),
			array('info.info', 'info', 'whois.afilias.net'),
			array('test.org.uk', 'org.uk', 'whois.nic.uk')
		);
	}
	
	public function getValidDomains()
	{
		return array
		(
			array('google.com'),
			array('bbc.co.uk'),
			array('slashdot.org'),
			array('php.net'),
			array('info.info'),
			array('neustar.biz')
		);
	}
	
	/**
	 * @dataProvider getFakeDomains
	 * @param string $domain
	 * @param string $tld
	 * @param string $whois
	 */
	public function testGetWhoisServer($domain, $tld, $whois)
	{
		$this->assertEquals($whois, $this->whois->getWhoisServer($domain));
	}
	
	/**
     * @expectedException InvalidArgumentException
     */
	public function testDomainWithUnknownTld()
	{
		$this->whois->query('tld.that.is.unknown');
	}
}
