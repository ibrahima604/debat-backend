<?php
// Inclure la configuration de la base de données et le modèle Jury
include_once 'config/Database.php';
include_once 'models/Jury.php';

class JuryController {
    private $db;
    private $jury;

    public function __construct() {
        // Créer une instance de la base de données
        $database = new Database();
        $this->db = $database->getConnection();

        // Créer une instance de la classe Jury avec la connexion à la base de données
        $this->jury = new Jury($this->db);
    }

    // Méthode pour gérer la connexion du jury
    public function login() {
        // Récupérer les données envoyées en POST
        $data = json_decode(file_get_contents("php://input"));

        // Vérifier si les données sont valides
        if (!isset($data->email) || !isset($data->password)) {
            echo json_encode(['success' => false, 'message' => 'Email et mot de passe sont requis']);
            return;
        }

        $email = $data->email;
        $password = $data->password;

        // Appeler la méthode loginJury du modèle Jury
        $result = $this->jury->loginJury($email, $password);

        // Vérifier le résultat et retourner la réponse appropriée
        if ($result) {
            // Connexion réussie, retourner une réponse JSON avec un succès
            echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
        } else {
            // Connexion échouée, retourner une réponse JSON avec une erreur
            echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
        }
    }

    // Méthode pour vérifier si le jury est connecté
    public function isLoggedIn() {
        if ($this->jury->isJuryLoggedIn()) {
            // Jury connecté
            echo json_encode(['success' => true, 'message' => 'Jury connecté']);
        } else {
            // Jury non connecté
            echo json_encode(['success' => false, 'message' => 'Jury non connecté']);
        }
    }

    // Méthode pour déconnecter le jury
    public function logout() {
        $this->jury->logout();
        echo json_encode(['success' => true, 'message' => 'Déconnexion réussie']);
    }
}
?>
