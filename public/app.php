<?php

//Current working directory
$dir = "..";

//Autoload vendor classes
require_once "$dir/vendor/autoload.php";

//Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable($dir);
$dotenv->load();

//INCLUDES
include_once "$dir/includes/db.php";

//FUNCTIONS
include_once "$dir/functions/global.php";
include_once "$dir/functions/members.php";
include_once "$dir/functions/orders.php";
include_once "$dir/functions/recentorders.php";
include_once "$dir/functions/rings.php";
include_once "$dir/functions/prices.php";
include_once "$dir/functions/users.php";