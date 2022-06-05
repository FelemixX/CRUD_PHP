<?php
require_once('../tables/user.php');
User::logout();
header("Location: /index.php/");