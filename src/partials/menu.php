<nav>
    <p><a href="/">Home</a></p>
    <?php
    if ($user === false) { ?>
    <p><a href="/register.php">Register</a></p>
    <p><a href="/login.php">Login</a></p>
    <?php } else { ?>
        <p><a href="/actions/logout.php">Log OUT</a></p>
    <?php } ?>
</nav>
<style>
        nav {
            text-align: center;
            margin-top: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            margin: 0 20px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #3498db;
        }
    </style>
