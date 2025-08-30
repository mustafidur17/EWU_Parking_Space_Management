<?php
require_once "../db.php"; require_once "../helpers.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $admin_id=(int)$_POST["admin_id"]; $actiontype=$_POST["actiontype"]; $tableaffected=$_POST["tableaffected"];
  $recordid = $_POST["recordid"]!=="" ? (int)$_POST["recordid"] : null; $actiondetails = $_POST["actiondetails"] ?? "";
  if($recordid){
    $stmt=$conn->prepare("INSERT INTO adminlog (AdminID, ActionType, TableAffected, RecordID, ActionDetails, ActionTime) VALUES (?,?,?,?,?, NOW())");
    $stmt->bind_param("issis", $admin_id, $actiontype, $tableaffected, $recordid, $actiondetails);
  } else {
    $stmt=$conn->prepare("INSERT INTO adminlog (AdminID, ActionType, TableAffected, ActionDetails, ActionTime) VALUES (?,?,?,?, NOW())");
    $stmt->bind_param("isss", $admin_id, $actiontype, $tableaffected, $actiondetails);
  }
  $stmt->execute();
}
redirect("../index.php?tab=logs");
?>