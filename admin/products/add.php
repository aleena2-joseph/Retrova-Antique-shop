<?php
require_once __DIR__ . '/../../functions.php';
requireAdmin();
$cats = Category::all();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $cat = $_POST['category_id'] ?: null;
    $imgName = null;
    if (!empty($_FILES['image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $imgName = uniqid('img_') . '.' . $ext;
        @mkdir(__DIR__ . '/../../uploads', 0777, true);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../uploads/' . $imgName);
    }
    if ($title && $price >= 0) {
        Product::create($title, $desc, $price, $stock, $imgName, $cat);
        header('Location: index.php'); exit;
    } else { $err = 'Invalid input'; }
}
include __DIR__ . '/../../layout/header.php';
?>

<style>
  /* Vintage Product Form Styling */
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-form-wrapper {
    background: linear-gradient(to bottom, var(--vintage-cream) 0%, #ebe4d1 100%);
    min-height: 100vh;
    padding: 2.5rem 1rem;
  }

  .vintage-form-container {
    max-width: 900px;
    margin: 0 auto;
  }

  .vintage-form-header {
    text-align: center;
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 3px double var(--vintage-gold);
    position: relative;
  }

  .vintage-form-header::after {
    content: '❧';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--vintage-cream);
    padding: 0 12px;
    color: var(--vintage-gold);
    font-size: 1.8rem;
  }

  .vintage-form-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 2rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 3px;
    margin: 0;
  }

  .vintage-alert {
    background: #fff;
    border: 2px solid #d32f2f;
    border-left: 5px solid #d32f2f;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    font-family: 'Crimson Text', serif;
    color: #c62828;
    font-size: 0.95rem;
    box-shadow: 0 2px 8px rgba(211, 47, 47, 0.1);
  }

  .vintage-form-card {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 0 8px 25px rgba(44, 24, 16, 0.2);
    padding: 2.5rem;
    position: relative;
  }

  .vintage-form-card::before,
  .vintage-form-card::after {
    content: '◆';
    position: absolute;
    top: 15px;
    color: var(--vintage-gold);
    font-size: 1.5rem;
  }

  .vintage-form-card::before {
    left: 15px;
  }

  .vintage-form-card::after {
    right: 15px;
  }

  .form-row {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .form-col-8 {
    grid-column: span 8;
  }

  .form-col-4 {
    grid-column: span 4;
  }

  .form-col-12 {
    grid-column: span 12;
  }

  .vintage-form-label {
    font-family: 'Cinzel', serif;
    font-size: 0.85rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 0.5rem;
    display: block;
  }

  .vintage-form-input,
  .vintage-form-select,
  .vintage-form-textarea {
    width: 100%;
    padding: 0.85rem 1rem;
    border: 2px solid var(--vintage-border);
    background: var(--vintage-cream);
    font-family: 'Crimson Text', serif;
    font-size: 1rem;
    color: var(--vintage-dark);
    transition: all 0.3s ease;
  }

  .vintage-form-input:focus,
  .vintage-form-select:focus,
  .vintage-form-textarea:focus {
    outline: none;
    border-color: var(--vintage-gold);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
  }

  .vintage-form-textarea {
    resize: vertical;
    min-height: 120px;
  }

  .vintage-form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--vintage-border);
  }

  .vintage-btn-submit,
  .vintage-btn-cancel {
    font-family: 'Cinzel', serif;
    padding: 0.9rem 2.5rem;
    border: 2px solid;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .vintage-btn-submit {
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border-color: var(--vintage-dark);
  }

  .vintage-btn-submit:hover {
    background: var(--vintage-gold);
    color: var(--vintage-dark);
    border-color: var(--vintage-gold);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44, 24, 16, 0.3);
  }

  .vintage-btn-cancel {
    background: #fff;
    color: var(--vintage-brown);
    border-color: var(--vintage-border);
  }

  .vintage-btn-cancel:hover {
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border-color: var(--vintage-dark);
    transform: translateY(-2px);
  }

  @media (max-width: 768px) {
    .vintage-form-title {
      font-size: 1.5rem;
    }

    .vintage-form-card {
      padding: 2rem 1.5rem;
    }

    .form-row {
      grid-template-columns: 1fr;
    }

    .form-col-8,
    .form-col-4,
    .form-col-12 {
      grid-column: span 12;
    }

    .vintage-form-actions {
      flex-direction: column;
    }

    .vintage-btn-submit,
    .vintage-btn-cancel {
      width: 100%;
      text-align: center;
    }
  }

  /* Google Fonts Import */
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
</style>

<div class="vintage-form-wrapper">
  <div class="vintage-form-container">
    <div class="vintage-form-header">
      <h4 class="vintage-form-title">Add Product</h4>
    </div>

    <?php if ($err): ?>
      <div class="vintage-alert"><?php echo htmlspecialchars($err); ?></div>
    <?php endif; ?>

    <div class="vintage-form-card">
      <form method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-col-8">
            <label class="vintage-form-label">Title</label>
            <input class="vintage-form-input" name="title" required>
          </div>
          <div class="form-col-4">
            <label class="vintage-form-label">Category</label>
            <select class="vintage-form-select" name="category_id">
              <option value="">None</option>
              <?php foreach ($cats as $c): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-col-12">
            <label class="vintage-form-label">Description</label>
            <textarea class="vintage-form-textarea" name="description" rows="5"></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="form-col-4">
            <label class="vintage-form-label">Price (₹)</label>
            <input class="vintage-form-input" type="number" step="0.01" name="price" required>
          </div>
          <div class="form-col-4">
            <label class="vintage-form-label">Stock</label>
            <input class="vintage-form-input" type="number" name="stock" required>
          </div>
          <div class="form-col-4">
            <label class="vintage-form-label">Image</label>
            <input class="vintage-form-input" type="file" name="image" accept="image/*">
          </div>
        </div>

        <div class="vintage-form-actions">
          <button class="vintage-btn-submit" type="submit">Create Product</button>
          <a class="vintage-btn-cancel" href="index.php">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>
