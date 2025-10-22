<?php
require_once __DIR__ . '/../functions.php';
requireAdmin();
$prodCount = Statistics::productCount();
$userCount = Statistics::userCount();
$orderCount = Statistics::paidOrderCount();
include __DIR__ . '/../layout/header.php';
?>

<style>
  /* Vintage Admin Dashboard Styling */
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-dashboard-wrapper {
    background: linear-gradient(to bottom, var(--vintage-cream) 0%, #ebe4d1 100%);
    min-height: 100vh;
    padding: 2.5rem 1rem;
  }

  .vintage-dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
  }

  .vintage-dashboard-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 3px double var(--vintage-gold);
    position: relative;
  }

  .vintage-dashboard-header::after {
    content: '◆';
    position: absolute;
    bottom: -18px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--vintage-cream);
    padding: 0 15px;
    color: var(--vintage-gold);
    font-size: 2rem;
  }

  .vintage-dashboard-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 2.5rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 4px;
    margin: 0;
  }

  .vintage-dashboard-subtitle {
    font-family: 'Crimson Text', serif;
    font-size: 1.1rem;
    color: var(--vintage-brown);
    font-style: italic;
    margin-top: 0.5rem;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
  }

  .vintage-stat-card {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 0 8px 20px rgba(44, 24, 16, 0.2);
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
    transition: all 0.4s ease;
  }

  .vintage-stat-card::before {
    content: '';
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
    border: 1px solid var(--vintage-gold);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
  }

  .vintage-stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(44, 24, 16, 0.3);
  }

  .vintage-stat-card:hover::before {
    opacity: 1;
  }

  .stat-number {
    font-family: 'Cinzel', serif;
    font-size: 3.5rem;
    color: var(--vintage-gold);
    font-weight: 700;
    line-height: 1;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
  }

  .stat-label {
    font-family: 'Crimson Text', serif;
    font-size: 1.2rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
  }

  .vintage-actions-section {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 0 4px 15px rgba(44, 24, 16, 0.15);
    padding: 2.5rem;
    position: relative;
  }

  .vintage-actions-section::before,
  .vintage-actions-section::after {
    content: '✦';
    position: absolute;
    top: 15px;
    color: var(--vintage-gold);
    font-size: 1.5rem;
  }

  .vintage-actions-section::before {
    left: 15px;
  }

  .vintage-actions-section::after {
    right: 15px;
  }

  .actions-title {
    font-family: 'Cinzel', serif;
    font-size: 1.5rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 2rem;
    text-align: center;
  }

  .action-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
  }

  .vintage-action-btn {
    font-family: 'Cinzel', serif;
    padding: 1rem 2.5rem;
    border: 2px solid;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-block;
  }

  .vintage-action-btn.primary {
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border-color: var(--vintage-dark);
  }

  .vintage-action-btn.primary:hover {
    background: var(--vintage-gold);
    color: var(--vintage-dark);
    border-color: var(--vintage-gold);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44, 24, 16, 0.3);
  }

  .vintage-action-btn.secondary {
    background: #fff;
    color: var(--vintage-brown);
    border-color: var(--vintage-border);
  }

  .vintage-action-btn.secondary:hover {
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border-color: var(--vintage-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(44, 24, 16, 0.3);
  }

  @media (max-width: 768px) {
    .vintage-dashboard-title {
      font-size: 1.8rem;
      letter-spacing: 2px;
    }

    .stats-grid {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    .stat-number {
      font-size: 2.5rem;
    }

    .action-buttons {
      flex-direction: column;
    }

    .vintage-action-btn {
      width: 100%;
      text-align: center;
    }
  }

  /* Google Fonts Import */
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
</style>

<div class="vintage-dashboard-wrapper">
  <div class="vintage-dashboard-container">
    <div class="vintage-dashboard-header">
      <h4 class="vintage-dashboard-title">Admin Dashboard</h4>
      <p class="vintage-dashboard-subtitle">Curating Your Collection</p>
    </div>

    <div class="stats-grid">
      <div class="vintage-stat-card">
        <div class="stat-number"><?php echo $prodCount; ?></div>
        <div class="stat-label">Products</div>
      </div>
      <div class="vintage-stat-card">
        <div class="stat-number"><?php echo $userCount; ?></div>
        <div class="stat-label">Users</div>
      </div>
      <div class="vintage-stat-card">
        <div class="stat-number"><?php echo $orderCount; ?></div>
        <div class="stat-label">Paid Orders</div>
      </div>
    </div>

    <div class="vintage-actions-section">
      <h5 class="actions-title">Quick Actions</h5>
      <div class="action-buttons">
        <a class="vintage-action-btn primary" href="products/index.php">Manage Products</a>
        <a class="vintage-action-btn secondary" href="orders.php">View Orders</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
