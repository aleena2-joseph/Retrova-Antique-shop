<?php
require_once __DIR__ . '/../functions.php';
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Retrova - Timeless Antiques</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo BASE_URL; ?>/assets/styles.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
<style>
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  * {
    box-sizing: border-box;
  }

  body {
    background: linear-gradient(135deg, #f5f1e8 0%, #e8dcc4 50%, #f5f1e8 100%);
    min-height: 100vh;
    margin: 0;
    padding: 0;
  }

  /* Vintage Navbar Styling */
  .vintage-navbar {
    background: #fff !important;
    border-bottom: 3px solid var(--vintage-border) !important;
    box-shadow: 0 4px 20px rgba(44, 24, 16, 0.15);
    padding: 0.75rem 0;
    position: relative;
  }

  .vintage-navbar::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--vintage-gold);
  }

  .vintage-navbar .container {
    padding-left: 1rem;
    padding-right: 1rem;
  }

  .vintage-brand {
    font-family: 'Cinzel', serif !important;
    font-size: 1.75rem !important;
    font-weight: 700 !important;
    color: var(--vintage-dark) !important;
    text-transform: uppercase;
    letter-spacing: 3px;
    position: relative;
    padding: 0.5rem 20px;
    transition: all 0.3s ease;
    white-space: nowrap;
  }

  .vintage-brand::before,
  .vintage-brand::after {
    content: '◆';
    position: absolute;
    color: var(--vintage-gold);
    font-size: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
  }

  .vintage-brand::before {
    left: 0;
  }

  .vintage-brand::after {
    right: 0;
  }

  .vintage-brand:hover {
    color: var(--vintage-gold) !important;
  }

  .vintage-toggler {
    border: 2px solid var(--vintage-border) !important;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
  }

  .vintage-toggler:hover {
    border-color: var(--vintage-gold) !important;
    background: var(--vintage-cream);
  }

  .vintage-toggler:focus {
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2) !important;
  }

  /* Search Form Styling */
  .vintage-search-form {
    display: flex;
    gap: 0.5rem;
    flex-wrap: nowrap;
  }

  .vintage-search-input {
    border: 2px solid var(--vintage-border) !important;
    background: var(--vintage-cream) !important;
    font-family: 'Crimson Text', serif;
    font-size: 0.95rem;
    color: var(--vintage-dark) !important;
    padding: 0.6rem 1rem !important;
    transition: all 0.3s ease;
    flex: 1;
    min-width: 0;
  }

  .vintage-search-input:focus {
    border-color: var(--vintage-gold) !important;
    background: #fff !important;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15) !important;
    outline: none;
  }

  .vintage-search-input::placeholder {
    color: var(--vintage-brown);
    opacity: 0.6;
    font-style: italic;
  }

  .vintage-search-btn {
    background: var(--vintage-dark) !important;
    color: var(--vintage-gold) !important;
    border: 2px solid var(--vintage-dark) !important;
    font-family: 'Cinzel', serif;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 0.6rem 1.25rem !important;
    transition: all 0.3s ease;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .vintage-search-btn:hover {
    background: var(--vintage-gold) !important;
    color: var(--vintage-dark) !important;
    border-color: var(--vintage-gold) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(44, 24, 16, 0.25);
  }

  /* Nav Links Styling */
  .vintage-nav-links {
    gap: 0.25rem;
    flex-wrap: wrap;
  }

  .vintage-nav-link {
    font-family: 'Cinzel', serif !important;
    font-size: 0.85rem !important;
    color: var(--vintage-brown) !important;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 0.6rem 1rem !important;
    transition: all 0.3s ease;
    position: relative;
    white-space: nowrap;
  }

  .vintage-nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: var(--vintage-gold);
    transition: all 0.3s ease;
    transform: translateX(-50%);
  }

  .vintage-nav-link:hover {
    color: var(--vintage-gold) !important;
  }

  .vintage-nav-link:hover::after {
    width: 80%;
  }

  .vintage-cart-badge {
    background: var(--vintage-gold);
    color: var(--vintage-dark);
    font-weight: 600;
    padding: 0.15rem 0.5rem;
    border-radius: 10px;
    font-size: 0.7rem;
    margin-left: 0.25rem;
    display: inline-block;
  }

  /* Main Content Area */
  main {
    padding: 2rem 0 !important;
    position: relative;
  }

  main::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: 
      radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.03) 0%, transparent 50%),
      radial-gradient(circle at 80% 70%, rgba(107, 68, 35, 0.03) 0%, transparent 50%);
    pointer-events: none;
    z-index: -1;
  }

  .container {
    position: relative;
    z-index: 1;
    padding-left: 1rem;
    padding-right: 1rem;
  }

  /* Desktop (Large screens) */
  @media (min-width: 992px) {
    .vintage-brand {
      font-size: 2rem !important;
      letter-spacing: 4px;
    }

    .vintage-search-btn {
      font-size: 0.85rem;
      padding: 0.6rem 1.5rem !important;
    }

    .vintage-nav-link {
      font-size: 0.9rem !important;
    }

    main {
      padding: 3rem 0 !important;
    }
  }

  /* Tablet (Medium screens) */
  @media (max-width: 991px) {
    .navbar-collapse {
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 2px solid var(--vintage-border);
    }

    .vintage-search-form {
      width: 100%;
      margin-bottom: 1rem;
    }

    .vintage-nav-links {
      width: 100%;
      flex-direction: column;
      gap: 0;
    }

    .vintage-nav-link {
      padding: 0.75rem 0 !important;
      width: 100%;
      border-bottom: 1px solid rgba(184, 149, 106, 0.2);
      text-align: left;
    }

    .vintage-nav-link::after {
      display: none;
    }

    .vintage-nav-link:hover {
      background: var(--vintage-cream);
      padding-left: 0.5rem !important;
    }

    .nav-item:last-child .vintage-nav-link {
      border-bottom: none;
    }
  }

  /* Small Tablet */
  @media (max-width: 768px) {
    .vintage-brand {
      font-size: 1.5rem !important;
      letter-spacing: 2.5px;
    }

    .vintage-navbar {
      padding: 0.5rem 0;
    }

    .vintage-search-input {
      font-size: 0.9rem;
      padding: 0.55rem 0.85rem !important;
    }

    .vintage-search-btn {
      font-size: 0.75rem;
      padding: 0.55rem 1rem !important;
      letter-spacing: 1px;
    }

    main {
      padding: 1.5rem 0 !important;
    }
  }

  /* Mobile (Small screens) */
  @media (max-width: 576px) {
    .vintage-brand {
      font-size: 1.25rem !important;
      letter-spacing: 2px;
      padding: 0.5rem 15px;
    }

    .vintage-brand::before,
    .vintage-brand::after {
      font-size: 0.4rem;
    }

    .vintage-navbar .container {
      padding-left: 0.75rem;
      padding-right: 0.75rem;
    }

    .vintage-search-input {
      font-size: 0.85rem;
      padding: 0.5rem 0.75rem !important;
    }

    .vintage-search-input::placeholder {
      font-size: 0.85rem;
    }

    .vintage-search-btn {
      font-size: 0.7rem;
      padding: 0.5rem 0.85rem !important;
      letter-spacing: 0.5px;
    }

    .vintage-nav-link {
      font-size: 0.8rem !important;
      padding: 0.65rem 0 !important;
      letter-spacing: 1px;
    }

    .vintage-cart-badge {
      font-size: 0.65rem;
      padding: 0.1rem 0.4rem;
    }

    .container {
      padding-left: 0.75rem;
      padding-right: 0.75rem;
    }

    main {
      padding: 1rem 0 !important;
    }
  }

  /* Extra Small Mobile */
  @media (max-width: 400px) {
    .vintage-brand {
      font-size: 1.1rem !important;
      letter-spacing: 1.5px;
      padding: 0.5rem 12px;
    }

    .vintage-search-btn {
      font-size: 0.65rem;
      padding: 0.5rem 0.7rem !important;
    }

    .vintage-nav-link {
      font-size: 0.75rem !important;
      letter-spacing: 0.5px;
    }
  }

  /* Landscape Mobile */
  @media (max-width: 767px) and (orientation: landscape) {
    .vintage-navbar {
      padding: 0.4rem 0;
    }

    .vintage-brand {
      font-size: 1.2rem !important;
      padding: 0.3rem 15px;
    }

    main {
      padding: 1rem 0 !important;
    }
  }

  /* Print Styles */
  @media print {
    .vintage-navbar {
      box-shadow: none;
      border-bottom: 1px solid #000;
    }

    main::before {
      display: none;
    }
  }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg vintage-navbar">
  <div class="container">
    <a class="navbar-brand vintage-brand" href="<?php echo BASE_URL; ?>/">Retrova</a>
    <button class="navbar-toggler vintage-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <form class="vintage-search-form ms-lg-auto" role="search" action="<?php echo BASE_URL; ?>/index.php" method="get">
        <input class="form-control vintage-search-input" type="search" placeholder="Search timeless treasures..." name="q" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>" aria-label="Search antiques">
        <button class="btn vintage-search-btn" type="submit">Search</button>
      </form>
      <ul class="navbar-nav vintage-nav-links ms-lg-3">
        <li class="nav-item">
          <a class="nav-link vintage-nav-link" href="<?php echo BASE_URL; ?>/cart.php">
            Cart
            <?php $cartCount = array_sum($_SESSION['cart'] ?? []); ?>
            <?php if ($cartCount > 0): ?>
              <span class="vintage-cart-badge"><?php echo $cartCount; ?></span>
            <?php endif; ?>
          </a>
        </li>
        <?php if (isLoggedIn()): ?>
          <?php if (isAdmin()): ?>
            <li class="nav-item"><a class="nav-link vintage-nav-link" href="<?php echo BASE_URL; ?>./admin/index.php">Admin</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link vintage-nav-link" href="<?php echo BASE_URL; ?>./logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link vintage-nav-link" href="<?php echo BASE_URL; ?>../login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link vintage-nav-link" href="<?php echo BASE_URL; ?>./register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main>
  <div class="container">