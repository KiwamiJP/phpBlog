<?php
require "../config/config.php";
$stmt = $pdo->prepare("DELETE FROM users WHERE id=".$_GET['id']);
$stmt->execute();
header('Location:/Blog/admin/user_list.php');
?>