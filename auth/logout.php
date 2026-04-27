<?php
session_start();
session_destroy();
header('Location: /gestion_chambres/auth/login.php');
exit;
