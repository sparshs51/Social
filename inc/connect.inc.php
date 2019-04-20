<?php
$conn = new mysqli("localhost","root","","project");
if ($conn->connect_error) {
    die("error connecting to SQL Server: " . $conn->connect_error);
} 


?>