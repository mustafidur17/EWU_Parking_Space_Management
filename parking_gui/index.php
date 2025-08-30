<?php
require_once "db.php";
require_once "helpers.php";

$tab = $_GET["tab"] ?? "users";
$validTabs = ["users","vehicles","slots","reservations","admins","logs"];
if (!in_array($tab,$validTabs)) $tab = "users";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>🚗 EWU Parking Space Management</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #222;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .topbar {
      width: 100%;
      background: #e0e7ff;
      padding: 40px 0 0 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      box-shadow: 0 2px 16px #c7d2fe55;
    }
    .topbar h1 {
      font-size: 2.2rem;
      color: #000; /* Changed to black */
      letter-spacing: 2px;
      text-shadow: 0 2px 8px #c7d2fe;
      margin-bottom: 32px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
      justify-content: center;
    }
    .tabs {
      display: flex;
      flex-direction: row;
      gap: 18px;
      margin-bottom: 32px;
      justify-content: center;
    }
    .tabs a {
      padding: 14px 36px;
      background: #fff;
      border-radius: 18px;
      text-decoration: none;
      color: #2563eb;
      font-weight: 500;
      box-shadow: 0 2px 8px #e0e7ff;
      transition: background 0.2s, color 0.2s;
      border: 2px solid #2563eb22;
      font-size: 1.15em;
      display: block;
      text-align: center;
    }
    .tabs a.active, .tabs a:hover {
      background: #2563eb;
      color: #fff;
      border-color: #2563eb;
    }
    .main-content {
      flex: 1;
      padding: 48px 0 0 0;
      min-width: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .card {
      background: #fff;
      margin: 0 auto 30px auto;
      padding: 32px 36px;
      border-radius: 18px;
      box-shadow: 0 4px 24px #c7d2fe55;
      max-width: 1100px;
      min-width: 350px;
      animation: fadeIn 0.7s;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px);}
      to { opacity: 1; transform: translateY(0);}
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
      background: #f1f5f9;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px #e0e7ff;
    }
    th, td {
      padding: 14px 10px;
      text-align: left;
      border-bottom: 1px solid #e5e7eb;
    }
    th {
      background: #2563eb;
      color: #fff;
      font-weight: 600;
      letter-spacing: 1px;
    }
    tr:hover td {
      background: #e0e7ff;
      transition: background 0.2s;
    }
    .badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 12px;
      background: #2563eb22;
      color: #2563eb;
      font-size: 0.95em;
      font-weight: 500;
      margin-right: 2px;
    }
    .actions a {
      color: #ef4444;
      background: #fee2e2;
      padding: 6px 14px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      margin-right: 6px;
      transition: background 0.2s, color 0.2s;
    }
    .actions a:hover {
      background: #ef4444;
      color: #fff;
    }
    form {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      margin-top: 12px;
      align-items: left;
    }
    form input, form select, form textarea {
      padding: 10px 12px;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
      font-size: 1em;
      background: #f8fafc;
      transition: border 0.2s;
      min-width: 180px;
      margin-bottom: 8px;
    }
    form input:focus, form select:focus, form textarea:focus {
      border-color: #2563eb;
      outline: none;
    }
    form button {
      background: #2563eb;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 10px 24px;
      font-size: 1em;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
      margin-top: 8px;
    }
    form button:hover {
      background: #1e40af;
    }
    .small {
      font-size: 0.98em;
      color: #64748b;
      margin-bottom: 10px;
    }
    .notice {
      background: #fef9c3;
      color: #92400e;
      padding: 8px 16px;
      border-radius: 8px;
      margin-top: 10px;
      font-size: 0.98em;
      border: 1px dashed #facc15;
      margin-bottom: 10px;
    }
    footer {
      text-align: center;
      margin: 40px 0 20px 0;
      color: #64748b;
      font-size: 1em;
    }
    @media (max-width: 900px) {
      .topbar h1 { font-size: 1.1rem;}
      .tabs { gap: 8px; }
      .main-content { padding: 8px 0 0 0;}
      .card { padding: 18px 8px; }
      table th, table td { padding: 8px 4px; font-size: 0.98em;}
      form input, form select, form textarea { min-width: 120px; }
    }
  </style>
