<?php
session_start();
include "../functions/connections.php";

if (!isset($_SESSION['user_login'])) {
    header('Location: C:/xampp/htdocs/Internship/VolunteerProject/admin/login.php');
}

// Check if CSRF token is valid
if (isset($_GET['csrf_token_delete']) && $_GET['csrf_token_delete'] === $_SESSION['csrf_token_delete']) {
    unset($_SESSION['csrf_token_delete']);
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql = "SELECT * FROM volunteerinfos WHERE id = '$id'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        unlink("C:/xampp/htdocs/Internship/VolunteerProject/uploads/" . $row["image"]);
        $sql = "DELETE  FROM volunteerinfos WHERE id = '$id'";
        $conn->query($sql);
        header("Location: ../allVolunteers.php");
    }
} else {
    // Invalid token, redirect to error page or show an error message
    header('Location: ../error.php');
}