<?php

namespace Model;

class UserModel
{
    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function register($username, $email, $password, $data_de_registro) {
        // Verifica se username ou email já existem
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false; // Já existe usuário com mesmo username ou email
        }

        // Se não existe, insere
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, data_de_registro, theme_color) VALUES (?, ?, ?, ?, 'theme-base')");
        return $stmt->execute([$username, $email, $password, $data_de_registro]);
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

//    public function getUserFromID($id)
//    {
//        $sql = "SELECT * FROM users WHERE id = ?";
//        $stmt = $this->pdo->prepare($sql);
//        $stmt->execute([$id]);
//        return $stmt->fetch(PDO::FETCH_ASSOC);
//    }

    public function updateNickname($id, $username)
    {
        $sql = "UPDATE users SET username = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$username, $id]);
    }
}

?>