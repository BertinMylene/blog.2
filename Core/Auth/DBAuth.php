<?php

namespace Core\Auth;

use Core\Database\Database;

/**
 * Gère l'authentifiaction par extraction des Users de la DB
 */
class DBAuth
{

    /**
     * @var Objet \PDO $db Connection à la DB
     */
    protected $database;


    /**
     * Initialise la connexion à la DB (par injection de dépendance)
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Permet aux User de se connecter
     * @param string $peudo
     * @param string $password
     * 
     * @return bool Selon si l'User peut se connecter ou non
     */
    public function login(string $pseudo, string $password)
    {
        $user = $this->database->prepare('SELECT * FROM users WHERE pseudo = ?', array($pseudo), null, true);
        try {
            if ($user) {
                if ($user->password === sha1($password)) {
                    $session['auth'] = $user->id;
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Retourne l'ID de l'utilisateur s'in est connecté
     * @return string ID de l'utilisateur
     */
    public function getUserId($session)
    {
        try {
            if ($this->logged()) {
                return $session['auth'];
            }
            return false;
        } catch (\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Vérifie dans le $session si l'utilisateur est déjà connecté
     * @return bool
     */
    public function logged()
    {
        try {
            return isset($session['auth']);
        } catch (\Exception $e) {
            var_dump($e);
        }
    }
    /**
     * Déconnecte l'User
     */
    public function disconnect()
    {
        try {
            if ($this->logged()) {
                unset($session['auth']);
            }
        } catch (\Exception $e) {
            var_dump($e);
        }
    }
}
