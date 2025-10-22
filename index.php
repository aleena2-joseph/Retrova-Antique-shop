<?php
require_once __DIR__ . '/functions.php';
$q = trim($_GET['q'] ?? '');
$cat = $_GET['cat'] ?? '';
$categories = Category::all();
$products = Product::search($q, $cat !== '' ? (int)$cat : null);
include __DIR__ . '/layout/header.php';
?>

<style>
  /* Vintage Antique Store Styling */
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-container {
    background: linear-gradient(to bottom, var(--vintage-cream) 0%, #ebe4d1 100%);
    padding: 2.5rem 1rem;
    min-height: 100vh;
  }

  .vintage-header {
    text-align: center;
    margin-bottom: 3rem;
    border-bottom: 3px double var(--vintage-gold);
    padding-bottom: 2rem;
  }

  .vintage-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 2.5rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
  }

  .vintage-subtitle {
    font-family: 'Crimson Text', 'Times New Roman', serif;
    font-size: 1.1rem;
    color: var(--vintage-brown);
    font-style: italic;
  }

  .category-section {
    background: #fff;
    border: 2px solid var(--vintage-border);
    border-radius: 0;
    padding: 1.5rem;
    margin-bottom: 2.5rem;
    box-shadow: 0 4px 15px rgba(44, 24, 16, 0.15);
    position: relative;
  }

  .category-section::before,
  .category-section::after {
    content: '❦';
    position: absolute;
    top: -15px;
    background: var(--vintage-cream);
    padding: 0 15px;
    color: var(--vintage-gold);
    font-size: 1.5rem;
  }

  .category-section::before {
    left: 20px;
  }

  .category-section::after {
    right: 20px;
  }

  .category-label {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 1rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 1rem;
    display: block;
    text-align: center;
  }

  .vintage-btn-group {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: center;
  }

  .vintage-btn {
    font-family: 'Crimson Text', serif;
    font-size: 1rem;
    padding: 0.5rem 1.5rem;
    border: 2px solid var(--vintage-border);
    background: #fff;
    color: var(--vintage-dark);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    text-transform: capitalize;
  }

  .vintage-btn:hover {
    background: var(--vintage-gold);
    border-color: var(--vintage-gold);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  }

  .vintage-btn.active {
    background: var(--vintage-dark);
    border-color: var(--vintage-dark);
    color: var(--vintage-gold);
  }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    padding: 1rem 0;
  }

  .vintage-card {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 0 8px 20px rgba(44, 24, 16, 0.2);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
  }

  .vintage-card::before {
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
    z-index: 1;
  }

  .vintage-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(44, 24, 16, 0.3);
  }

  .vintage-card:hover::before {
    opacity: 1;
  }

  .card-image-wrapper {
    position: relative;
    overflow: hidden;
    aspect-ratio: 3/4;
    background: var(--vintage-cream);
  }

  .card-image-wrapper::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 60%, rgba(44, 24, 16, 0.3) 100%);
  }

  .vintage-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
    filter: sepia(0.2) contrast(1.1);
  }

  .vintage-card:hover img {
    transform: scale(1.08);
  }

  .vintage-card-body {
    padding: 1.5rem;
    background: linear-gradient(to bottom, #fff 0%, var(--vintage-cream) 100%);
  }

  .vintage-card-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 1.1rem;
    color: var(--vintage-dark);
    margin-bottom: 0.5rem;
    line-height: 1.4;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .vintage-category {
    font-family: 'Crimson Text', serif;
    font-size: 0.9rem;
    color: var(--vintage-brown);
    font-style: italic;
    margin-bottom: 1rem;
    text-transform: capitalize;
  }

  .vintage-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 1rem;
    border-top: 1px solid var(--vintage-border);
  }

  .vintage-price {
    font-family: 'Cinzel', serif;
    font-size: 1.3rem;
    color: var(--vintage-gold);
    font-weight: bold;
  }

  .vintage-add-btn {
    font-family: 'Crimson Text', serif;
    padding: 0.5rem 1.2rem;
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border: 2px solid var(--vintage-dark);
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.9rem;
  }

  .vintage-add-btn:hover {
    background: var(--vintage-gold);
    color: var(--vintage-dark);
    border-color: var(--vintage-gold);
    transform: scale(1.05);
  }

  .vintage-alert {
    background: #fff;
    border: 2px solid var(--vintage-border);
    border-left: 5px solid var(--vintage-gold);
    padding: 2rem;
    text-align: center;
    font-family: 'Crimson Text', serif;
    font-size: 1.2rem;
    color: var(--vintage-brown);
    box-shadow: 0 4px 15px rgba(44, 24, 16, 0.1);
  }

  @media (max-width: 768px) {
    .vintage-title {
      font-size: 1.8rem;
    }
    
    .products-grid {
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.5rem;
    }
  }

  /* Google Fonts Import */
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
</style>

<div class="vintage-container">
  <div class="container">
    <div class="vintage-header">
      <h1 class="vintage-title">Collection</h1>
      <p class="vintage-subtitle">Timeless Treasures from Bygone Eras</p>
    </div>

    <div class="category-section">
      <span class="category-label">Browse by Category</span>
      <div class="vintage-btn-group">
        <a class="vintage-btn <?php echo $cat==''?'active':''; ?>" href="?<?php echo http_build_query(['q'=>$q]); ?>">All</a>
        <?php foreach ($categories as $c): ?>
          <a class="vintage-btn <?php echo $cat==$c['id']?'active':''; ?>" href="?<?php echo http_build_query(['q'=>$q,'cat'=>$c['id']]); ?>"><?php echo htmlspecialchars($c['name']); ?></a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="products-grid">
      <?php foreach ($products as $p): ?>
        <div class="vintage-card">
          <a href="product.php?id=<?php echo $p['id']; ?>" style="text-decoration: none; color: inherit;">
            <div class="card-image-wrapper">
              <img src="<?php echo $p['image'] ? BASE_URL . '/uploads/' . htmlspecialchars($p['image']) : 'https://placehold.co/600x400?text=Retrova'; ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
            </div>
          </a>
          <div class="vintage-card-body">
            <h6 class="vintage-card-title"><?php echo htmlspecialchars($p['title']); ?></h6>
            <div class="vintage-category"><?php echo htmlspecialchars($p['category_name'] ?? ''); ?></div>
            <div class="vintage-card-footer">
              <div class="vintage-price"><?php echo formatINR($p['price']); ?></div>
              <form method="post" action="product.php?id=<?php echo $p['id']; ?>">
                <input type="hidden" name="action" value="add_to_cart">
                <button class="vintage-add-btn" type="submit">Add</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if (!$products): ?>
      <div class="vintage-alert">No products found.</div>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>