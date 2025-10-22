<?php
require_once __DIR__ . '/functions.php';
requireLogin();
$items = Cart::items();
if (!$items) { header('Location: ' . BASE_URL . '/cart.php'); exit; }
$total = Cart::total();
include __DIR__ . '/layout/header.php';
?>

<style>
  /* Vintage Checkout Page Styling */
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-checkout-wrapper {
    background: linear-gradient(135deg, #f5f1e8 0%, #e8dcc4 50%, #f5f1e8 100%);
    min-height: 100vh;
    padding: 3rem 1rem;
    position: relative;
  }

  .vintage-checkout-wrapper::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: 
      radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
      radial-gradient(circle at 80% 70%, rgba(107, 68, 35, 0.05) 0%, transparent 50%);
    pointer-events: none;
  }

  .vintage-checkout-container {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
  }

  .vintage-page-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 2.5rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 4px;
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
    padding-bottom: 1.5rem;
  }

  .vintage-page-title::after {
    content: '◆◆◆';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    color: var(--vintage-gold);
    font-size: 1rem;
    letter-spacing: 8px;
  }

  .vintage-checkout-card {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 
      0 10px 40px rgba(44, 24, 16, 0.25),
      inset 0 0 0 1px rgba(212, 175, 55, 0.1);
    padding: 2.5rem;
    position: relative;
    margin-bottom: 2rem;
  }

  /* Decorative corners */
  .vintage-checkout-card::before,
  .vintage-checkout-card::after {
    content: '◆';
    position: absolute;
    color: var(--vintage-gold);
    font-size: 1.5rem;
    line-height: 1;
  }

  .vintage-checkout-card::before {
    top: 15px;
    left: 15px;
  }

  .vintage-checkout-card::after {
    top: 15px;
    right: 15px;
  }

  .corner-bottom::before,
  .corner-bottom::after {
    content: '◆';
    position: absolute;
    color: var(--vintage-gold);
    font-size: 1.5rem;
    line-height: 1;
    bottom: 15px;
  }

  .corner-bottom::before {
    left: 15px;
  }

  .corner-bottom::after {
    right: 15px;
  }

  .vintage-card-title {
    font-family: 'Cinzel', serif;
    font-size: 1.5rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--vintage-border);
    position: relative;
  }

  .vintage-card-title::after {
    content: '❦';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    padding: 0 12px;
    color: var(--vintage-gold);
    font-size: 1.5rem;
  }

  .vintage-order-list {
    list-style: none;
    padding: 0;
    margin: 2rem 0 0 0;
  }

  .vintage-order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1rem;
    border-bottom: 1px solid var(--vintage-border);
    font-family: 'Crimson Text', serif;
    font-size: 1.05rem;
    color: var(--vintage-dark);
    transition: background 0.3s ease;
  }

  .vintage-order-item:hover {
    background: var(--vintage-cream);
  }

  .vintage-order-item:last-child {
    border-bottom: none;
  }

  .vintage-order-item.total-row {
    background: var(--vintage-cream);
    border-top: 3px double var(--vintage-gold);
    border-bottom: 3px double var(--vintage-gold);
    padding: 1.5rem 1rem;
    margin-top: 1rem;
    font-weight: 600;
  }

  .item-name {
    flex: 1;
    font-weight: 500;
  }

  .item-price {
    font-family: 'Cinzel', serif;
    color: var(--vintage-brown);
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  .total-row .item-name,
  .total-row .item-price {
    font-family: 'Cinzel', serif;
    font-size: 1.25rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 2px;
  }

  .vintage-pay-btn {
    width: 100%;
    padding: 1.25rem;
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border: 2px solid var(--vintage-dark);
    font-family: 'Cinzel', serif;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 3px;
    cursor: pointer;
    transition: all 0.4s ease;
    margin-top: 2rem;
    position: relative;
    overflow: hidden;
  }

  .vintage-pay-btn::before {
    content: '◆';
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1rem;
    transition: all 0.4s ease;
  }

  .vintage-pay-btn::after {
    content: '◆';
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1rem;
    transition: all 0.4s ease;
  }

  .vintage-pay-btn:hover {
    background: var(--vintage-gold);
    color: var(--vintage-dark);
    border-color: var(--vintage-gold);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(44, 24, 16, 0.3);
  }

  .vintage-pay-btn:hover::before {
    left: 15px;
  }

  .vintage-pay-btn:hover::after {
    right: 15px;
  }

  .vintage-pay-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
  }

  .pattern-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: repeating-linear-gradient(
      45deg,
      transparent,
      transparent 10px,
      rgba(212, 175, 55, 0.02) 10px,
      rgba(212, 175, 55, 0.02) 20px
    );
    pointer-events: none;
  }

  .vintage-security-note {
    text-align: center;
    margin-top: 2rem;
    padding: 1rem;
    background: rgba(212, 175, 55, 0.1);
    border: 1px solid var(--vintage-border);
    font-family: 'Crimson Text', serif;
    font-size: 0.9rem;
    color: var(--vintage-brown);
    font-style: italic;
  }

  .vintage-security-note::before {
    content: '🔒 ';
    font-style: normal;
  }

  @media (max-width: 768px) {
    .vintage-checkout-card {
      padding: 2rem 1.5rem;
    }

    .vintage-page-title {
      font-size: 2rem;
    }

    .vintage-card-title {
      font-size: 1.25rem;
    }

    .vintage-order-item {
      padding: 1rem 0.5rem;
      font-size: 0.95rem;
    }

    .vintage-pay-btn::before,
    .vintage-pay-btn::after {
      display: none;
    }
  }

  /* Google Fonts Import */
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
</style>

