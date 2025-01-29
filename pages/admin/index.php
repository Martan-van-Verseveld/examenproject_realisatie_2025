<?php // check if admin 
if ($_GET['page'] === 'admin.index') {
    header("Location: ?page=admin.home");
}

?>