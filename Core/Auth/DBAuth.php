<?php
namespace Core\Auth;

use Core\Database;

/**
 * Gère l'authentifiaction par extraction des Users de la DB
 */
class DBAuth{

    /**
     * @var Objet \PDO $db Connection à la DB
     */
    protected $db;

    
    /**
     * Initialise la connexion à la DB (par injection de dépendance)
     * @param Database $db
     */
    public function __construct(Database $db){
        $this->db = $db;
    }

    /**
     * Permet aux User de se connecter
     * @param string $peudo
     * @param string $password
     * 
     * @return bool Selon si l'User peut se connecter ou non
     */
    public function login(string $pseudo, string $password){
        $user = $this->db->prepare('SELECT * FROM users WHERE pseudo = ?', array($pseudo), null, true);
        
        if($user){
            if($user->password === sha1($password)){
                $_SESSION['auth'] = $user->id;
                return true;
            }
        }
        return false;
    }

    /**
     * Retourne l'ID de l'utilisateur s'in est connecté
     * @return string ID de l'utilisateur
     */
    public function getUserId(){
        if($this->logged()){
            return $_SESSION['auth'];  
        }
        return false;
    }

    /**
     * Vérifie dans le $_SESSION si l'utilisateur est déjà connecté
     * @return bool
     */
    public function logged(){
            return isset($_SESSION['auth']);
        }

    /**
     * Déconnecte l'User
     */
    public function disconnect(){
        if($this->logged()){
            unset($_SESSION['auth']);
        }
    }
}