<div class="vintage-checkout-wrapper">
  <div class="vintage-checkout-container">
    <h4 class="vintage-page-title">Checkout</h4>
    
    <div class="vintage-checkout-card corner-bottom">
      <div class="pattern-overlay"></div>
      
      <h6 class="vintage-card-title">Order Summary</h6>
      
      <ul class="vintage-order-list">
        <?php foreach ($items as $it): ?>
          <li class="vintage-order-item">
            <span class="item-name">
              <?php echo htmlspecialchars($it['title']); ?> × <?php echo (int)$it['qty']; ?>
            </span>
            <span class="item-price"><?php echo formatINR($it['total']); ?></span>
          </li>
        <?php endforeach; ?>
        
        <li class="vintage-order-item total-row">
          <span class="item-name">Total</span>
          <span class="item-price"><?php echo formatINR($total); ?></span>
        </li>
      </ul>
      
      <button id="payBtn" class="vintage-pay-btn">Pay with Razorpay</button>
      
      <div class="vintage-security-note">
        Secure payment processing powered by Razorpay
      </div>
    </div>
  </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
const payBtn = document.getElementById('payBtn');
payBtn.addEventListener('click', async () => {
  payBtn.disabled = true;
  payBtn.textContent = 'Processing...';
  
  const res = await fetch('<?php echo BASE_URL; ?>/api/create_order.php', { method: 'POST' });
  const data = await res.json();
  
  if (!data || !data.id) { 
    alert('Failed to create order'); 
    payBtn.disabled = false; 
    payBtn.textContent = 'Pay with Razorpay';
    return; 
  }
  
  const options = {
    key: '<?php echo RAZORPAY_KEY_ID; ?>',
    amount: data.amount,
    currency: data.currency,
    name: 'Retrova',
    description: 'Antique purchase',
    order_id: data.id,
    handler: async function (response) {
      const verifyRes = await fetch('<?php echo BASE_URL; ?>/api/verify_payment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(response)
      });
      const v = await verifyRes.json();
      if (v && v.success) window.location.href = '<?php echo BASE_URL; ?>/success.php';
      else window.location.href = '<?php echo BASE_URL; ?>/failure.php';
    },
    prefill: {
      name: '<?php echo htmlspecialchars($_SESSION['user']['name'] ?? ''); ?>',
      email: '<?php echo htmlspecialchars($_SESSION['user']['email'] ?? ''); ?>'
    },
    theme: { color: '#d4af37' },
    modal: {
      ondismiss: function() {
        payBtn.disabled = false;
        payBtn.textContent = 'Pay with Razorpay';
      }
    }
  };
  
  const rzp = new Razorpay(options);
  rzp.open();
  payBtn.disabled = false;
  payBtn.textContent = 'Pay with Razorpay';
});
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>