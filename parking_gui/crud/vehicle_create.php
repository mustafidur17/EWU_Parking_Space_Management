<?php
require_once "../db.php"; require_once "../helpers.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $plate = $_POST["plate"]; $type = $_POST["type"]; $user_id = (int)$_POST["user_id"];
  $approved_by = $_POST["approved_by"]!=="" ? (int)$_POST["approved_by"] : null;
  if($approved_by){
    $stmt = $conn->prepare("INSERT INTO vehicle (PlateNumber, Type, UserID, ApprovedBy, ApprovalDate) VALUES (?,?,?,?, NOW())");
    $stmt->bind_param("ssii", $plate, $type, $user_id, $approved_by);
  } else {
    $stmt = $conn->prepare("INSERT INTO vehicle (PlateNumber, Type, UserID) VALUES (?,?,?)");
    $stmt->bind_param("ssi", $plate, $type, $user_id);
  }
  $stmt->execute();
}
redirect("../index.php?tab=vehicles");
?>