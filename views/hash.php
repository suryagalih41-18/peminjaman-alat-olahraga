<?php

$password = "petugas123";

$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: " . $password . "<br><br>";
echo "Hash:<br>";
echo $hash;