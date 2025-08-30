<?php
require_once "../db.php"; require_once "../helpers.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $user_id = (int)$_POST["user_id"]; $vehicle_id = (int)$_POST["vehicle_id"]; $slot_id = (int)$_POST["slot_id"];
  $reservation_time = $_POST["reservation_time"]; $duration = (int)$_POST["duration"]; $status = $_POST["status"];
  $processed_by = $_POST["processed_by"]!=="" ? (int)$_POST["processed_by"] : null;

  if($processed_by){
    $stmt = $conn->prepare("INSERT INTO reservation (UserID, VehicleID, SlotID, ReservationTime, Duration, Status, ProcessedBy) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("iiisisi", $user_id, $vehicle_id, $slot_id, $reservation_time, $duration, $status, $processed_by);
  } else {
    $stmt = $conn->prepare("INSERT INTO reservation (UserID, VehicleID, SlotID, ReservationTime, Duration, Status) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("iiisis", $user_id, $vehicle_id, $slot_id, $reservation_time, $duration, $status);
  }
  $stmt->execute();
}
redirect("../index.php?tab=reservations");
?>