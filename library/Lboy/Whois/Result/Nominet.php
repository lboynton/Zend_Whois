<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
class Lboy_Whois_Result_Nominet extends Lboy_Whois_Result_AbstractResult
{
	public function getExpiry()
	{
		$start = strpos($this->whois, "Expiry date:");
		return substr($this->whois, $start + 14, 11);
	}
	
	public function getNameServers()
	{
		$lines = explode(PHP_EOL, $this->whois);
		$found = false;
		$servers = array();
		
		foreach($lines as $i => $line)
		{
			$line = trim($line);
			
			if (strpos($line, "Name servers:") !== false)
			{
				$found = true;
				continue;
			}
			
			if ($found)
			{
				if (empty($line))
				{
					break;
				}
			
				$servers[] = $line;
			}
		}
		
		return $servers;
	}
}
