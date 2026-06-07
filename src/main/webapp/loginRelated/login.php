<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 1. Connect to your database
    $conn = new mysqli("localhost", "root", "", "unipulse");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 2. Check if user exists
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // 3. Verify password (works for plain text or encrypted)
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            
            // FIXED: This now points exactly to your deep webapp folder layout!
            header("Location: /UNIPULSE/src/main/webapp/dashboard.html");
            exit();
        }
    }
    // If it fails, reload with an error flag
    header("Location: login.php?error=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>UNIPULSE — Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg: #ffffff;
    --bg-3: #f1efe8;
    --text-1: #1a1a18;
    --text-2: #5f5e5a;
    --text-3: #b4b2a9;
    --border: rgba(0,0,0,0.12);
    --purple-50: #EEEDFE;
    --purple-400: #7F77DD;
    --purple-600: #534AB7;
    --red-50: #FCEBEB;
    --red-600: #A32D2D;
    --r-lg: 12px;
    --r-md: 8px;
  }

  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #1c1c1a;
      --bg-3: #2c2c2a;
      --text-1: #f1efe8;
      --text-2: #b4b2a9;
      --text-3: #5f5e5a;
      --border: rgba(255,255,255,0.10);
    }
  }

  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
    background: var(--bg-3);
    color: var(--text-1);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
  }

  .login-card {
    background: var(--bg);
    border: 0.5px solid var(--border);
    border-radius: var(--r-lg);
    width: 100%;
    max-width: 360px;
    padding: 2rem;
    box-shadow: 0 4px 24px rgba(0,0,0,0.02);
  }

  .brand {
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 2px;
    color: var(--text-3);
    text-align: center;
    margin-bottom: 1.5rem;
  }
  .brand b { color: var(--text-1); font-weight: 500; }

  .form-group {
    margin-bottom: 1.25rem;
  }

  label {
    display: block;
    font-size: 11px;
    color: var(--text-2);
    margin-bottom: 4px;
    font-weight: 500;
  }

  .input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .input-wrapper i {
    position: absolute;
    left: 10px;
    color: var(--text-3);
    font-size: 16px;
  }

  input {
    width: 100%;
    padding: 8px 12px 8px 34px;
    font-size: 13px;
    background: var(--bg);
    border: 0.5px solid var(--border);
    border-radius: var(--r-md);
    color: var(--text-1);
    outline: none;
    transition: border-color 0.12s;
  }

  input:focus {
    border-color: var(--purple-400);
  }

  .btn-submit {
    width: 100%;
    background: var(--purple-600);
    color: #ffffff;
    border: none;
    padding: 9px;
    font-size: 13px;
    font-weight: 500;
    border-radius: var(--r-md);
    cursor: pointer;
    transition: background 0.12s;
    margin-top: 0.5rem;
  }

  .btn-submit:hover {
    background: var(--purple-800);
  }

  .error-box {
    background: var(--red-50);
    color: var(--red-600);
    font-size: 11px;
    padding: 8px 12px;
    border-radius: var(--r-md);
    margin-bottom: 1.25rem;
    display: none; /* Shown dynamically if login fails */
    align-items: center;
    gap: 6px;
  }
</style>
</head>
<body>

<div class="login-card">
  <div class="brand">UNI<b>PULSE</b></div>

  <?php if (isset($_GET['error'])): ?>
    <div class="error-box" style="display: flex;">
      <i class="ti ti-alert-circle"></i> Invalid username or password.
    </div>
  <?php endif; ?>

  <form action="" method="POST">
    <div class="form-group">
      <label for="username">USERNAME</label>
      <div class="input-wrapper">
        <i class="ti ti-user"></i>
        <input type="text" id="username" name="username" required autocomplete="off" />
      </div>
    </div>

    <div class="form-group">
      <label for="password">PASSWORD</label>
      <div class="input-wrapper">
        <i class="ti ti-lock"></i>
        <input type="password" id="password" name="password" required />
      </div>
    </div>

    <button type="submit" class="btn-submit">Sign In</button>
  </form>
</div>

</body>
</html>