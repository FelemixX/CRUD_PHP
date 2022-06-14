<?php
require_once('../tables/user.php');
User::logout();
session_destroy();
header("Location: /index.php/");