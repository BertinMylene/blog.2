<?php

namespace Core\Auth;

use Core\Http\Request;
use Core\Database\Database;

/**
 * Manage authentication
 */
class DBAuth
{

    
    /**
     * Database connection
     * @var 
     */
    protected $database;
    private $request;
    private const KEY_AUTH='auth';


    /**
     * Database initialization
     * @param Database $database 
     */
    public function __construct(Database $database, Request $request)
    {
        $this->database = $database;
        $this->request = $request;
    }
 
    /**
     * User connection
     * @param string $pseudo
     * @param string $password
     * 
     * @return bool 
     */
    public function login(string $pseudo, string $password)
    {
        $user = $this->database->prepare('SELECT * FROM users WHERE pseudo = ?', array($pseudo), null, true);
        try {
            if ($user) {
                if ($user->password === sha1($password)) {
                    $this->request->setSessionValue(self::KEY_AUTH, $user->id);
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Check if the user is logged in
     * @return bool
     */
    public function logged()
    {
        try {
            return $this->request->hasSessionValue(self::KEY_AUTH);
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * return user id if logged in
     * @param mixed $session
     * 
     * @return bool
     */
    public function getUserId()
    {
        try {
            if ($this->logged()) {
                return $this->request->getSessionValue(self::KEY_AUTH);
            }
            return false;
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Disconnects the user
     * @return [type]
     */
    public function disconnect()
    {
        try {
            if ($this->logged()) {
                $this->request->unsetSessionValue(self::KEY_AUTH);
            }
        } catch (\Exception $e) {
            var_dump($e);
        }
    }
}
