<?php
require_once "../db.php"; require_once "../helpers.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $location = $_POST["location"]; $slottype = $_POST["slottype"]; $status = $_POST["status"];
  $maintained_by = $_POST["maintained_by"]!=="" ? (int)$_POST["maintained_by"] : null;
  if($maintained_by){
    $stmt = $conn->prepare("INSERT INTO parkingslot (Location, SlotType, Status, MaintainedBy, LastMaintenanceDate) VALUES (?,?,?,?, NOW())");
    $stmt->bind_param("sssi", $location, $slottype, $status, $maintained_by);
  } else {
    $stmt = $conn->prepare("INSERT INTO parkingslot (Location, SlotType, Status) VALUES (?,?,?)");
    $stmt->bind_param("sss", $location, $slottype, $status);
  }
  $stmt->execute();
}
redirect("../index.php?tab=slots");
?>