<?php

//connecteren met db via PDO
$db = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PWD']);