<?php
require_once 'auth_check.php';

$formErrors = [];
$formSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    require_once 'db_config.php';

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = $_POST['subject'] ?? '';
    $message = trim($_POST['message'] ?? '');

    if (strlen($name) < 2)  $formErrors[] = 'Please enter your full name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $formErrors[] = 'Please enter a valid email.';
    if (empty($subject))    $formErrors[] = 'Please select a subject.';
    if (strlen($message) < 20) $formErrors[] = 'Message must be at least 20 characters.';

    if (empty($formErrors)) {
        $stmt = $pdo->prepare("INSERT INTO contact_submissions (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $name, $email, $subject, $message]);
        $formSuccess = 'Thank you! Your message has been sent. We\'ll be in touch soon.';
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact – Organisation of KUET Sports (OKS)</title>
    <meta name="description" content="Get in touch with OKS KUET." />
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏆</text></svg>" />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <header class="navbar" id="navbar">
      <a href="index.php" class="navbar-brand"><span class="brand-icon">🏆</span><span>OKS KUET</span></a>
      <button class="nav-toggle" id="navToggle" aria-controls="primary-navigation" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="hamburger"></span></button>
      <nav id="primary-navigation" class="nav-menu" aria-label="Primary">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="events.php">Events</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="contact.php" class="active">Contact</a></li>
          <?php if ($isLoggedIn): ?>
            <?php if ($isAdmin): ?><li><a href="admin.php">Admin</a></li><?php endif; ?>
            <li class="nav-user-greeting"><span class="nav-user-name">👋 <?= htmlspecialchars($userName) ?></span></li>
            <li><a href="logout.php" class="btn btn--small btn--nav-outline">Logout</a></li>
          <?php else: ?>
            <li><a href="login.php" class="btn btn--small btn--nav-outline">Login</a></li>
            <li><a href="register.php" class="btn btn--small btn--nav-primary">Register</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>

    <section class="hero hero--short"><div class="hero__inner"><div class="hero__badge">Get In Touch</div><h1>Contact OKS KUET</h1><p>Have a question? Want to join? We'd love to hear from you.</p></div></section>

    <div class="section">
      <div class="contact-grid">
        <div>
          <div class="section__header" style="text-align:left;margin-bottom:28px;">
            <span class="section__label">Reach Out</span>
            <h2 class="section__title" style="font-size:1.8rem;">We're Here to Help</h2>
            <p class="section__subtitle" style="margin:0;font-size:.95rem;">Whether you're a new student looking to join or an organiser wanting to collaborate, drop us a message.</p>
          </div>
          <div class="contact-info__card reveal-left"><div class="contact-info__icon">📍</div><div><h4>Address</h4><p>Organisation of KUET Sports<br>Khulna University of Engineering &amp; Technology<br>Khulna – 9203, Bangladesh</p></div></div>
          <div class="contact-info__card reveal-left"><div class="contact-info__icon">📧</div><div><h4>Email</h4><p>oks@kuet.ac.bd<br>sports@kuet.ac.bd</p></div></div>
          <div class="contact-info__card reveal-left"><div class="contact-info__icon">📞</div><div><h4>Phone</h4><p>+880 41-774780 (Ext. 310)<br>Available Mon–Fri, 9am–5pm</p></div></div>
          <div class="contact-info__card reveal-left"><div class="contact-info__icon">🕒</div><div><h4>Office Hours</h4><p>Sunday – Thursday: 9:00 AM – 5:00 PM<br>Friday – Saturday: Closed</p></div></div>
        </div>

        <div class="contact-form reveal-right">
          <?php if (!$isLoggedIn): ?>
            <!-- Login required message -->
            <div style="text-align:center;padding:40px 20px;">
              <div style="font-size:3rem;margin-bottom:16px;">🔒</div>
              <h3 style="font-family:'Poppins',sans-serif;color:var(--navy);margin-bottom:10px;">Login Required</h3>
              <p style="color:var(--text-muted);margin-bottom:24px;">You need to be logged in to send us a message.</p>
              <a href="login.php" class="btn btn--primary">Login to Continue</a>
              <p style="color:var(--text-muted);font-size:.85rem;margin-top:14px;">Don't have an account? <a href="register.php" style="color:var(--green);font-weight:600;">Register here</a></p>
            </div>
          <?php else: ?>
            <div style="margin-bottom:28px;">
              <h3 style="font-family:'Poppins',sans-serif;font-size:1.35rem;color:var(--navy);margin-bottom:6px;">Send Us a Message</h3>
              <p style="color:var(--text-muted);font-size:.9rem;">We'll get back to you within 1–2 business days.</p>
            </div>

            <?php if (!empty($formErrors)): ?>
              <div class="alert alert--error">
                <?php foreach ($formErrors as $err): ?>
                  <div>⚠️ <?= htmlspecialchars($err) ?></div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if ($formSuccess): ?>
              <div class="alert alert--success">✅ <?= htmlspecialchars($formSuccess) ?></div>
            <?php endif; ?>

            <form method="POST" action="contact.php" id="contactForm" novalidate>
              <div class="form-group">
                <label for="contactName">Full Name *</label>
                <input type="text" id="contactName" name="name" placeholder="e.g. Md. Rafiqul Islam" autocomplete="name" value="<?= htmlspecialchars($userName) ?>" />
                <div class="form-error" id="nameError">Please enter your full name.</div>
              </div>
              <div class="form-group">
                <label for="contactEmail">Email Address *</label>
                <input type="email" id="contactEmail" name="email" placeholder="you@kuet.ac.bd" autocomplete="email" value="<?= htmlspecialchars($userEmail) ?>" />
                <div class="form-error" id="emailError">Please enter a valid email address.</div>
              </div>
              <div class="form-group">
                <label for="contactSubject">Subject *</label>
                <select id="contactSubject" name="subject">
                  <option value="">— Select a subject —</option>
                  <option value="join">Joining OKS</option>
                  <option value="event">Event Registration Query</option>
                  <option value="sponsor">Sponsorship &amp; Collaboration</option>
                  <option value="media">Media &amp; Press</option>
                  <option value="other">Other</option>
                </select>
                <div class="form-error" id="subjectError">Please select a subject.</div>
              </div>
              <div class="form-group">
                <label for="contactMessage">Message *</label>
                <textarea id="contactMessage" name="message" placeholder="Write your message here…"></textarea>
                <div class="form-error" id="messageError">Please enter a message (at least 20 characters).</div>
              </div>
              <button type="submit" class="btn btn--primary" id="submitBtn" style="width:100%;justify-content:center;">Send Message ✉️</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <footer class="footer"><div class="footer__grid">
      <div><div class="footer__brand">🏆 OKS KUET</div><p class="footer__desc">The Organisation of KUET Sports promotes athletic excellence, teamwork, and student wellbeing through competitive and recreational sports at KUET.</p><div class="footer__social"><a href="#" class="social-icon" aria-label="Facebook">📘</a><a href="#" class="social-icon" aria-label="Instagram">📸</a><a href="#" class="social-icon" aria-label="YouTube">▶️</a></div></div>
      <div><div class="footer__heading">Quick Links</div><div class="footer__links"><a href="index.php">Home</a><a href="about.php">About Us</a><a href="events.php">Events</a><a href="gallery.php">Gallery</a><a href="contact.php">Contact</a></div></div>
      <div><div class="footer__heading">Sports</div><div class="footer__links"><a href="#">Football</a><a href="#">Cricket</a><a href="#">Basketball</a><a href="#">Badminton</a><a href="#">Athletics</a></div></div>
    </div><div class="footer__bottom"><p>&copy; 2026 Organisation of KUET Sports. All rights reserved.</p></div></footer>
    <script src="script.js"></script>
  </body>
</html>
