<?php
require_once 'auth_check.php';
if ($isLoggedIn) {
    header('Location: index.php');
    exit;
}

$errors = [];
$oldEmail = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db_config.php';

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $oldEmail = $email;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (empty($password)) {
        $errors[] = 'Please enter your password.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, full_name, email, password_hash, is_admin FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin']  = $user['is_admin'];

            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Invalid email or password. Please try again.';
        }
    }
}

$regSuccess = isset($_GET['registered']) ? true : false;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login – Organisation of KUET Sports (OKS)</title>
    <meta name="description" content="Sign in to your OKS KUET account to access events, registration, and your profile." />
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏆</text></svg>" />
    <link rel="stylesheet" href="styles.css" />
  </head>

  <body>
    <header class="navbar scrolled" id="navbar">
      <a href="index.php" class="navbar-brand">
        <span class="brand-icon">🏆</span>
        <span>OKS KUET</span>
      </a>
      <button class="nav-toggle" id="navToggle" aria-controls="primary-navigation" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger"></span>
      </button>
      <nav id="primary-navigation" class="nav-menu" aria-label="Primary">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="events.php">Events</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="login.php" class="btn btn--small btn--nav-outline active">Login</a></li>
          <li><a href="register.php" class="btn btn--small btn--nav-primary">Register</a></li>
        </ul>
      </nav>
    </header>

    <div class="auth-page">
      <div class="auth-card reveal visible">
        <div class="auth-header">
          <div class="auth-icon">🔐</div>
          <h1>Welcome Back</h1>
          <p>Sign in to your OKS KUET account</p>
        </div>

        <?php if ($regSuccess): ?>
          <div class="alert alert--success">
            ✅ Registration successful! Please sign in with your new account.
          </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
          <div class="alert alert--error">
            <?php foreach ($errors as $error): ?>
              <div>⚠️ <?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="login.php" novalidate>
          <div class="form-group">
            <label for="loginEmail">Email Address</label>
            <input type="email" id="loginEmail" name="email" placeholder="you@kuet.ac.bd" autocomplete="email" value="<?= htmlspecialchars($oldEmail) ?>" required />
          </div>

          <div class="form-group">
            <label for="loginPassword">Password</label>
            <input type="password" id="loginPassword" name="password" placeholder="Enter your password" autocomplete="current-password" required />
          </div>

          <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">
            Sign In 🔑
          </button>
        </form>

        <div class="auth-footer">
          Don't have an account? <a href="register.php">Create one here</a>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
