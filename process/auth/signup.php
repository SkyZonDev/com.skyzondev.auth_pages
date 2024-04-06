<?php
    require_once '../config.php';
    function checkUser($id) {
        global $pdo;
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $id, PDO::PARAM_STR);
        $stmt->execute(); 
        return $stmt->rowCount() > 0 ? true : false;
    }
    function checkEmail($id) {
        global $pdo;
        // Vérifiez si le nom d'utilisateur existe déjà dans la base de données
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $id, PDO::PARAM_STR);
        $stmt->execute();    
        return $stmt->rowCount() > 0 ? true : false;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recover the request data 
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
    
        // Valide data
        if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
            $response['message'] = "invalid";
            $response['description'] = "All fields are required.";
        } else if (checkUser($username)) {
            $response['message'] = "invalid";
            $response['description'] = "Username already exist.";
        } else {
            // Valide email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = "invalid";
                $response['description'] = "Invalid email.";
            } else if (checkEmail($email)) { 
                $response['message'] = "invalid";
                $response['description'] = "Email already exist.";
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Prepare and execute the SQL request for the insert 
                $stmt = $pdo->prepare("INSERT INTO users (username, fullname, email, password) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$username, $fullname, $email, $hashedPassword])) {


                    // Automatic login after the sign up 
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                    $stmt->execute([$username]);
                    $user = $stmt->fetch();
 
                    if ($user) {
                        session_start();
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['firstname'] = $user['firstname'];
                        $_SESSION['lastname'] = $user['lastname'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['email'] = $user['email'];
                        $response['message'] = "valid";
                    } else {
                        $response['message'] = "invalid";
                        $response['description'] = "Error connecting automatically.";
                    }
                } else {
                    $response['message'] = "invalid";
                    $response['description'] = "Error during registration.";
                }
            }
        }
    }
    // Resend the response in the form of JSON data
    echo json_encode($response);
?>