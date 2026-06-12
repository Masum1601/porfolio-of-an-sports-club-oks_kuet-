<?php
require_once 'auth_check.php';

// Only admins can access this page
if (!$isAdmin) {
    header('Location: index.php');
    exit;
}

require_once 'db_config.php';

// Handle delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $uid = (int)$_POST['delete_user'];
        if ($uid !== (int)$_SESSION['user_id']) { // Can't delete yourself
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND is_admin = 0");
            $stmt->execute([$uid]);
        }
    }
    if (isset($_POST['delete_submission'])) {
        $sid = (int)$_POST['delete_submission'];
        $stmt = $pdo->prepare("DELETE FROM contact_submissions WHERE id = ?");
        $stmt->execute([$sid]);
    }
    header('Location: admin.php' . (isset($_POST['delete_submission']) ? '#submissions' : '#users'));
    exit;
}

// Fetch data
$users = $pdo->query("SELECT id, full_name, email, is_admin, created_at FROM users ORDER BY created_at DESC")->fetchAll();
$submissions = $pdo->query("
    SELECT cs.*, u.full_name AS user_name 
    FROM contact_submissions cs 
    LEFT JOIN users u ON cs.user_id = u.id 
    ORDER BY cs.submitted_at DESC
")->fetchAll();

$totalUsers = count($users);
$totalSubmissions = count($submissions);
$totalAdmins = count(array_filter($users, fn($u) => $u['is_admin']));
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard – OKS KUET</title>
    <meta name="description" content="Admin panel for managing OKS KUET users and contact form submissions." />
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
          <?php if ($isAdmin): ?>
            <li><a href="admin.php" class="active">Admin</a></li>
          <?php endif; ?>
          <li class="nav-user-greeting">
            <span class="nav-user-name">👋 <?= htmlspecialchars($userName) ?></span>
          </li>
          <li><a href="logout.php" class="btn btn--small btn--nav-outline">Logout</a></li>
        </ul>
      </nav>
    </header>

    <section class="hero hero--short">
      <div class="hero__inner">
        <div class="hero__badge">Admin Panel</div>
        <h1>Dashboard</h1>
        <p>Manage users and view contact form submissions.</p>
      </div>
    </section>

    <!-- Stats Overview -->
    <section class="stats">
      <div class="stats__grid">
        <div>
          <div class="stat__number"><?= $totalUsers ?></div>
          <div class="stat__label">Registered Users</div>
        </div>
        <div>
          <div class="stat__number"><?= $totalAdmins ?></div>
          <div class="stat__label">Admin Accounts</div>
        </div>
        <div>
          <div class="stat__number"><?= $totalSubmissions ?></div>
          <div class="stat__label">Contact Messages</div>
        </div>
      </div>
    </section>

    <!-- Users Table -->
    <div class="section" id="users">
      <div class="section__header">
        <span class="section__label">User Management</span>
        <h2 class="section__title">Registered Users</h2>
      </div>

      <div class="admin-table-wrapper">
        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Registered</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
              <td data-label="ID"><?= $u['id'] ?></td>
              <td data-label="Name"><strong><?= htmlspecialchars($u['full_name']) ?></strong></td>
              <td data-label="Email"><?= htmlspecialchars($u['email']) ?></td>
              <td data-label="Role">
                <?php if ($u['is_admin']): ?>
                  <span class="badge badge--admin">Admin</span>
                <?php else: ?>
                  <span class="badge badge--user">Member</span>
                <?php endif; ?>
              </td>
              <td data-label="Registered"><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
              <td data-label="Actions">
                <?php if (!$u['is_admin'] && $u['id'] !== (int)$_SESSION['user_id']): ?>
                  <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                    <input type="hidden" name="delete_user" value="<?= $u['id'] ?>" />
                    <button type="submit" class="btn-delete">Delete</button>
                  </form>
                <?php else: ?>
                  <span style="color:var(--text-muted);font-size:.8rem;">—</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Contact Submissions Table -->
    <div class="section--full section--alt">
      <div class="section" id="submissions">
        <div class="section__header">
          <span class="section__label">Messages</span>
          <h2 class="section__title">Contact Submissions</h2>
        </div>

        <?php if (empty($submissions)): ?>
          <div style="text-align:center;color:var(--text-muted);padding:40px;">
            <div style="font-size:3rem;margin-bottom:12px;">📭</div>
            <p>No contact submissions yet.</p>
          </div>
        <?php else: ?>
          <div class="admin-table-wrapper">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($submissions as $s): ?>
                <tr>
                  <td data-label="ID"><?= $s['id'] ?></td>
                  <td data-label="Name"><strong><?= htmlspecialchars($s['name']) ?></strong></td>
                  <td data-label="Email"><?= htmlspecialchars($s['email']) ?></td>
                  <td data-label="Subject"><span class="badge badge--subject"><?= htmlspecialchars($s['subject']) ?></span></td>
                  <td data-label="Message" class="message-cell"><?= htmlspecialchars(mb_strimwidth($s['message'], 0, 100, '…')) ?></td>
                  <td data-label="User"><?= $s['user_name'] ? htmlspecialchars($s['user_name']) : '<em style="color:var(--text-muted);">—</em>' ?></td>
                  <td data-label="Date"><?= date('M d, Y H:i', strtotime($s['submitted_at'])) ?></td>
                  <td data-label="Actions">
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this submission?');">
                      <input type="hidden" name="delete_submission" value="<?= $s['id'] ?>" />
                      <button type="submit" class="btn-delete">Delete</button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <footer class="footer">
      <div class="footer__grid">
        <div>
          <div class="footer__brand">🏆 OKS KUET</div>
          <p class="footer__desc">The Organisation of KUET Sports promotes athletic excellence, teamwork, and student wellbeing through competitive and recreational sports at KUET.</p>
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
          <div class="footer__heading">Admin</div>
          <div class="footer__links">
            <a href="#users">Users</a>
            <a href="#submissions">Submissions</a>
            <a href="logout.php">Logout</a>
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
