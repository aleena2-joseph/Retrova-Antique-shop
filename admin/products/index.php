<?php
require_once __DIR__ . '/../../functions.php';
requireAdmin();
$products = Product::getAllWithCategory();
include __DIR__ . '/../../layout/header.php';
?>

<style>
  /* Vintage Admin Products Page Styling */
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-admin-wrapper {
    background: linear-gradient(to bottom, var(--vintage-cream) 0%, #ebe4d1 100%);
    min-height: 100vh;
    padding: 2rem 1rem;
  }

  .vintage-admin-container {
    max-width: 1400px;
    margin: 0 auto;
  }

  .vintage-admin-header {
    background: #fff;
    border: 3px solid var(--vintage-border);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(44, 24, 16, 0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    position: relative;
  }

  .vintage-admin-header::before,
  .vintage-admin-header::after {
    content: '◈';
    position: absolute;
    top: 15px;
    color: var(--vintage-gold);
    font-size: 1.5rem;
  }

  .vintage-admin-header::before {
    left: 15px;
  }

  .vintage-admin-header::after {
    right: 15px;
  }

  .vintage-admin-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 2rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 3px;
    margin: 0;
  }

  .vintage-add-btn {
    font-family: 'Cinzel', serif;
    padding: 0.75rem 2rem;
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border: 2px solid var(--vintage-dark);
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-block;
  }

  .vintage-add-btn:hover {
    background: var(--vintage-gold);
    color: var(--vintage-dark);
    border-color: var(--vintage-gold);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(44, 24, 16, 0.3);
  }

  .vintage-table-wrapper {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 0 4px 15px rgba(44, 24, 16, 0.15);
    overflow: hidden;
  }

  .vintage-table-container {
    overflow-x: auto;
  }

  .vintage-table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Crimson Text', serif;
    margin: 0;
  }

  .vintage-table thead {
    background: linear-gradient(to bottom, var(--vintage-dark) 0%, #3d2416 100%);
    border-bottom: 2px solid var(--vintage-gold);
  }

  .vintage-table thead th {
    font-family: 'Cinzel', serif;
    font-size: 0.85rem;
    color: var(--vintage-gold);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 1.25rem 1rem;
    text-align: left;
    font-weight: 600;
  }

  .vintage-table tbody tr {
    border-bottom: 1px solid var(--vintage-border);
    transition: background 0.3s ease;
  }

  .vintage-table tbody tr:hover {
    background: var(--vintage-cream);
  }

  .vintage-table tbody tr:last-child {
    border-bottom: none;
  }

  .vintage-table tbody td {
    padding: 1rem;
    color: var(--vintage-dark);
    font-size: 1rem;
    vertical-align: middle;
  }

  .vintage-table tbody td:first-child {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    color: var(--vintage-brown);
  }

  .product-image {
    width: 70px;
    height: 52px;
    object-fit: cover;
    border: 2px solid var(--vintage-border);
    box-shadow: 0 2px 8px rgba(44, 24, 16, 0.2);
  }

  .product-title {
    font-weight: 600;
    color: var(--vintage-dark);
  }

  .product-category {
    color: var(--vintage-brown);
    font-style: italic;
    font-size: 0.95rem;
  }

  .product-price {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    color: var(--vintage-gold);
    font-size: 1.05rem;
  }

  .product-stock {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    color: var(--vintage-brown);
  }

  .action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    flex-wrap: wrap;
  }

  .vintage-btn-edit,
  .vintage-btn-delete {
    font-family: 'Crimson Text', serif;
    padding: 0.4rem 1rem;
    border: 2px solid;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-transform: capitalize;
    display: inline-block;
  }

  .vintage-btn-edit {
    background: #fff;
    color: var(--vintage-brown);
    border-color: var(--vintage-border);
  }

  .vintage-btn-edit:hover {
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border-color: var(--vintage-dark);
  }

  .vintage-btn-delete {
    background: #fff;
    color: #b71c1c;
    border-color: #ef5350;
  }

  .vintage-btn-delete:hover {
    background: #b71c1c;
    color: #fff;
    border-color: #b71c1c;
  }

  .empty-state {
    padding: 3rem 2rem;
    text-align: center;
    font-family: 'Crimson Text', serif;
    color: var(--vintage-brown);
    font-size: 1.1rem;
    font-style: italic;
  }

  /* Decorative elements */
  .vintage-divider {
    height: 2px;
    background: linear-gradient(to right, transparent, var(--vintage-border), transparent);
    margin: 2rem 0;
  }

  @media (max-width: 768px) {
    .vintage-admin-header {
      flex-direction: column;
      align-items: stretch;
      text-align: center;
    }

    .vintage-admin-title {
      font-size: 1.5rem;
    }

    .vintage-add-btn {
      width: 100%;
    }

    .vintage-table thead th {
      font-size: 0.75rem;
      padding: 1rem 0.5rem;
    }

    .vintage-table tbody td {
      padding: 0.75rem 0.5rem;
      font-size: 0.9rem;
    }

    .product-image {
      width: 50px;
      height: 38px;
    }

    .action-buttons {
      flex-direction: column;
    }

    .vintage-btn-edit,
    .vintage-btn-delete {
      width: 100%;
      text-align: center;
    }
  }

  /* Google Fonts Import */
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
</style>

<div class="vintage-admin-wrapper">
  <div class="vintage-admin-container">
    <div class="vintage-admin-header">
      <h4 class="vintage-admin-title">Products</h4>
      <a class="vintage-add-btn" href="add.php">Add Product</a>
    </div>

    <div class="vintage-table-wrapper">
      <div class="vintage-table-container">
        <table class="vintage-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Title</th>
              <th>Category</th>
              <th>Price</th>
              <th>Stock</th>
              <th style="text-align: right;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
              <td><?php echo $p['id']; ?></td>
              <td>
                <img src="<?php echo $p['image'] ? BASE_URL . '/uploads/' . htmlspecialchars($p['image']) : 'https://placehold.co/60x45'; ?>" class="product-image" alt="<?php echo htmlspecialchars($p['title']); ?>">
              </td>
              <td class="product-title"><?php echo htmlspecialchars($p['title']); ?></td>
              <td class="product-category"><?php echo htmlspecialchars($p['category_name'] ?? ''); ?></td>
              <td class="product-price"><?php echo formatINR($p['price']); ?></td>
              <td class="product-stock"><?php echo (int)$p['stock']; ?></td>
              <td>
                <div class="action-buttons">
                  <a class="vintage-btn-edit" href="edit.php?id=<?php echo $p['id']; ?>">Edit</a>
                  <a class="vintage-btn-delete" href="delete.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Delete product?')">Delete</a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      
      <?php if (empty($products)): ?>
        <div class="empty-state">No products available. Add your first antique treasure.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>