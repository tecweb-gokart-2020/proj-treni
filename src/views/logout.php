<?php

require_once __DIR__ .  DIRECTORY_SEPARATOR . "../includes/resources.php";
session_start();
unset($_SESSION["username"]);
unset($_SESSION["cartID"]);
header("Location: home.php");
