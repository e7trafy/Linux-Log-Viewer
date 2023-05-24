<?php

use App\Auth;
require_once 'vendor/autoload.php';

session_start();

if (isset($_SESSION['loggedin'])) {
     Auth::logout();

session_destroy();
}
header('Location: index.php');
exit();