<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
session_destroy();
?>
<script language="javascript">
document.location="index.php";
</script>
