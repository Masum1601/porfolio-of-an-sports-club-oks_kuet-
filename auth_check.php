<?php
/**
 * Auth Check — included at the top of every page.
 * Starts session and sets auth variables for use in templates.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userName   = $isLoggedIn ? $_SESSION['user_name']  : '';
$userEmail  = $isLoggedIn ? $_SESSION['user_email'] : '';
$isAdmin    = $isLoggedIn && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
