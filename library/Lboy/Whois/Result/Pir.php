<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois_Result_Pir extends Lboy_Whois_Result_AbstractResult
{
	public function getExpiry()
	{
		$start = strpos($this->whois, "Expiration Date:");
		return substr($this->whois, $start + 16, 11);
	}
	
	public function getNameServers()
	{
		$lines = explode(PHP_EOL, $this->whois);
		$matching = array();
		
		foreach($lines as $line)
		{
			if (strpos($line, "Name Server:") !== false)
			{
				$server = substr(trim($line), 12);
				
				if ($server)
				{
					$matching[] = $server;
				}
			}
		}
		
		return $matching;
	}
	
	public function gotWhois()
	{
		return !$this->isLimitedExceeded() && !empty($this->whois);
	}

	public function isRateLimitExceeded()
	{
		return $this->whois == 'WHOIS LIMIT EXCEEDED';
	}
}
