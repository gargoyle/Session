<?php

namespace Pmc\Session;

use InvalidArgumentException;

/**
 * A "session" represents the actions from a single "user" interacting with the 
 * system. It includes a session identifier, and basic user information.
 *
 * @author Gargoyle <g@rgoyle.com>
 */
class Session
{
    private $sessionId;
    private $profile;
    private $sourceIp;
    
    public function __construct(string $sessionId)
    {
        $this->sessionId = $sessionId;
        $this->profile = SessionProfile::guestProfile();
        $this->sourceIp = (string)$_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    }
    
    public function setProfile(SessionProfile $profile)
    {
        $this->profile = $profile;
    }
    
    public function profile() : SessionProfile
    {
        return $this->profile;
    }
    
    public function roles() : array
    {
        return $this->profile->roles();
    }
    
    public function sourceIp() : string
    {
        return $this->sourceIp;
    }
    
    public function toArray() : array
    {
        return [
            'sessionId' => $this->sessionId,
            'sourceIp' => $this->sourceIp,
            'userId' => $this->profile->userId(),
            'username' => $this->profile->username(),
            'roles' => $this->profile->roles()
        ];
    }
    
    /**
     * 
     * @param array $data
     * @return Session
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data)
    {
        if (!isset($data['sessionId'])) {
            throw new InvalidArgumentException('Data array must include "sessionId" key');
        }
        $session = new self($data['sessionId']);
        $session->sourceIp = $data['sourceIp'] ?? null;
        
        if (isset($data['userId']) && isset($data['username']) && isset($data['roles']) && is_array($data['roles'])) {
            $session->profile = new SessionProfile($data['userId'], $data['username'], $data['roles']);
        } else {
            $session->profile = SessionProfile::badProfile();
        }
                
        return $session;
    }
}
