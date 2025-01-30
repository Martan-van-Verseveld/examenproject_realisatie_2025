<?php

use App\Utility\Functions;
use App\Utility\Session;

Functions::displayError(Session::get('reset.error'));
Session::delete('reset.error');


?>


<form action="?page=formHandler" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="reset">
    <label for="email">Email:</label>
    <input type="text" name="email" placeholder="Email">
    <label for="phone">Phone:</label>
    <input type="phone" name="phone" placeholder="phone">
    <label for="password">Password:</label>
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="reset" value="Reset">
</form>