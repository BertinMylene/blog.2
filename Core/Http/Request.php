<?php

namespace Core\Http;

/**
 * Request
 * 
 * Get and securise superglobals GET and POST
 */
class Request
{
    private $_get;
    private $_post;
    private $_session;

    public function __construct($get = null, $post = null, $session = null)
    {
        $this->_get = isset($get) ? $get : null;
        $this->_post = isset($post) ? $post : null;
        $this->_session = isset($session) ? $session : null;
    }

    /**
     * y a t il des valeurs dans cette clé ?
     * @param mixed $key
     * 
     * @return bool
     */
    public function hasGetValue($key): bool
    {
        return isset($this->_get[$key]);
    }

    /**
     * Obtenir les valeurs de la clé passé en parametre.
     * @param mixed $key string 
     * 
     * @return [type]
     */
    public function getGetValue($key)
    {
        return isset($this->_get[$key]) ? $this->_get[$key] : null;
    }



    /**
     * Existe t il ce post ?
     * @return [type]
     */
    public function hasPost()
    {
        return !empty($this->_post);
    }

    /**
     * Obtenir les articles en fonction de la clé passée en parametre
     * @param mixed $key string clé
     * 
     * @return [type]
     */
    public function getPostValue($key)
    {
        return isset($this->_post[$key]) ? $this->_post[$key] : null;
    }

    

    /**
     * presente d'une key dans la session?
     * @param mixed $key
     * 
     * @return bool
     */
    public function hasSessionValue($key): bool
    {
        return isset($this->_session[$key]);
    }

    public function getSessionValue($key)
    {
        return isset($this->_session[$key]) ? $this->_session[$key] : null;
    }

    public function setSessionValue($key, $value)
    {
        $this->_session[$key]=$value;

    }

    public function unsetSessionValue($key)
    {
        unset($this->_session[$key]);
    }
}
