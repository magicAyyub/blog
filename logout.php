<?php

require('class/constants.php');
session_unset();
session_destroy();

header('location: '. ROOT_URL.'home.php');
die();

?>