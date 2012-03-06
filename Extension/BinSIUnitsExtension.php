<?php

/*
 * This file is part of the CCDN CommonBundle
 *
 * (c) CCDN (c) CodeConsortium <http://www.codeconsortium.com/> 
 * 
 * Available on github <http://www.github.com/codeconsortium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CCDNComponent\CommonBundle\Extension;

/**
 * 
 * @author Reece Fowell <reece@codeconsortium.com> 
 * @version 1.0
 */
class BinSIUnitsExtension extends \Twig_Extension
{


	/**
	 *
	 * @access protected 
	 */
	protected $container;
	
	
	/**
	 *
	 */
	public function __construct($container)
	{
		$this->container = $container;
	}
	
	
	/**
	 * 
	 * @access public
	 * @return Array()
	 */
	public function getFunctions()
	{
		return array(
			'binSIUnits' => new \Twig_Function_Method($this, 'binSIUnits'),
		);
	}
	
	
	/**
	 * returns the requested file size in an appropriate SI Unit format.
	 *
	 * @access public
	 * @param $size
	 * @return mixed
	 */
	public function binSIUnits($size)
	{
		return $this->container->get('bin.si.units')->formatToSIUnit($size, null, true);
	}
	
	
	/**
	 *
	 * @access public
	 * @return string
	 */
	public function getName()
	{
		return 'binSIUnits';
	}
	
}