</head>
<body>
  <div class="topbar">
    <h1>🚗 EWU Parking Space Management</h1>
    <div class="tabs">
      <?php foreach($validTabs as $t): ?>
        <a class="<?= $tab===$t?'active':'' ?>" href="?tab=<?= $t ?>"><?= ucfirst($t) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="main-content">
    <?php if($tab==="users"): ?>
    <div class="card">
      <h2>Users</h2>
      <div class="small">Roles: Student, Faculty, Staff</div>
      <table>
        <tr><th>UserID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Actions</th></tr>
        <?php
        $res = $conn->query("SELECT * FROM user ORDER BY UserID DESC");
        while($r = $res->fetch_assoc()){ ?>
          <tr>
            <td><?= safe($r["UserID"]) ?></td>
            <td><?= safe($r["Name"]) ?></td>
            <td><?= safe($r["Email"]) ?></td>
            <td><?= safe($r["Phone"]) ?></td>
            <td><span class="badge"><?= safe($r["Role"]) ?></span></td>
            <td class="actions">
              <a href="crud/user_delete.php?id=<?= (int)$r["UserID"] ?>" onclick="return confirm('Delete this user?')">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </table>

      <h3>Add User</h3>
      <form method="post" action="crud/user_create.php">
        <input name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input name="phone" placeholder="Phone" required>
        <select name="role" required>
          <option value="Student">Student</option>
          <option value="Faculty">Faculty</option>
          <option value="Staff">Staff</option>
        </select>
        <button type="submit">Add User</button>
      </form>
    </div>
    <?php endif; ?>

    <?php if($tab==="vehicles"): ?>
    <div class="card">
      <h2>Vehicles</h2>
      <table>
        <tr><th>VehicleID</th><th>Plate</th><th>Type</th><th>User</th><th>Approved By</th><th>ApprovalDate</th><th>Actions</th></tr>
        <?php
        $sql = "SELECT v.*, u.Name AS UserName, a.Name AS AdminName
                FROM vehicle v
                JOIN user u ON u.UserID = v.UserID
                LEFT JOIN admin a ON a.AdminID = v.ApprovedBy
                ORDER BY v.VehicleID DESC";
        $res = $conn->query($sql);
        while($r = $res->fetch_assoc()){ ?>
          <tr>
            <td><?= safe($r["VehicleID"]) ?></td>
            <td><?= safe($r["PlateNumber"]) ?></td>
            <td><?= safe($r["Type"]) ?></td>
            <td><?= safe($r["UserName"]) ?></td>
            <td><?= $r["AdminName"] ? safe($r["AdminName"]) : '<span class="badge" style="background:#fee2e2;color:#92400e;">Not Approved</span>' ?></td>
            <td><?= $r["ApprovalDate"] ? safe($r["ApprovalDate"]) : '<span class="badge" style="background:#fee2e2;color:#92400e;">N/A</span>' ?></td>
            <td class="actions">
              <a href="crud/vehicle_delete.php?id=<?= (int)$r["VehicleID"] ?>" onclick="return confirm('Delete this vehicle?')">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </table>

      <h3>Add Vehicle</h3>
      <form method="post" action="crud/vehicle_create.php">
        <input name="plate" placeholder="Plate Number" required>
        <input name="type" placeholder="Type (e.g., Car, Bike)" required>
        <select name="user_id" required>
          <option value="">— Select User —</option>
          <?php $u = $conn->query("SELECT UserID, Name FROM user ORDER BY Name");
          while($x = $u->fetch_assoc()){ ?>
            <option value="<?= (int)$x["UserID"] ?>"><?= safe($x["Name"]) ?></option>
          <?php } ?>
        </select>
        <select name="approved_by">
          <option value="">— Approved By (optional) —</option>
          <?php $a = $conn->query("SELECT AdminID, Name FROM admin ORDER BY Name");
          while($y = $a->fetch_assoc()){ ?>
            <option value="<?= (int)$y["AdminID"] ?>"><?= safe($y["Name"]) ?></option>
          <?php } ?>
        </select>
        <button type="submit">Add Vehicle</button>
      </form>
      <div class="notice small">ApprovalDate is set to NOW() automatically if ApprovedBy is provided.</div>
    </div>
    <?php endif; ?>

    <?php if($tab==="slots"): ?>
    <div class="card">
      <h2>Parking Slots</h2>
      <table>
        <tr><th>SlotID</th><th>Location</th><th>SlotType</th><th>Status</th><th>MaintainedBy</th><th>LastMaintenanceDate</th><th>Actions</th></tr>
        <?php
        $sql = "SELECT s.*, a.Name AS AdminName FROM parkingslot s
                LEFT JOIN admin a ON a.AdminID = s.MaintainedBy
                ORDER BY s.SlotID DESC";
        $res = $conn->query($sql);
        while($r = $res->fetch_assoc()){ ?>
          <tr>
            <td><?= safe($r["SlotID"]) ?></td>
            <td><?= safe($r["Location"]) ?></td>
            <td><span class="badge"><?= safe($r["SlotType"]) ?></span></td>
            <td><span class="badge"><?= safe($r["Status"]) ?></span></td>
            <td><?= safe($r["AdminName"]) ?></td>
            <td><?= safe($r["LastMaintenanceDate"]) ?></td>
            <td class="actions">
              <a href="crud/slot_delete.php?id=<?= (int)$r["SlotID"] ?>" onclick="return confirm('Delete this slot?')">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </table>

      <h3>Add Parking Slot</h3>
      <form method="post" action="crud/slot_create.php">
        <input name="location" placeholder="Location" required>
        <select name="slottype" required>
          <option value="General">General</option>
          <option value="Reserved">Reserved</option>
          <option value="Handicapped">Handicapped</option>
        </select>
        <select name="status" required>
          <option value="Available">Available</option>
          <option value="Occupied">Occupied</option>
        </select>
        <select name="maintained_by">
          <option value="">— Maintained By (optional) —</option>
          <?php $a = $conn->query("SELECT AdminID, Name FROM admin ORDER BY Name");
          while($y = $a->fetch_assoc()){ ?>
            <option value="<?= (int)$y["AdminID"] ?>"><?= safe($y["Name"]) ?></option>
          <?php } ?>
        </select>
        <button type="submit">Add Slot</button>
      </form>
    </div>
    <?php endif; ?>

    <?php if($tab==="reservations"): ?>
    <div class="card">
      <h2>Reservations</h2>
      <table>
        <tr><th>ReservationID</th><th>User</th><th>Vehicle</th><th>Slot</th><th>ReservationTime</th><th>Duration</th><th>Status</th><th>ProcessedBy</th><th>Actions</th></tr>
        <?php
        $sql = "SELECT r.*, u.Name AS UserName, v.PlateNumber AS Plate, s.Location AS SlotLoc, a.Name AS AdminName
                FROM reservation r
                JOIN user u ON u.UserID = r.UserID
                JOIN vehicle v ON v.VehicleID = r.VehicleID
                JOIN parkingslot s ON s.SlotID = r.SlotID
                LEFT JOIN admin a ON a.AdminID = r.ProcessedBy
                ORDER BY r.ReservationID DESC";
        $res = $conn->query($sql);
        while($r = $res->fetch_assoc()){ ?>
          <tr>
            <td><?= safe($r["ReservationID"]) ?></td>
            <td><?= safe($r["UserName"]) ?></td>
            <td><?= safe($r["Plate"]) ?></td>
            <td><?= safe($r["SlotLoc"]) ?></td>
            <td><?= safe($r["ReservationTime"]) ?></td>
            <td><?= safe($r["Duration"]) ?> min</td>
            <td><span class="badge"><?= safe($r["Status"]) ?></span></td>
            <td><?= safe($r["AdminName"]) ?></td>
            <td class="actions">
              <a href="crud/reservation_delete.php?id=<?= (int)$r["ReservationID"] ?>" onclick="return confirm('Delete this reservation?')">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </table>

      <h3>Add Reservation</h3>
      <form method="post" action="crud/reservation_create.php">
        <select name="user_id" required>
          <option value="">— Select User —</option>
          <?php $u = $conn->query("SELECT UserID, Name FROM user ORDER BY Name");
          while($x = $u->fetch_assoc()){ ?>
            <option value="<?= (int)$x["UserID"] ?>"><?= safe($x["Name"]) ?></option>
          <?php } ?>
        </select>
        <select name="vehicle_id" required>
          <option value="">— Select Vehicle —</option>
          <?php $v = $conn->query("SELECT VehicleID, PlateNumber FROM vehicle ORDER BY VehicleID DESC");
          while($x = $v->fetch_assoc()){ ?>
            <option value="<?= (int)$x["VehicleID"] ?>"><?= safe($x["PlateNumber"]) ?></option>
          <?php } ?>
        </select>
        <select name="slot_id" required>
          <option value="">— Select Slot —</option>
          <?php $s = $conn->query("SELECT SlotID, Location FROM parkingslot ORDER BY SlotID DESC");
          while($x = $s->fetch_assoc()){ ?>
            <option value="<?= (int)$x["SlotID"] ?>"><?= safe($x["Location"]) ?></option>
          <?php } ?>
        </select>
        <input type="datetime-local" name="reservation_time" required>
        <input type="number" name="duration" placeholder="Duration (minutes)" required>
        <select name="status" required>
          <option value="Confirmed">Confirmed</option>
          <option value="Cancelled">Cancelled</option>
          <option value="Completed">Completed</option>
        </select>
        <select name="processed_by">
          <option value="">— Processed By (optional) —</option>
          <?php $a = $conn->query("SELECT AdminID, Name FROM admin ORDER BY Name");
          while($x = $a->fetch_assoc()){ ?>
            <option value="<?= (int)$x["AdminID"] ?>"><?= safe($x["Name"]) ?></option>
          <?php } ?>
        </select>
        <button type="submit">Add Reservation</button>
      </form>
    </div>
    <?php endif; ?>

    <?php if($tab==="admins"): ?>
    <div class="card">
      <h2>Admins</h2>
      <table>
        <tr><th>AdminID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>CreatedAt</th><th>LastLogin</th><th>Actions</th></tr>
        <?php
        $sql = "SELECT * FROM admin ORDER BY AdminID DESC";
        $res = $conn->query($sql);
        while($r = $res->fetch_assoc()){ ?>
          <tr>
            <td><?= safe($r["AdminID"]) ?></td>
            <td><?= safe($r["Name"]) ?></td>
            <td><?= safe($r["Email"]) ?></td>
            <td><?= safe($r["Phone"]) ?></td>
            <td><span class="badge"><?= safe($r["Role"]) ?></span></td>
            <td><?= safe($r["CreatedAt"]) ?></td>
            <td><?= safe($r["LastLogin"]) ?></td>
            <td class="actions">
              <a href="crud/admin_delete.php?id=<?= (int)$r["AdminID"] ?>" onclick="return confirm('Delete this admin?')">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </table>

      <h3>Add Admin</h3>
      <form method="post" action="crud/admin_create.php">
        <input name="name" placeholder="Admin Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input name="phone" placeholder="Phone" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
          <option value="SuperAdmin">SuperAdmin</option>
          <option value="ParkingAdmin">ParkingAdmin</option>
          <option value="Support">Support</option>
        </select>
        <button type="submit">Add Admin</button>
      </form>
    </div>
    <?php endif; ?>

    <?php if($tab==="logs"): ?>
    <div class="card">
      <h2>Admin Logs</h2>
      <table>
        <tr><th>LogID</th><th>Admin</th><th>ActionType</th><th>TableAffected</th><th>RecordID</th><th>ActionDetails</th><th>ActionTime</th><th>Actions</th></tr>
        <?php
        $sql = "SELECT l.*, a.Name AS AdminName FROM adminlog l
                LEFT JOIN admin a ON a.AdminID = l.AdminID
                ORDER BY l.LogID DESC";
        $res = $conn->query($sql);
        while($r = $res->fetch_assoc()){ ?>
          <tr>
            <td><?= safe($r["LogID"]) ?></td>
            <td><?= safe($r["AdminName"]) ?></td>
            <td><span class="badge"><?= safe($r["ActionType"]) ?></span></td>
            <td><?= safe($r["TableAffected"]) ?></td>
            <td><?= safe($r["RecordID"]) ?></td>
            <td><?= safe($r["ActionDetails"]) ?></td>
            <td><?= safe($r["ActionTime"]) ?></td>
            <td class="actions">
              <a href="crud/log_delete.php?id=<?= (int)$r["LogID"] ?>" onclick="return confirm('Delete this log?')">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </table>

      <h3>Add Admin Log</h3>
      <form method="post" action="crud/log_create.php">
        <select name="admin_id" required>
          <option value="">— Select Admin —</option>
          <?php $a = $conn->query("SELECT AdminID, Name FROM admin ORDER BY Name");
          while($x = $a->fetch_assoc()){ ?>
            <option value="<?= (int)$x["AdminID"] ?>"><?= safe($x["Name"]) ?></option>
          <?php } ?>
        </select>
        <select name="actiontype" required>
          <option value="Create">Create</option>
          <option value="Read">Read</option>
          <option value="Update">Update</option>
          <option value="Delete">Delete</option>
        </select>
        <input name="tableaffected" placeholder="TableAffected (e.g., user)" required>
        <input type="number" name="recordid" placeholder="RecordID">
        <textarea class="full" name="actiondetails" placeholder="Details"></textarea>
        <button type="submit">Add Log</button>
      </form>
    </div>
    <?php endif; ?>

    <footer class="small">
      EWU Parking Space Management. All rights reserved. 2025
    </footer>