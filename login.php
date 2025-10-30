<?php
include('config.php');
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['username'] = $username;
        $message = '<p class="success">✅ Welcome, <strong>' . htmlspecialchars($username) . '</strong>!</p>';
    } else {
        $message = '<p class="error">❌ Invalid username or password!</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Interactive</title>

<style>
    * { box-sizing: border-box; }

    body {
        font-family: 'Poppins', sans-serif;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin: 0;
        background: linear-gradient(-45deg, #bd8af4ff, #82adf6ff, #f68383ff, #f87db9ff);
        background-size: 400% 400%;
        animation: gradientBG 12s ease infinite;
        position: relative;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .bubble {
        position: absolute;
        border-radius: 50%;
        opacity: 0.3;
        background: white;
        animation: float 10s infinite;
    }

    @keyframes float {
        from { transform: translateY(0); opacity: 0.3; }
        50% { transform: translateY(-80px); opacity: 0.6; }
        to { transform: translateY(0); opacity: 0.3; }
    }

    .container {
        z-index: 2;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        padding: 40px 50px;
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        width: 100%;
        max-width: 380px;
        animation: fadeIn 1.2s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
        text-align: center;
        color: #fff;
        margin-bottom: 25px;
        letter-spacing: 1px;
    }

    label {
        color: #f0f0f0;
        font-size: 0.9em;
        margin-bottom: 5px;
        display: block;
    }

    input {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        margin-bottom: 15px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    input:focus {
        background: rgba(255,255,255,0.35);
        outline: none;
        box-shadow: 0 0 10px #00c3ff;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #6a11cb;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: 0.3s ease;
    }

    button::after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        top: 50%;
        left: 50%;
        background: rgba(255,255,255,0.3);
        border-radius: 100%;
        transform: translate(-50%, -50%);
        transition: width 0.4s ease, height 0.4s ease;
    }

    button:hover::after {
        width: 250px;
        height: 250px;
    }

    button:hover {
        background: #8e2de2;
    }

    p {
        text-align: center;
        color: #f0f0f0;
        margin-top: 15px;
        font-size: 0.9em;
    }

    a {
        color: #00e0ff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .error, .success {
        text-align: center;
        font-weight: 500;
        animation: fadeMessage 0.8s ease;
    }

    .error {
        color: #ff5252;
    }

    .success {
        color: #4ef037;
    }

    @keyframes fadeMessage {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .shake {
        animation: shake 0.3s ease;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-8px); }
        50% { transform: translateX(8px); }
        75% { transform: translateX(-8px); }
    }
</style>
</head>

<body>
    <!-- Floating background bubbles -->
    <div class="bubble" style="width:60px; height:60px; left:10%; animation-delay:0s;"></div>
    <div class="bubble" style="width:80px; height:80px; left:70%; animation-delay:2s;"></div>
    <div class="bubble" style="width:40px; height:40px; left:40%; animation-delay:4s;"></div>

    <div class="container <?php if (strpos($message, 'Invalid') !== false) echo 'shake'; ?>">
        <h2>Welcome Back 👋</h2>

        <?php echo $message; ?>

        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="login">Login</button>
        </form>

        <p>New here? <a href="register.php">Create an account</a></p>
    </div>

<script>
    // Optional: Add input focus animations
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => input.style.transform = 'scale(1.02)');
        input.addEventListener('blur', () => input.style.transform = 'scale(1)');
    });
</script>
</body>
</html>
