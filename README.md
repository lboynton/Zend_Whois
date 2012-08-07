Zend_Whois
==========

Zend Framework-style whois component. Domains with the following TLDs can be queried:

* .biz
* .com
* .co.uk
* .info
* .net
* .org
* .org.uk

Usage
----------
Currently it is possible to get the domain expiry date and domain nameservers.

	$whois = new Lboy_Whois();
	$result = $whois->query('google.com');
	
	// get domain expiry date
	$result->getExpiry();

	// get array of domain nameservers
	$result->getNameServers();