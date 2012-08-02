<?php 

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois
{
	protected $tlds = array
	(
		'com' => 'whois.internic.net', 
		'co.uk' => 'whois.nic.uk',
		'info' => 'whois.afilias.net',
		'org' => 'whois.pir.org'
	);
	
	protected $parsers = array
	(
		'whois.afilias.net' => 'Info',
		'whois.internic.net' => 'Internic',
		'whois.nic.uk' => 'Nominet',
		'whois.pir.org' => 'Pir'
	);
	
	public function query($domain)
	{
		$server = $this->getWhoisServer($domain);
		$result = $this->getResult($this->getResponse($domain, $server), 
			$server);
		return $result;
	}
	
	public function getWhoisServer($domain)
	{
		return $this->tlds[$this->getTld($domain)];
	}
	
	public function getTld($domain)
	{
		// look for well known TLDs first
		foreach ($this->tlds as $tld => $server)
		{
			if (strpos($domain, $tld))
			{
				return $tld;
			}
		}
		
		// try to guess tld
		$start = strrpos($domain, '.');
		return substr($domain, $start + 1);
	}
	
	protected function getResult($response, $server)
	{
		$className = 'Lboy_Whois_Result_' . $this->parsers[$server];
		return new $className($response);
	}
	
	protected function getResponse($domain, $server)
	{
		$internic = fsockopen($server, 43);
		
		if (is_resource($internic) === true)
		{
			fwrite($internic, "=" . $domain . "\r\n");
			socket_set_timeout($internic, 30);
			$result = '';

			while (feof($internic) !== true)
			{
				$result .= fread($internic, 4096);
			}

			fclose($internic);
		}
		else
		{
			throw new Exception("Could not connect to whois server");
		}
		
		return $result;
	}
}
