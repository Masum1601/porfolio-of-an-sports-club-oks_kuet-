<?php require_once 'auth_check.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Organisation of KUET Sports (OKS)</title>
    <meta name="description" content="The Organisation of KUET Sports (OKS) promotes athletic excellence, teamwork and fitness among KUET students through competitive and recreational sports programs." />
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏆</text></svg>" />
    <link rel="stylesheet" href="styles.css" />
  </head>

  <body>
    <header class="navbar" id="navbar">
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
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="events.php">Events</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="contact.php">Contact</a></li>
          <?php if ($isLoggedIn): ?>
            <?php if ($isAdmin): ?>
              <li><a href="admin.php">Admin</a></li>
            <?php endif; ?>
            <li class="nav-user-greeting">
              <span class="nav-user-name">👋 <?= htmlspecialchars($userName) ?></span>
            </li>
            <li><a href="logout.php" class="btn btn--small btn--nav-outline">Logout</a></li>
          <?php else: ?>
            <li><a href="login.php" class="btn btn--small btn--nav-outline">Login</a></li>
            <li><a href="register.php" class="btn btn--small btn--nav-primary">Register</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>

    <section class="hero">
      <div class="hero__inner">
        <div class="hero__badge">Est. KUET Campus · Khulna, Bangladesh</div>
        <h1>Compete. Unite.<br>Excel Together.</h1>
        <p>The Organisation of KUET Sports brings students together through the power of athletic competition and teamwork.</p>
        <div class="hero__cta">
          <a href="events.php" class="btn btn--primary">View Events</a>
          <a href="about.php" class="btn btn--outline">Learn More</a>
        </div>
      </div>
    </section>

    <section class="stats" id="stats">
      <div class="stats__grid">
        <div class="reveal">
          <div class="stat__number" data-target="500">0</div>
          <div class="stat__label">Active Members</div>
        </div>
        <div class="reveal">
          <div class="stat__number" data-target="15">0</div>
          <div class="stat__label">Sports Programs</div>
        </div>
        <div class="reveal">
          <div class="stat__number" data-target="50">0</div>
          <div class="stat__label">Annual Events</div>
        </div>
        <div class="reveal">
          <div class="stat__number" data-target="12">0</div>
          <div class="stat__label">Years of Excellence</div>
        </div>
      </div>
    </section>

    <div class="section--full section--alt">
      <div class="section">
        <div class="section__header reveal">
          <span class="section__label">Who We Are</span>
          <h2 class="section__title">Built on Passion for Sports</h2>
          <p class="section__subtitle">We are a student-run sports body at KUET dedicated to developing athletic skills, discipline, and lasting friendships.</p>
        </div>
        <div class="cards">
          <div class="card reveal">
            <div class="card__icon">⚽</div>
            <h3>Team Sports</h3>
            <p>Football, cricket, basketball, and volleyball — programs for all skill levels across every department.</p>
          </div>
          <div class="card reveal">
            <div class="card__icon">🏸</div>
            <h3>Individual Sports</h3>
            <p>Athletics, badminton, table tennis and more. Compete individually and push your personal limits.</p>
          </div>
          <div class="card reveal">
            <div class="card__icon">🎯</div>
            <h3>Training Programs</h3>
            <p>Professional coaching sessions and structured training to help you reach peak athletic performance.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section__header reveal">
        <span class="section__label">Stay Updated</span>
        <h2 class="section__title">Upcoming Events</h2>
        <p class="section__subtitle">Don't miss out — check out our next round of competitions and activities.</p>
      </div>
      <div class="cards">
        <div class="card reveal">
          <div class="card__icon">⚽</div>
          <h3>Football Tournament 2026</h3>
          <p>📅 May 15 – May 30 &nbsp;·&nbsp; 📍 KUET Main Ground<br><br>Knockout format across all departments. Register your team now!</p>
        </div>
        <div class="card reveal">
          <div class="card__icon">🏏</div>
          <h3>Cricket League 2026</h3>
          <p>📅 June 1 – June 20 &nbsp;·&nbsp; 📍 KUET Cricket Field<br><br>T20 format — individuals and teams both welcome to register.</p>
        </div>
        <div class="card reveal">
          <div class="card__icon">🏸</div>
          <h3>Badminton Championship</h3>
          <p>📅 May 10 – May 15 &nbsp;·&nbsp; 📍 Indoor Sports Complex<br><br>Singles and doubles. All skill levels welcome.</p>
        </div>
      </div>
      <div style="text-align:center;margin-top:36px;">
        <a href="events.php" class="btn btn--primary reveal">See All Events</a>
      </div>
    </div>

    <div class="section--full section--alt">
      <div class="section">
        <div class="section__header reveal">
          <span class="section__label">Moments & Memories</span>
          <h2 class="section__title">Gallery</h2>
          <p class="section__subtitle">Relive the energy and excitement from our past events.</p>
        </div>
        <div class="gallery-grid" style="max-width:960px;margin:0 auto;">
          <div class="gallery-item reveal" data-caption="Football Finals 2025">
            <img src="image.jpeg" alt="Football Finals 2025" />
            <div class="gallery-overlay"><span>Football Finals 2025</span></div>
          </div>
          <div class="gallery-item reveal" data-caption="Cricket League Awards">
            <img src="image.jpeg" alt="Cricket League Awards" />
            <div class="gallery-overlay"><span>Cricket League Awards</span></div>
          </div>
          <div class="gallery-item reveal" data-caption="Athletic Championships">
            <img src="image.jpeg" alt="Athletic Championships" />
            <div class="gallery-overlay"><span>Athletic Championships</span></div>
          </div>
        </div>
        <div style="text-align:center;margin-top:32px;">
          <a href="gallery.php" class="btn btn--primary reveal">View Full Gallery</a>
        </div>
      </div>
    </div>

    <div class="section" id="contact">
      <div class="section__header reveal">
        <span class="section__label">Get In Touch</span>
        <h2 class="section__title">Contact Us</h2>
        <p class="section__subtitle">Have questions or want to join? Reach out to us and we'll get back to you soon.</p>
      </div>
      <div style="text-align:center;">
        <a href="contact.php" class="btn btn--primary reveal">Go to Contact Page</a>
      </div>
    </div>

    <footer class="footer">
      <div class="footer__grid">
        <div>
          <div class="footer__brand">🏆 OKS KUET</div>
          <p class="footer__desc">The Organisation of KUET Sports promotes athletic excellence, teamwork, and student wellbeing through competitive and recreational sports at Khulna University of Engineering &amp; Technology.</p>
          <div class="footer__social">
            <a href="#" class="social-icon" aria-label="Facebook">📘</a>
            <a href="#" class="social-icon" aria-label="Instagram">📸</a>
            <a href="#" class="social-icon" aria-label="YouTube">▶️</a>
          </div>
        </div>
        <div>
          <div class="footer__heading">Quick Links</div>
          <div class="footer__links">
            <a href="index.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="events.php">Events</a>
            <a href="gallery.php">Gallery</a>
            <a href="contact.php">Contact</a>
          </div>
        </div>
        <div>
          <div class="footer__heading">Sports</div>
          <div class="footer__links">
            <a href="#">Football</a>
            <a href="#">Cricket</a>
            <a href="#">Basketball</a>
            <a href="#">Badminton</a>
            <a href="#">Athletics</a>
          </div>
        </div>
      </div>
      <div class="footer__bottom">
        <p>&copy; 2026 Organisation of KUET Sports. All rights reserved.</p>
      </div>
    </footer>

    <script src="script.js"></script>
  </body>
</html>
