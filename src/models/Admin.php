<?php
class Admin {
    private $db;
    
    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($db) {
        $this->db = $db;
    }

    // Fonction pour vérifier l'email et le mot de passe
    public function loginAdmin($email, $password) {
        // Préparation de la requête pour chercher l'admin avec l'email
        $sql = "SELECT * FROM admin WHERE email=:email AND role='admin'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Récupération du résultat
        $result = $stmt->fetch();

        // Vérification si l'admin existe et si le mot de passe est correct
        if ($result && password_verify($password, $result['password'])) {
            // Si les informations sont correctes, démarrer une session et stocker l'ID de l'admin
            session_start();
            $_SESSION['admin_id'] = $result['id'];  // Stocke l'ID de l'admin dans la session
            $_SESSION['admin_email'] = $result['email'];  // Stocke l'email de l'admin dans la session

            // Optionnel : retourner une réponse pour indiquer une connexion réussie
            return true;
        } else {
            // Si l'email ou le mot de passe sont incorrects
            return false;
        }
    }

    // Fonction pour vérifier si l'admin est connecté
    public function isAdminLoggedIn() {
        // Vérifie si l'ID de l'admin existe dans la session
        return isset($_SESSION['admin_id']);
    }

    // Fonction pour déconnecter l'admin
    public function logout() {
        // Détruire la session pour déconnecter l'admin
        session_start();
        session_unset();
        session_destroy();
    }
}
?>
