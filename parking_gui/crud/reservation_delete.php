<?php
require_once "../db.php"; require_once "../helpers.php";
$id = (int)($_GET["id"] ?? 0);
if($id){ $stmt=$conn->prepare("DELETE FROM reservation WHERE ReservationID=?"); $stmt->bind_param("i",$id); $stmt->execute(); }
redirect("../index.php?tab=reservations");
?>