<?php
include('config.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password === $confirm) {
        if (strlen($password) >= 8 && strlen($password) <= 20 &&
            preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password)) {

            $hashed_password = md5($password); // You might consider using password_hash() instead

            $query = "INSERT INTO users(username, password) VALUES('$username','$hashed_password')";
            if (mysqli_query($conn, $query)) {
                $message = '<p class="success">Registration Successful!</p>';
            } else {
                $message = '<p class="error">Error: ' . mysqli_error($conn) . '</p>';
            }
        } else {
            $message = '<p class="error">Password must be 8–20 characters long and contain letters and numbers.</p>';
        }
    } else {
        $message = '<p class="error">Passwords do not match!</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.15); /* semi-transparent white */
            backdrop-filter: blur(10px); /* frosted blur effect */
            -webkit-backdrop-filter: blur(10px); /* Safari support */
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 30px 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: 0.3s;
        }

        input:focus {
            border-color: #4caf50;
            outline: none;
        }

        .feedback {
            font-size: 0.9em;
            margin-top: -5px;
            margin-bottom: 10px;
        }

        .error {
            color: #e74c3c;
        }

        .success {
            color: #2ecc71;
        }

        button {
            width: 100%;
            background-color: #4caf50;
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
        p {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9em;
        }

        a {
            color: #4caf50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        @media (max-width: 500px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration</h2>
        
        <?php echo $message; ?>

        <form method="POST" action="" id="registrationForm" novalidate>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <div id="passwordFeedback" class="feedback"></div>

            <label for="confirm">Confirm Password</label>
            <input type="password" name="confirm" id="confirm" required>
            <div id="confirmFeedback" class="feedback"></div>

            <button type="submit" name="register">Register</button>
            <p>Don't have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm');
        const passwordFeedback = document.getElementById('passwordFeedback');
        const confirmFeedback = document.getElementById('confirmFeedback');
        const form = document.getElementById('registrationForm');

        function validatePassword() {
            const password = passwordInput.value;
            const hasLetter = /[A-Za-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const lengthOk = password.length >= 8 && password.length <= 20;

            if (!lengthOk) {
                passwordFeedback.textContent = 'Password must be 8–20 characters long.';
                passwordFeedback.className = 'feedback error';
                return false;
            } else if (!hasLetter || !hasNumber) {
                passwordFeedback.textContent = 'Password must include both letters and numbers.';
                passwordFeedback.className = 'feedback error';
                return false;
            } else {
                passwordFeedback.textContent = 'Password looks good!';
                passwordFeedback.className = 'feedback success';
                return true;
            }
        }

        function validateConfirm() {
            if (passwordInput.value !== confirmInput.value) {
                confirmFeedback.textContent = 'Passwords do not match.';
                confirmFeedback.className = 'feedback error';
                return false;
            } else {
                confirmFeedback.textContent = 'Passwords match!';
                confirmFeedback.className = 'feedback success';
                return true;
            }
        }

        passwordInput.addEventListener('input', validatePassword);
        confirmInput.addEventListener('input', validateConfirm);

        form.addEventListener('submit', function (e) {
            const passwordValid = validatePassword();
            const confirmValid = validateConfirm();

            if (!passwordValid || !confirmValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
