<?php
require_once __DIR__ . '/functions.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $valid = true;
    if (strlen($name) < 2 || strlen($name) > 50 || !preg_match('/^[A-Za-z][A-Za-z\s\.-]{1,49}$/', $name)) { $err = 'Enter a valid name (2-50 letters).'; $valid = false; }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $err = 'Enter a valid email.'; $valid = false; }
    elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $pass)) { $err = 'Password must be at least 8 characters and include a letter and a number.'; $valid = false; }
    elseif ($pass !== $confirm) { $err = 'Passwords do not match.'; $valid = false; }
    if ($valid) {
        if (User::register($name, $email, $pass)) {
            header('Location: ' . BASE_URL . '/login.php');
            exit;
        } else {
            $err = 'Email already registered.';
        }
    }
}
include __DIR__ . '/layout/header.php';
?>

<style>
  /* Vintage Register Page Styling */
  :root {
    --vintage-gold: #d4af37;
    --vintage-dark: #2c1810;
    --vintage-cream: #f5f1e8;
    --vintage-brown: #6b4423;
    --vintage-border: #b8956a;
  }

  .vintage-register-wrapper {
    background: linear-gradient(135deg, #f5f1e8 0%, #e8dcc4 50%, #f5f1e8 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    position: relative;
  }

  .vintage-register-wrapper::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: 
      radial-gradient(circle at 30% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
      radial-gradient(circle at 70% 80%, rgba(107, 68, 35, 0.05) 0%, transparent 50%);
    pointer-events: none;
  }

  .vintage-register-container {
    max-width: 520px;
    width: 100%;
    position: relative;
    z-index: 1;
  }

  .vintage-register-card {
    background: #fff;
    border: 3px solid var(--vintage-border);
    box-shadow: 
      0 10px 40px rgba(44, 24, 16, 0.25),
      inset 0 0 0 1px rgba(212, 175, 55, 0.1);
    padding: 3rem 2.5rem;
    position: relative;
  }

  /* Decorative corners */
  .vintage-register-card::before,
  .vintage-register-card::after {
    content: '✦';
    position: absolute;
    color: var(--vintage-gold);
    font-size: 1.8rem;
    line-height: 1;
  }

  .vintage-register-card::before {
    top: 15px;
    left: 15px;
  }

  .vintage-register-card::after {
    top: 15px;
    right: 15px;
  }

  .corner-bottom-left::before,
  .corner-bottom-right::after {
    content: '✦';
    position: absolute;
    color: var(--vintage-gold);
    font-size: 1.8rem;
    line-height: 1;
  }

  .corner-bottom-left::before {
    bottom: 15px;
    left: 15px;
  }

  .corner-bottom-right::after {
    bottom: 15px;
    right: 15px;
  }

  .vintage-register-header {
    text-align: center;
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid var(--vintage-border);
    position: relative;
  }

  .vintage-register-header::after {
    content: '❧';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    padding: 0 15px;
    color: var(--vintage-gold);
    font-size: 1.8rem;
  }

  .vintage-register-title {
    font-family: 'Cinzel', 'Georgia', serif;
    font-size: 2rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 0.5rem;
  }

  .vintage-register-subtitle {
    font-family: 'Crimson Text', serif;
    font-size: 1rem;
    color: var(--vintage-brown);
    font-style: italic;
  }

  .vintage-form-group {
    margin-bottom: 1.75rem;
  }

  .vintage-label {
    font-family: 'Cinzel', serif;
    font-size: 0.85rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 0.5rem;
    display: block;
  }

  .vintage-input {
    width: 100%;
    padding: 0.85rem 1rem;
    border: 2px solid var(--vintage-border);
    background: var(--vintage-cream);
    font-family: 'Crimson Text', serif;
    font-size: 1rem;
    color: var(--vintage-dark);
    transition: all 0.3s ease;
  }

  .vintage-input:focus {
    outline: none;
    border-color: var(--vintage-gold);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
  }

  .vintage-input::placeholder {
    color: var(--vintage-brown);
    opacity: 0.5;
  }

  .vintage-submit-btn {
    width: 100%;
    padding: 1rem;
    background: var(--vintage-dark);
    color: var(--vintage-gold);
    border: 2px solid var(--vintage-dark);
    font-family: 'Cinzel', serif;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    cursor: pointer;
    transition: all 0.4s ease;
    margin-top: 1rem;
    position: relative;
    overflow: hidden;
  }

  .vintage-submit-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: var(--vintage-gold);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
    z-index: 0;
  }

  .vintage-submit-btn:hover::before {
    width: 300%;
    height: 300%;
  }

  .vintage-submit-btn:hover {
    color: var(--vintage-dark);
    border-color: var(--vintage-gold);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44, 24, 16, 0.3);
  }

  .vintage-submit-btn span {
    position: relative;
    z-index: 1;
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

  .vintage-footer-text {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--vintage-border);
    font-family: 'Crimson Text', serif;
    color: var(--vintage-brown);
    font-size: 0.95rem;
  }

  .vintage-footer-text a {
    color: var(--vintage-gold);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
  }

  .vintage-footer-text a:hover {
    color: var(--vintage-dark);
    text-decoration: underline;
  }

  /* Ornamental pattern overlay */
  .pattern-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: repeating-linear-gradient(
      -45deg,
      transparent,
      transparent 10px,
      rgba(212, 175, 55, 0.02) 10px,
      rgba(212, 175, 55, 0.02) 20px
    );
    pointer-events: none;
  }

  .password-hint {
    font-family: 'Crimson Text', serif;
    font-size: 0.85rem;
    color: var(--vintage-brown);
    font-style: italic;
    margin-top: 0.4rem;
    opacity: 0.8;
  }

  @media (max-width: 576px) {
    .vintage-register-card {
      padding: 2rem 1.5rem;
    }

    .vintage-register-title {
      font-size: 1.6rem;
    }
  }

  /* Google Fonts Import */
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
</style>

