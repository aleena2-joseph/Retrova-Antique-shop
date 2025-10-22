<?php
require_once __DIR__ . '/functions.php';
$err = '';
if (isset($_POST['remove'])) {
    $pid = (int)($_POST['remove'] ?? 0);
    if (!User::isLoggedIn()) {
        $err = 'Please login to update your cart.';
    } else {
        Cart::remove($pid);
        header('Location: ' . BASE_URL . '/cart.php');
        exit;
    }
}
if (isset($_POST['update'])) {
    if (!User::isLoggedIn()) {
        $err = 'Please login to update your cart.';
    } else {
        Cart::update($_POST['qty'] ?? []);
        header('Location: ' . BASE_URL . '/cart.php');
        exit;
    }
}
$items = Cart::items();
$total = Cart::total();
include __DIR__ . '/layout/header.php';
?>

<style>
  /* Vintage Cart Page Styling */
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-cart-wrapper {
    background: linear-gradient(to bottom, var(--vintage-cream) 0%, #ebe4d1 100%);
    min-height: 100vh;
    padding: 2.5rem 1rem;
  }

  .vintage-cart-container {
    max-width: 1200px;
    margin: 0 auto;
  }

  .vintage-cart-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 3px double var(--vintage-gold);
    position: relative;
  }

  .vintage-cart-header::after {
    content: '✦';
    position: absolute;
    bottom: -18px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--vintage-cream);
    padding: 0 15px;
    color: var(--vintage-gold);
    font-size: 2rem;
  }

  .vintage-cart-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 2.5rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 4px;
    margin: 0;
  }

  .vintage-cart-subtitle {
    font-family: 'Crimson Text', serif;
    font-size: 1.1rem;
    color: var(--vintage-brown);
    font-style: italic;
    margin-top: 0.5rem;
  }

  .vintage-empty-cart {
    background: #fff;
    border: 3px solid var(--vintage-border);
    padding: 4rem 2rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(44, 24, 16, 0.15);
    position: relative;
  }

  .vintage-empty-cart::before {
    content: '◇';
    display: block;
    font-size: 4rem;
    color: var(--vintage-gold);
    margin-bottom: 1rem;
  }

  .vintage-empty-text {
    font-family: 'Crimson Text', serif;
    font-size: 1.3rem;
    color: var(--vintage-brown);
    font-style: italic;
  }

  .vintage-cart-form {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 0 8px 25px rgba(44, 24, 16, 0.2);
    overflow: hidden;
  }

  .vintage-table-wrapper {
    overflow-x: auto;
    padding: 1.5rem;
  }

  .vintage-cart-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Crimson Text', serif;
  }

  .vintage-cart-table thead {
    background: linear-gradient(to bottom, var(--vintage-dark) 0%, #3d2416 100%);
    border-bottom: 2px solid var(--vintage-gold);
  }

  .vintage-cart-table thead th {
    font-family: 'Cinzel', serif;
    font-size: 0.9rem;
    color: var(--vintage-gold);
    text-transform: uppercase;
    letter-spacing: 2px;
    padding: 1.25rem 1rem;
    text-align: left;
    font-weight: 600;
  }

  .vintage-cart-table tbody tr {
    border-bottom: 1px solid var(--vintage-border);
    transition: background 0.3s ease;
  }

  .vintage-cart-table tbody tr:hover {
    background: var(--vintage-cream);
  }

  .vintage-cart-table tbody td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
    color: var(--vintage-dark);
  }

  .product-cell {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .product-image {
    width: 90px;
    height: 68px;
    object-fit: cover;
    border: 2px solid var(--vintage-border);
    box-shadow: 0 2px 8px rgba(44, 24, 16, 0.2);
    flex-shrink: 0;
  }

  .product-info {
    flex: 1;
  }

  .product-title {
    font-family: 'Cinzel', serif;
    font-size: 1.1rem;
    color: var(--vintage-dark);
    font-weight: 600;
    margin: 0;
  }

  .vintage-qty-input {
    width: 100%;
    max-width: 100px;
    padding: 0.6rem 0.75rem;
    border: 2px solid var(--vintage-border);
    background: var(--vintage-cream);
    font-family: 'Cinzel', serif;
    font-size: 1rem;
    color: var(--vintage-dark);
    text-align: center;
    transition: all 0.3s ease;
  }

  .vintage-qty-input:focus {
    outline: none;
    border-color: var(--vintage-gold);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
  }

  .price-cell,
  .total-cell {
    font-family: 'Cinzel', serif;
    font-size: 1.1rem;
    color: var(--vintage-brown);
    font-weight: 600;
  }

  .vintage-cart-table tfoot {
    background: linear-gradient(to bottom, #fff 0%, var(--vintage-cream) 100%);
    border-top: 3px double var(--vintage-gold);
  }

  .vintage-cart-table tfoot th {
    font-family: 'Cinzel', serif;
    padding: 1.5rem 1rem;
    font-size: 1.2rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 2px;
  }

  .grand-total {
    font-size: 1.5rem !important;
    color: var(--vintage-gold) !important;
    font-weight: 700;
  }

  .vintage-cart-actions {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    padding: 2rem;
    background: linear-gradient(to bottom, #fff 0%, var(--vintage-cream) 100%);
    border-top: 2px solid var(--vintage-border);
  }

  .vintage-update-btn,
  .vintage-checkout-btn {
    font-family: 'Cinzel', serif;
    padding: 1rem 2.5rem;
    border: 2px solid;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    cursor: pointer;
    display: inline-block;
  }

  .vintage-update-btn {
    background: #fff;
    color: var(--vintage-brown);
    border-color: var(--vintage-border);
  }

  .vintage-update-btn:hover {
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border-color: var(--vintage-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(44, 24, 16, 0.3);
  }

  .vintage-checkout-btn {
    background: var(--vintage-gold);
    color: var(--vintage-dark);
    border-color: var(--vintage-gold);
    font-weight: 600;
  }

  .vintage-checkout-btn:hover {
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border-color: var(--vintage-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
  }

  @media (max-width: 768px) {
    .vintage-cart-title {
      font-size: 1.8rem;
      letter-spacing: 2px;
    }

    .product-cell {
      flex-direction: column;
      align-items: flex-start;
    }

    .product-image {
      width: 100%;
      height: auto;
      aspect-ratio: 4/3;
    }

    .vintage-cart-table thead th {
      font-size: 0.75rem;
      padding: 1rem 0.5rem;
    }

    .vintage-cart-table tbody td {
      padding: 1rem 0.5rem;
      font-size: 0.9rem;
    }

    .vintage-cart-actions {
      flex-direction: column;
    }

    .vintage-update-btn,
    .vintage-checkout-btn {
      width: 100%;
      text-align: center;
    }

    .vintage-qty-input {
      max-width: 80px;
    }
  }

  /* Google Fonts Import */
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
</style>

<div class="vintage-cart-wrapper">
  <div class="vintage-cart-container">
    <div class="vintage-cart-header">
      <h4 class="vintage-cart-title">Your Cart</h4>
      <p class="vintage-cart-subtitle">Selected Treasures Awaiting Acquisition</p>
    </div>

    <?php if ($err): ?>
      <div class="alert alert-warning"><?php echo htmlspecialchars($err); ?></div>
    <?php endif; ?>

    <?php if (!$items): ?>
      <div class="vintage-empty-cart">
        <p class="vintage-empty-text">Your cart is empty.</p>
      </div>
    <?php else: ?>
      <form method="post">
        <div class="vintage-cart-form">
          <div class="vintage-table-wrapper">
            <table class="vintage-cart-table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th style="width:120px">Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
                  <th style="width:110px">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($items as $it): ?>
                  <tr>
                    <td>
                      <div class="product-cell">
                        <img src="<?php echo $it['image'] ? BASE_URL . '/uploads/' . htmlspecialchars($it['image']) : 'https://placehold.co/80x60'; ?>" class="product-image" alt="<?php echo htmlspecialchars($it['title']); ?>">
                        <div class="product-info">
                          <div class="product-title"><?php echo htmlspecialchars($it['title']); ?></div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <input class="vintage-qty-input" type="number" min="0" name="qty[<?php echo $it['id']; ?>]" value="<?php echo (int)$it['qty']; ?>">
                    </td>
                    <td class="price-cell"><?php echo formatINR($it['price']); ?></td>
                    <td class="total-cell"><?php echo formatINR($it['total']); ?></td>
                    <td>
                      <form method="post" style="display:inline">
                        <button class="btn btn-sm btn-outline-danger" name="remove" value="<?php echo (int)$it['id']; ?>" <?php echo User::isLoggedIn() ? '' : 'disabled'; ?>>Remove</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" style="text-align: right;">Grand Total</th>
                  <th class="grand-total"><?php echo formatINR($total); ?></th>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="vintage-cart-actions">
            <button class="vintage-update-btn" name="update" value="1" <?php echo User::isLoggedIn() ? '' : 'disabled'; ?>>Update Cart</button>
            <a class="vintage-checkout-btn" href="<?php echo BASE_URL; ?>/checkout.php">Proceed to Checkout</a>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>