<?php 

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois
{
	public function query($domain)
	{
		$server = $this->getWhoisServer($domain);
		$result = new Lboy_Whois_Result_Internic($this->getResponse($domain, $server));
		return $result;
	}
	
	protected function getWhoisServer($domain)
	{
		return 'whois.internic.net';
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
