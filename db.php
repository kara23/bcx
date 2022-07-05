<?php
$connect = new mysqli("localhost","azaniasystems_bcx","bcUAXG6DaLJvAaK","azaniasystems_bcx");

// Check connection
if ($connect -> connect_errno) {
  echo "Failed to connect to MySQL: " . $connect -> connect_error;
  exit();
}

?>