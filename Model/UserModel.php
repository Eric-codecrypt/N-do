
<?php
class UserModel
{
    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function register($username, $email, $password, $data_de_registro)
    {
        // Verificar se usuário já existe por username OU email
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $email]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            $sql = "INSERT INTO users(username, email, password, data_de_registro) VALUES (?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $email, $password, $data_de_registro]);
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password)
    {
        // Login apenas com email (mais seguro)
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getUserFromID($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateNickname($id, $username)
    {
        // Corrigir SQL - era UPDATE * (incorreto)
        $sql = "UPDATE users SET username = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$username, $id]);
    }
}
?>