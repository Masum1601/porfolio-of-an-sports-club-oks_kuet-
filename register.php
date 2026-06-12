<?php
require_once 'auth_check.php';

// If already logged in, redirect to home
if ($isLoggedIn) {
    header('Location: index.php');
    exit;
}

$errors = [];
$success = '';
$old = ['full_name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db_config.php';

    $fullName        = trim($_POST['full_name'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $old['full_name'] = $fullName;
    $old['email']     = $email;

    // Validation
    if (strlen($fullName) < 2) {
        $errors[] = 'Full name must be at least 2 characters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        // Check duplicate email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'An account with this email already exists.';
        } else {
            // Insert new user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$fullName, $email, $hash]);
            $success = 'Registration successful! You can now log in.';
            $old = ['full_name' => '', 'email' => ''];
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register – Organisation of KUET Sports (OKS)</title>
    <meta name="description" content="Create your OKS KUET account to join sports events and connect with fellow athletes." />
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
          <li><a href="login.php" class="btn btn--small btn--nav-outline">Login</a></li>
          <li><a href="register.php" class="btn btn--small btn--nav-primary active">Register</a></li>
        </ul>
      </nav>
    </header>

    <div class="auth-page">
      <div class="auth-card reveal visible">
        <div class="auth-header">
          <div class="auth-icon">🏅</div>
          <h1>Create Account</h1>
          <p>Join OKS KUET and be part of our sporting community</p>
        </div>

        <?php if (!empty($errors)): ?>
          <div class="alert alert--error">
            <?php foreach ($errors as $error): ?>
              <div>⚠️ <?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if ($success): ?>
          <div class="alert alert--success">
            ✅ <?= htmlspecialchars($success) ?>
            <div style="margin-top:10px;">
              <a href="login.php" class="btn btn--primary btn--small">Go to Login →</a>
            </div>
          </div>
        <?php else: ?>
          <form method="POST" action="register.php" novalidate>
            <div class="form-group">
              <label for="fullName">Full Name *</label>
              <input type="text" id="fullName" name="full_name" placeholder="e.g. Md. Rafiqul Islam" autocomplete="name" value="<?= htmlspecialchars($old['full_name']) ?>" required />
            </div>

            <div class="form-group">
              <label for="regEmail">Email Address *</label>
              <input type="email" id="regEmail" name="email" placeholder="you@kuet.ac.bd" autocomplete="email" value="<?= htmlspecialchars($old['email']) ?>" required />
            </div>

            <div class="form-group">
              <label for="regPassword">Password * <span style="font-weight:400;color:var(--text-muted);font-size:.8rem;">(min. 6 characters)</span></label>
              <input type="password" id="regPassword" name="password" placeholder="Create a strong password" autocomplete="new-password" required />
            </div>

            <div class="form-group">
              <label for="confirmPassword">Confirm Password *</label>
              <input type="password" id="confirmPassword" name="confirm_password" placeholder="Re-enter your password" autocomplete="new-password" required />
            </div>

            <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center;">
              Create Account 🚀
            </button>
          </form>
        <?php endif; ?>

        <div class="auth-footer">
          Already have an account? <a href="login.php">Sign in here</a>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>