<div class="vintage-register-wrapper">
  <div class="vintage-register-container">
    <div class="vintage-register-card corner-bottom-left corner-bottom-right">
      <div class="pattern-overlay"></div>
      
      <div class="vintage-register-header">
        <h4 class="vintage-register-title">Create Account</h4>
        <p class="vintage-register-subtitle">Join Our Distinguished Collectors</p>
      </div>

      <?php if ($err): ?>
        <div class="vintage-alert"><?php echo htmlspecialchars($err); ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="vintage-form-group">
          <label class="vintage-label">Name</label>
          <input class="vintage-input" name="name" required minlength="2" maxlength="50" pattern="[A-Za-z][A-Za-z\s\.-]{1,49}" title="2-50 letters, may include spaces, dot, hyphen" value="<?php echo htmlspecialchars($name ?? ''); ?>">
        </div>

        <div class="vintage-form-group">
          <label class="vintage-label">Email</label>
          <input class="vintage-input" type="email" name="email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
        </div>

        <div class="vintage-form-group">
          <label class="vintage-label">Password</label>
          <input class="vintage-input" type="password" name="password" required minlength="8" pattern="(?=.*[A-Za-z])(?=.*\d).{8,}" title="At least 8 characters with a letter and a number">
          <div class="password-hint">At least 8 characters with a letter and a number</div>
        </div>

        <div class="vintage-form-group">
          <label class="vintage-label">Confirm Password</label>
          <input class="vintage-input" type="password" name="confirm_password" required minlength="8" pattern="(?=.*[A-Za-z])(?=.*\d).{8,}" title="Re-enter the same password">
        </div>

        <button class="vintage-submit-btn" type="submit">
          <span>Register</span>
        </button>
      </form>

      <script>
        (function() {
          var pwd = document.querySelector('input[name="password"]');
          var cpw = document.querySelector('input[name="confirm_password"]');
          if (pwd && cpw) {
            function validate() {
              if (cpw.value !== pwd.value) {
                cpw.setCustomValidity('Passwords do not match');
              } else {
                cpw.setCustomValidity('');
              }
            }
            pwd.addEventListener('input', validate);
            cpw.addEventListener('input', validate);
          }
        })();
      </script>

      <div class="vintage-footer-text">
        Already a member? <a href="login.php">Sign in here</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>