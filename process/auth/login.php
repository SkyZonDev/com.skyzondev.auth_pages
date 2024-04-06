<?php
    session_start();
    require_once '../config.php';
    $response = array();
    // Chech if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        global $pdo;
        // Recover the request data 
        $usernameOrEmail = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        // Valide data
        if (empty($usernameOrEmail) || empty($password)) {
            $response['message'] = "Tous les champs sont obligatoires.";
        } else {
            // Search user in the database by username or email
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(':username', $usernameOrEmail, PDO::PARAM_STR);
            $stmt->bindParam(':email', $usernameOrEmail, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            // Check if the user exist and if the password is correct
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['description'] = $user['description'];
                $_SESSION['profilepict'] = $user['profilepict'];
                $_SESSION['follower'] = $user['follower'];
                $_SESSION['following'] = $user['following'];
                $_SESSION['oauth'] = $user['oauth'];
                $_SESSION['certif'] = $user['certif'];
                $response['message'] = "valid";
            } else {
                $response['message'] = "invalid";
            }
        }
    }

    // Resend the response in the form of JSON data
    echo json_encode($response);
?>
