<?php
class Jury {
    private $db;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($db) {
        $this->db = $db;
    }

    // Fonction pour vérifier l'email et le mot de passe
    public function loginJury($email, $password) {
        // Préparation de la requête pour chercher l'admin avec l'email et le rôle 'jury'
        $sql = "SELECT * FROM admin WHERE email=:email AND role='jury'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Récupération du résultat
        $result = $stmt->fetch();

        // Vérification si l'admin existe et si le mot de passe est correct
        if ($result && password_verify($password, $result['password'])) {
            // Si les informations sont correctes, démarrer une session et stocker l'ID du jury
            session_start();  // Démarre la session
            $_SESSION['jury_id'] = $result['id'];  // Stocke l'ID du jury dans la session
            $_SESSION['jury_email'] = $result['email'];  // Stocke l'email du jury dans la session

            // Retourner un message de succès pour le frontend
            return ['success' => true, 'message' => 'Connexion réussie'];
        } else {
            // Si l'email ou le mot de passe sont incorrects
            return ['success' => false, 'message' => 'Email ou mot de passe incorrect'];
        }
    }

    // Fonction pour vérifier si le jury est connecté
    public function isJuryLoggedIn() {
        // Vérifie si l'ID du jury existe dans la session
        return isset($_SESSION['jury_id']);
    }

    // Fonction pour déconnecter le jury
    public function logout() {
        // Détruire la session pour déconnecter le jury
        session_start();
        session_unset();
        session_destroy();
    }
}
?>
