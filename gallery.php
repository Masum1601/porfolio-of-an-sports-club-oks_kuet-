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
        <div class="gallery-item reveal" data-caption="Gallery Photo 01"><img src="gallery-01.jpeg" alt="Gallery Photo 01" /><div class="gallery-overlay"><span>Gallery Photo 01</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 02"><img src="gallery-02.jpeg" alt="Gallery Photo 02" /><div class="gallery-overlay"><span>Gallery Photo 02</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 03"><img src="gallery-03.jpeg" alt="Gallery Photo 03" /><div class="gallery-overlay"><span>Gallery Photo 03</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 04"><img src="gallery-04.jpeg" alt="Gallery Photo 04" /><div class="gallery-overlay"><span>Gallery Photo 04</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 05"><img src="gallery-05.jpeg" alt="Gallery Photo 05" /><div class="gallery-overlay"><span>Gallery Photo 05</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 06"><img src="gallery-06.jpeg" alt="Gallery Photo 06" /><div class="gallery-overlay"><span>Gallery Photo 06</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 07"><img src="gallery-07.jpeg" alt="Gallery Photo 07" /><div class="gallery-overlay"><span>Gallery Photo 07</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 08"><img src="gallery-08.jpeg" alt="Gallery Photo 08" /><div class="gallery-overlay"><span>Gallery Photo 08</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 09"><img src="gallery-09.jpeg" alt="Gallery Photo 09" /><div class="gallery-overlay"><span>Gallery Photo 09</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 10"><img src="gallery-10.jpeg" alt="Gallery Photo 10" /><div class="gallery-overlay"><span>Gallery Photo 10</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 11"><img src="gallery-11.jpeg" alt="Gallery Photo 11" /><div class="gallery-overlay"><span>Gallery Photo 11</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 12"><img src="gallery-12.jpeg" alt="Gallery Photo 12" /><div class="gallery-overlay"><span>Gallery Photo 12</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 13"><img src="gallery-13.jpeg" alt="Gallery Photo 13" /><div class="gallery-overlay"><span>Gallery Photo 13</span></div></div>
        <div class="gallery-item reveal" data-caption="Gallery Photo 14"><img src="gallery-14.jpeg" alt="Gallery Photo 14" /><div class="gallery-overlay"><span>Gallery Photo 14</span></div></div>
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
