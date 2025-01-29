<form action="?page=formHandler" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="register">
    <label for="username">Username:</label>
    <input type="text" name="username" placeholder="Username">
    <label for="firstname">Voornaam:</label>
    <input type="text" name="firstname" placeholder="voornaam">
    <label for="lastname">Achternaam:</label>
    <input type="text" name="lastname" placeholder="achternaam">
    <label for="adres">Adres:</label>
    <input type="text" name="adres" placeholder="adres">
    <label for="city">Plaats:</label>
    <input type="text" name="city" placeholder="plaats">
    <label for="phone">Telefoon:</label>
    <input type="phone" name="phone" placeholder="telefoon">
    <label for="email">Email:</label>
    <input type="email" name="email" placeholder="email">
    <label for="password">Password:</label>
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="register" value="Register">
</form>