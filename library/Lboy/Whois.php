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
		'net' => 'whois.internic.net', 
		'org' => 'whois.pir.org',
		'org.uk' => 'whois.nic.uk'
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
		$tld = $this->getTld($domain);
		
		if (!array_key_exists($tld, $this->tlds))
		{
			throw new InvalidArgumentException(sprintf(
				'Could not get whois server for domain "%s" with unknown tld "%s"', 
				$domain, $tld));
		}
		
		return $this->tlds[$tld];
	}
	
	public function getTld($domain)
	{
		// look for well known TLDs first
		foreach ($this->tlds as $tld => $server)
		{
			// see if the domain ends with any known tlds
			if (substr_compare($domain, $tld, -strlen($tld), strlen($tld)) === 0)
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
		$socket = fsockopen($server, 43);
		
		if (is_resource($socket) === true)
		{
			// HACK: Internic needs an equals sign to do an exact match.
			// TODO: Refactor code to remove this hack.
			if ($server === 'whois.internic.net')
			{
				fwrite($socket, "=" . $domain . "\r\n");
			}
			else
			{
				fwrite($socket, $domain . "\r\n");
			}
			
			socket_set_timeout($socket, 5);
			$result = '';

			while (feof($socket) !== true)
			{
				$result .= fread($socket, 4096);
			}

			fclose($socket);
		}
		else
		{
			throw new Exception("Could not connect to whois server");
		}
		
		return $result;
	}
}
