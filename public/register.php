<?php 
require_once __DIR__ . '/../src/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 2px solid #3498db;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 15px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Style pour les petites tailles d'écran */
        @media only screen and (max-width: 600px) {
            form {
                width: 80%;
            }
        }

    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../src/partials/menu.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_error.php'; ?>
    <?php require_once __DIR__ . '/../src/partials/show_success.php'; ?>

    <form action="/actions/register.php" method="post">
        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="cpassword">Confirm Password:</label>
            <input type="cpassword" name="cpassword" id="cpassword">
        </div>
        <div>
            <label for="username">Username:</label>
            <input type="username" name="username" id="username">
        </div>
        <div>
            <label for="role">Rôle :</label>
        <select name="role" id="role">
            <option value="user">Utilisateur</option>
            <option value="admin">Admin</option>
        </select>
        </div>
        <div>
            <button type="submit">Register NOW!</button>
        </div>
    </form>
</body>
</html>
