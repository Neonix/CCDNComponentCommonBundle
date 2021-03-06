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

namespace CCDNComponent\CommonBundle\Component\Helper;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 *
 * @category CCDNComponent
 * @package  CommonBundle
 *
 * @author   Reece Fowell <reece@codeconsortium.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 2.0
 * @link     https://github.com/codeconsortium/CCDNComponentCommonBundle
 *
 */
class RoleHelper extends ContainerAware
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
    protected $availableRoles;

    /**
     *
     * @access protected
     */
    protected $availableRoleKeys;

    /**
     *
     * @access public
     * @param ServiceContainer $serviceContainer
     */
    public function __construct($serviceContainer)
    {

        $this->container = $serviceContainer;

        $this->availableRoles = $this->container->getParameter('security.role_hierarchy.roles');

        // default role is array is empty.
        if (empty($this->availableRoles)) {
            $this->availableRoles[] = 'ROLE_USER';
        }

        // Remove the associate arrays.
        $this->availableRoleKeys = array_keys($this->availableRoles);
    }

    /**
     *
     * @access public
     * @return array $availableRoles
     */
    public function getAvailableRoles()
    {
        return $this->availableRoles;
    }

    /**
     *
     * @access public
     * @return array $availableRoles
     */
    public function getAvailableRoleKeys()
    {
        return $this->availableRoleKeys;
    }

    /**
     *
     * @access public
     * @param $user, string $role
     * @return bool
     */
    public function hasRole($user, $role)
    {
        foreach ($this->availableRoles as $aRoleKey => $aRole) {
            if ($user->hasRole($aRoleKey)) {
                if (in_array($role, $aRole) || $role == $aRoleKey) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     *
     * @access public
     * @param  array $userRoles
     * @return int   $highestUsersRoleKey
     */
    public function getUsersHighestRole($usersRoles)
    {
        $usersHighestRoleKey = 0;

        // Compare (A)vailable roles against (U)sers roles.
        foreach ($this->availableRoleKeys as $aRoleKey => $aRole) {
            foreach ($usersRoles as $uRoleKey => $uRole) {
                if ($uRole == $aRole && $aRoleKey > $usersHighestRoleKey) {
                    $usersHighestRoleKey = $aRoleKey;

                    break; // break because once uRole == aRole we know we cannot match anything else.
                }
            }
        }

        return $usersHighestRoleKey;
    }

    /**
     *
     * @access public
     * @param  array  $userRoles
     * @return string $role
     */
    public function getUsersHighestRoleAsName($usersRoles)
    {
        $usersHighestRoleKey = $this->getUsersHighestRole($usersRoles);

        $roles = $this->availableRoleKeys;

        if (array_key_exists($usersHighestRoleKey, $roles)) {
            return $roles[$usersHighestRoleKey];
        } else {
            return 'ROLE_USER';
        }
    }
}
