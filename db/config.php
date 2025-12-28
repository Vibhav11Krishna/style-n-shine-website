<?php
$conn = new mysqli("localhost", "root", "", "salon");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>