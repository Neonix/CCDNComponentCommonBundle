<?php

/*
 * This file is part of the CCDNComponent CommonBundle
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
class UserRoleExtension extends \Twig_Extension
{

    /**
     *
     * @access protected
     */
    protected $container;

	/**
	 *
	 * @access protected
	 */
	protected $roleHelper;
	
    /**
     *
 	 * @access public
 	 * @param $roleHelper
     */
    public function __construct($roleHelper)
    {
        $this->roleHelper = $roleHelper;
    }

    /**
     *
     * @access public
     * @return Array()
     */
    public function getFunctions()
    {
        return array(
            'userRole' => new \Twig_Function_Method($this, 'userRole'),
        );
    }

    /**
     *
     * Examines the roles of the user and returns the users highest role as a string so it can be used next to usernames for emblems etc.
     *
     * @access public
     * @param $user
     * @return Int
     */
    public function userRole($user)
    {
	
		$role = $this->roleHelper->getUsersHighestRoleAsName($user->getRoles());
		
		$roleNoPrefix = str_replace('ROLE_', '', $role);
		$roleUnslugged = str_replace('_', '', $roleNoPrefix);
		
        return ucfirst(strtolower($roleUnslugged));
    }

    /**
     *
     * @access public
     * @return String
     */
    public function getName()
    {
        return 'userRole';
    }

}
