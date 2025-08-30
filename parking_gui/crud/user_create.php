<?php
require_once "../db.php"; require_once "../helpers.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $stmt = $conn->prepare("INSERT INTO user (Name, Email, Phone, Role) VALUES (?,?,?,?)");
  $stmt->bind_param("ssss", $_POST["name"], $_POST["email"], $_POST["phone"], $_POST["role"]);
  $stmt->execute();
}
redirect("../index.php?tab=users");
?>