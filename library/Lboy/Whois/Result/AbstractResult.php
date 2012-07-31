<?php

/**
 * @link http://github.com/lboynton/Zend_Whois for the canonical source repository
 * @copyright (c) 2012, Lee Boynton
 * @author Lee Boynton <lee@lboynton.com>
 */
abstract class Lboy_Whois_Result_AbstractResult
{
	protected $whois;
	
	public function __construct($result)
	{
		$this->whois = $result;
	}
	
	public abstract function getExpiry();
	
	public function toString()
	{
		return $this->whois;
	}
}
