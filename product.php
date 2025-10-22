<?php
require_once __DIR__ . '/functions.php';
$id = (int)($_GET['id'] ?? 0);
$product = Product::find($id);
if (!$product) { http_response_code(404); echo 'Not found'; exit; }
$err = '';
if (($_POST['action'] ?? '') === 'add_to_cart') {
    if (!User::isLoggedIn()) {
        $err = 'Please login to add items to your cart.';
    } else {
        Cart::add($id, 1);
        header('Location: ' . BASE_URL . '/cart.php');
        exit;
    }
}
include __DIR__ . '/layout/header.php';
?>
<style>
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-product-wrapper {
    background: linear-gradient(to bottom, var(--vintage-cream) 0%, #ebe4d1 100%);
    padding: 2.5rem 1rem;
    min-height: 100vh;
  }

  .vintage-product-card {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 0 8px 20px rgba(44, 24, 16, 0.2);
    position: relative;
    padding: 2rem;
  }

  .vintage-product-title {
    font-family: 'Cinzel', 'Georgia', serif;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 0.75rem;
  }

  .vintage-product-price {
    font-family: 'Cinzel', serif;
    color: var(--vintage-gold);
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 1rem;
  }

  .vintage-product-desc {
    font-family: 'Crimson Text', serif;
    color: var(--vintage-brown);
    font-size: 1.05rem;
  }

  .vintage-add-btn {
    font-family: 'Crimson Text', serif;
    padding: 0.7rem 1.4rem;
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border: 2px solid var(--vintage-dark);
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.95rem;
  }

  .vintage-add-btn:hover:enabled {
    background: var(--vintage-gold);
    color: var(--vintage-dark);
    border-color: var(--vintage-gold);
    transform: translateY(-1px);
  }

  .vintage-img {
    width: 100%;
    height: auto;
    object-fit: cover;
    border: 2px solid var(--vintage-border);
    box-shadow: 0 4px 12px rgba(44, 24, 16, 0.2);
  }

  .vintage-alert {
    background: #fff;
    border: 2px solid var(--vintage-border);
    border-left: 5px solid var(--vintage-gold);
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    font-family: 'Crimson Text', serif;
    color: var(--vintage-brown);
  }
</style>
<div class="vintage-product-wrapper">
  <div class="container">
    <?php if ($err): ?>
      <div class="vintage-alert"><?php echo htmlspecialchars($err); ?></div>
    <?php endif; ?>
    <div class="vintage-product-card">
      <div class="row g-4">
        <div class="col-md-6">
          <img src="<?php echo $product['image'] ? BASE_URL . '/uploads/' . htmlspecialchars($product['image']) : 'https://placehold.co/800x600?text=Retrova'; ?>" class="vintage-img" alt="<?php echo htmlspecialchars($product['title']); ?>">
        </div>
        <div class="col-md-6">
          <h3 class="vintage-product-title"><?php echo htmlspecialchars($product['title']); ?></h3>
          <div class="vintage-product-price"><?php echo formatINR($product['price']); ?></div>
          <div class="vintage-product-desc"><?php echo nl2br(htmlspecialchars($product['description'])); ?></div>
          <form method="post" class="mt-3">
            <input type="hidden" name="action" value="add_to_cart">
            <button class="vintage-add-btn" type="submit">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/layout/footer.php'; ?>
