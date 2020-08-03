<?php

session_start();
session_destroy();

header("location: /iDiscuss/index.php");

?>