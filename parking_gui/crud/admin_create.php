<?php
require_once "../db.php"; require_once "../helpers.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $user_id = $_POST["user_id"]!=="" ? (int)$_POST["user_id"] : null;
  $name = $_POST["name"]; $email=$_POST["email"]; $phone=$_POST["phone"]; $pwd=password_hash($_POST["password"], PASSWORD_BCRYPT);
  $role=$_POST["role"];
  if($user_id){
    $stmt=$conn->prepare("INSERT INTO admin (UserID, Name, Email, Phone, Password, Role, CreatedAt) VALUES (?,?,?,?,?,?, NOW())");
    $stmt->bind_param("isssss", $user_id, $name, $email, $phone, $pwd, $role);
  } else {
    $stmt=$conn->prepare("INSERT INTO admin (Name, Email, Phone, Password, Role, CreatedAt) VALUES (?,?,?,?,?, NOW())");
    $stmt->bind_param("sssss", $name, $email, $phone, $pwd, $role);
  }
  $stmt->execute();
}
redirect("../index.php?tab=admins");
?>