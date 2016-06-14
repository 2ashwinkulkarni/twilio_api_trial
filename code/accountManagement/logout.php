<?php
session_start();
session_destroy();
header("location:login.php");
exit();
?>

<html>
<body>
logged out
</body>
</html>