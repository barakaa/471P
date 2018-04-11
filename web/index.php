<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Login</title>
</head>
<body>
<div id="container">
    <div id="content">
        <form id="login-box" method="post" action="pscripts/login.php">
            <table>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input id="username" type="text" name="username" pattern=".{4,30}"
                        placeholder="Username" title="length at least 4, numbers/letters only"></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input id="password" type="password" name="password" pattern=".{4,30}"
                        placeholder="Password" title="length at least 4, numbers/letters only"></td>
                </tr>
                <tr>
                    <td colspan="2" class="buttons">
                        <button type="submit">Login</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="buttons">
                        <a href="register.php">Register</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>

