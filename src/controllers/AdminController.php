<?php
// Inclure le modèle Admin et la configuration de la base de données
include_once 'config/Database.php';
include_once 'models/Admin.php';

class AdminController {
    private $db;
    private $admin;

    public function __construct() {
        // Créer une instance de la base de données
        $database = new Database();
        $this->db = $database->getConnection();

        // Créer une instance de la classe Admin avec la connexion à la base de données
        $this->admin = new Admin($this->db);
    }

    // Méthode pour gérer la connexion de l'admin
    public function login() {
        // Récupérer les données envoyées en POST
        $data = json_decode(file_get_contents("php://input"));
        $email = $data->email;
        $password = $data->password;

        // Appeler la méthode loginAdmin du modèle Admin
        $result = $this->admin->loginAdmin($email, $password);

        // Vérifier le résultat et retourner la réponse appropriée
        if ($result) {
            // Connexion réussie, retourner une réponse JSON avec un succès
            echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
        } else {
            // Connexion échouée, retourner une réponse JSON avec une erreur
            echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
        }
    }

    // Méthode pour vérifier si l'admin est connecté
    public function isLoggedIn() {
        if ($this->admin->isAdminLoggedIn()) {
            // Admin connecté
            echo json_encode(['success' => true, 'message' => 'Admin connecté']);
        } else {
            // Admin non connecté
            echo json_encode(['success' => false, 'message' => 'Admin non connecté']);
        }
    }

    // Méthode pour déconnecter l'admin
    public function logout() {
        $this->admin->logout();
        echo json_encode(['success' => true, 'message' => 'Déconnexion réussie']);
    }
}
?>
