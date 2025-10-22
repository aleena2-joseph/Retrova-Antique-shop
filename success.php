<?php
require_once __DIR__ . '/functions.php';
include __DIR__ . '/layout/header.php';
?>
<style>
  :root { --vintage-gold:#d4af37; --vintage-dark:#2c1810; --vintage-cream:#f5f1e8; --vintage-brown:#6b4423; --vintage-border:#b8956a; }
  .vintage-status-wrapper { background: linear-gradient(to bottom, var(--vintage-cream) 0%, #ebe4d1 100%); min-height: 70vh; padding: 3rem 1rem; }
  .vintage-status-card { max-width: 700px; margin: 0 auto; background:#fff; border:3px solid var(--vintage-border); box-shadow:0 8px 20px rgba(44,24,16,.2); text-align:center; padding:3rem 2rem; position:relative; }
  .vintage-status-title { font-family:'Cinzel',serif; color: var(--vintage-dark); text-transform:uppercase; letter-spacing:3px; margin-bottom: .5rem; }
  .vintage-status-sub { font-family:'Crimson Text',serif; color: var(--vintage-brown); font-size:1.05rem; }
  .vintage-primary-btn { display:inline-block; margin-top:1.5rem; padding:.8rem 1.6rem; background:var(--vintage-dark); color:var(--vintage-gold); border:2px solid var(--vintage-dark); text-decoration:none; font-family:'Cinzel',serif; letter-spacing:2px; text-transform:uppercase; transition:.3s; }
  .vintage-primary-btn:hover { background:var(--vintage-gold); color:var(--vintage-dark); border-color:var(--vintage-gold); transform: translateY(-2px); }
</style>
<div class="vintage-status-wrapper">
  <div class="vintage-status-card">
    <h4 class="vintage-status-title">Payment Successful</h4>
    <p class="vintage-status-sub">Your order has been placed.</p>
    <a class="vintage-primary-btn" href="<?php echo BASE_URL; ?>/">Continue Shopping</a>
  </div>
</div>
<?php include __DIR__ . '/layout/footer.php'; ?>
