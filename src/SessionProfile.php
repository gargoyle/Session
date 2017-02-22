<?php

namespace Pmc\Session;

/**
 * A session profile identifies a user of the system by id, username and also provides
 * the "roles" that user has for checking against a compatible ACL.
 * 
 * @author Gargoyle <g@rgoyle.com>
 */
class SessionProfile
{

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $userId;

       
    
    public function __construct(string $userId, string $username, array $roles)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->roles = $roles;
    }
    
    public function userId() : string
    {
        return $this->userId;
    }
    
    public function username() : string
    {
        return $this->username;
    }
    
    public function roles() : array
    {
        return $this->roles;
    }
    
    public function hasRole(string $roleToCheck) : bool
    {
        foreach ($this->roles as $role) {
            if ($roleToCheck === $role) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Create a valid (but bad) profile.
     * 
     * Used to identify when something has gone wrong with a stored profile, but to
     * allow the data to continue to be processed.
     * 
     * @return \self
     */
    public static function badProfile() : self
    {
        return new self('2', 'Bad Profile', []);
    }
    
    /**
     * Create a guest profile
     * 
     * The default profile which should be used whenever no other profile is available.
     * 
     * @return \self
     */
    public static function guestProfile() : self
    {
        return new self('1', 'Guest', ['Guest']);
    }
}
