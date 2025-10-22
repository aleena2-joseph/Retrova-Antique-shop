<?php
require_once __DIR__ . '/../functions.php';
requireAdmin();
$orders = Database::conn()->query("SELECT o.*, u.name uname FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.id DESC")->fetchAll();
include __DIR__ . '/../layout/header.php';
?>

<style>
  /* Vintage Admin Orders Page Styling */
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-orders-wrapper {
    background: linear-gradient(to bottom, var(--vintage-cream) 0%, #ebe4d1 100%);
    min-height: 100vh;
    padding: 2.5rem 1rem;
  }

  .vintage-orders-container {
    max-width: 1400px;
    margin: 0 auto;
  }

  .vintage-orders-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 3px double var(--vintage-gold);
    position: relative;
  }

  .vintage-orders-header::after {
    content: '◆◆◆';
    position: absolute;
    bottom: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--vintage-cream);
    padding: 0 15px;
    color: var(--vintage-gold);
    font-size: 1rem;
    letter-spacing: 8px;
  }

  .vintage-orders-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 2.5rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 4px;
    margin: 0;
  }

  .vintage-orders-subtitle {
    font-family: 'Crimson Text', serif;
    font-size: 1.1rem;
    color: var(--vintage-brown);
    font-style: italic;
    margin-top: 0.5rem;
  }

  .vintage-table-wrapper {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 0 8px 25px rgba(44, 24, 16, 0.2);
    overflow: hidden;
    position: relative;
  }

  .vintage-table-wrapper::before,
  .vintage-table-wrapper::after {
    content: '❦';
    position: absolute;
    top: 15px;
    color: var(--vintage-gold);
    font-size: 1.5rem;
    z-index: 1;
  }

  .vintage-table-wrapper::before {
    left: 15px;
  }

  .vintage-table-wrapper::after {
    right: 15px;
  }

  .vintage-table-container {
    overflow-x: auto;
    padding: 1.5rem;
  }

  .vintage-orders-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Crimson Text', serif;
  }

  .vintage-orders-table thead {
    background: linear-gradient(to bottom, var(--vintage-dark) 0%, #3d2416 100%);
    border-bottom: 2px solid var(--vintage-gold);
  }

  .vintage-orders-table thead th {
    font-family: 'Cinzel', serif;
    font-size: 0.9rem;
    color: var(--vintage-gold);
    text-transform: uppercase;
    letter-spacing: 2px;
    padding: 1.25rem 1rem;
    text-align: left;
    font-weight: 600;
  }

  .vintage-orders-table tbody tr {
    border-bottom: 1px solid var(--vintage-border);
    transition: background 0.3s ease;
  }

  .vintage-orders-table tbody tr:hover {
    background: var(--vintage-cream);
  }

  .vintage-orders-table tbody tr:last-child {
    border-bottom: none;
  }

  .vintage-orders-table tbody td {
    padding: 1.25rem 1rem;
    color: var(--vintage-dark);
    font-size: 1rem;
    vertical-align: middle;
  }

  .order-id {
    font-family: 'Cinzel', serif;
    font-weight: 700;
    color: var(--vintage-brown);
    font-size: 1.05rem;
  }

  .order-user {
    font-weight: 600;
    color: var(--vintage-dark);
  }

  .order-amount {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    color: var(--vintage-gold);
    font-size: 1.1rem;
  }

  .order-status {
    display: inline-block;
    padding: 0.4rem 1rem;
    border: 2px solid;
    font-family: 'Crimson Text', serif;
    font-size: 0.9rem;
    text-transform: capitalize;
    font-weight: 600;
  }

  .order-status.paid {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    border-color: #4caf50;
  }

  .order-status.pending {
    background: rgba(237, 108, 2, 0.1);
    color: #e65100;
    border-color: #ff9800;
  }

  .order-status.failed {
    background: rgba(198, 40, 40, 0.1);
    color: #c62828;
    border-color: #ef5350;
  }

  .order-date {
    font-family: 'Crimson Text', serif;
    color: var(--vintage-brown);
    font-size: 0.95rem;
  }

  .empty-state {
    padding: 4rem 2rem;
    text-align: center;
    font-family: 'Crimson Text', serif;
    color: var(--vintage-brown);
    font-size: 1.2rem;
    font-style: italic;
  }

  .empty-state::before {
    content: '◇';
    display: block;
    font-size: 3rem;
    color: var(--vintage-gold);
    margin-bottom: 1rem;
  }

  @media (max-width: 768px) {
    .vintage-orders-title {
      font-size: 1.8rem;
      letter-spacing: 2px;
    }

    .vintage-orders-table thead th {
      font-size: 0.75rem;
      padding: 1rem 0.5rem;
    }

    .vintage-orders-table tbody td {
      padding: 1rem 0.5rem;
      font-size: 0.9rem;
    }
  }

  /* Google Fonts Import */
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
</style>

<div class="vintage-orders-wrapper">
  <div class="vintage-orders-container">
    <div class="vintage-orders-header">
      <h4 class="vintage-orders-title">Orders</h4>
      <p class="vintage-orders-subtitle">Transaction Records</p>
    </div>

    <div class="vintage-table-wrapper">
      <?php if (empty($orders)): ?>
        <div class="empty-state">No orders have been placed yet.</div>
      <?php else: ?>
        <div class="vintage-table-container">
          <table class="vintage-orders-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Created</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $o): ?>
                <tr>
                  <td class="order-id">#<?php echo $o['id']; ?></td>
                  <td class="order-user"><?php echo htmlspecialchars($o['uname']); ?></td>
                  <td class="order-amount"><?php echo '₹' . number_format($o['amount']/100, 2); ?></td>
                  <td>
                    <span class="order-status <?php echo strtolower($o['status']); ?>">
                      <?php echo htmlspecialchars($o['status']); ?>
                    </span>
                  </td>
                  <td class="order-date"><?php echo htmlspecialchars($o['created_at']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
