<?php
    session_start();
    require_once '../config.php';
    function setStatut($pdo, $userId) {
        $requete = $pdo->prepare("UPDATE users SET statut = 'offline' WHERE id = :userId");
        $requete->bindParam(':userId', $userId);
        $requete->execute();
    }
    global $pdo;
    setStatut($pdo, $_SESSION['id']);
    session_destroy();
    header('Location:../../auth/login/login.php');
?>