<?php

$conn = new mysqli ("localhost", "root", "", "userboard");

if ($conn->connect_error) {
	die ("Database error:" . $conn->connect_error);
}