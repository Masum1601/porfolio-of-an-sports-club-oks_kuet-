<?php require_once 'auth_check.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gallery – Organisation of KUET Sports (OKS)</title>
    <meta name="description" content="Browse photos from OKS KUET sports events." />
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
          <li><a href="gallery.php" class="active">Gallery</a></li>
          <li><a href="contact.php">Contact</a></li>
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

    <section class="hero hero--short"><div class="hero__inner"><div class="hero__badge">Moments &amp; Memories</div><h1>Our Gallery</h1><p>Relive the energy, passion, and camaraderie from OKS events across the years.</p></div></section>

    <div class="section">
      <div class="section__header reveal"><span class="section__label">Photo Gallery</span><h2 class="section__title">Event Highlights</h2><p class="section__subtitle">Click any photo to view it in full size.</p></div>
      <div class="gallery-grid" id="galleryGrid">
        <div class="gallery-item reveal" data-caption="Football Tournament 2026 Finals"><img src="image.jpeg" alt="Football Tournament Finals" /><div class="gallery-overlay"><span>Football Tournament Finals</span></div></div>
        <div class="gallery-item reveal" data-caption="Cricket League Award Ceremony"><img src="image.jpeg" alt="Cricket League Awards" /><div class="gallery-overlay"><span>Cricket League Awards</span></div></div>
        <div class="gallery-item reveal" data-caption="Badminton Championship 2025"><img src="image.jpeg" alt="Badminton Championship" /><div class="gallery-overlay"><span>Badminton Championship 2025</span></div></div>
        <div class="gallery-item reveal" data-caption="Athletic Championship — Sprint Finals"><img src="image.jpeg" alt="Athletic Sprint Finals" /><div class="gallery-overlay"><span>Athletic Sprint Finals</span></div></div>
        <div class="gallery-item reveal" data-caption="Basketball Tournament Spring 2026"><img src="image.jpeg" alt="Basketball Tournament" /><div class="gallery-overlay"><span>Basketball Tournament</span></div></div>
        <div class="gallery-item reveal" data-caption="Volleyball League Opening Ceremony"><img src="image.jpeg" alt="Volleyball League" /><div class="gallery-overlay"><span>Volleyball League 2026</span></div></div>
        <div class="gallery-item reveal" data-caption="Indoor Games Festival 2025"><img src="image.jpeg" alt="Indoor Games Festival" /><div class="gallery-overlay"><span>Indoor Games Festival</span></div></div>
        <div class="gallery-item reveal" data-caption="OKS Annual Sports Day"><img src="image.jpeg" alt="OKS Annual Sports Day" /><div class="gallery-overlay"><span>OKS Annual Sports Day</span></div></div>
        <div class="gallery-item reveal" data-caption="Football Championship Trophy Lift"><img src="image.jpeg" alt="Trophy Presentation" /><div class="gallery-overlay"><span>Trophy Presentation 2025</span></div></div>
      </div>
    </div>

    <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Image viewer">
      <div class="lightbox__inner">
        <button class="lightbox__close" id="lightboxClose" aria-label="Close">✕</button>
        <button class="lightbox__prev" id="lightboxPrev" aria-label="Previous image">&#8592;</button>
        <img src="" alt="" id="lightboxImg" />
        <button class="lightbox__next" id="lightboxNext" aria-label="Next image">&#8594;</button>
        <div class="lightbox__caption" id="lightboxCaption"></div>
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
