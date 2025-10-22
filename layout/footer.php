  </div>
</main>

<style>
  .vintage-footer {
    background: linear-gradient(to bottom, #fff 0%, var(--vintage-cream) 100%);
    border-top: 3px solid var(--vintage-border);
    padding: 2.5rem 0 2rem;
    margin-top: 3rem;
    position: relative;
  }

  .vintage-footer::before {
    content: '◆◆◆';
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #f5f1e8 0%, #e8dcc4 50%, #f5f1e8 100%);
    padding: 0 15px;
    color: var(--vintage-gold);
    font-size: 0.8rem;
    letter-spacing: 8px;
  }

  .vintage-footer-content {
    text-align: center;
  }

  .vintage-footer-brand {
    font-family: 'Cinzel', serif;
    font-size: 1.5rem;
    color: var(--vintage-dark);
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 1rem;
    font-weight: 700;
  }

  .vintage-footer-tagline {
    font-family: 'Crimson Text', serif;
    font-size: 1rem;
    color: var(--vintage-brown);
    font-style: italic;
    margin-bottom: 1.5rem;
  }

  .vintage-footer-divider {
    width: 80px;
    height: 2px;
    background: var(--vintage-gold);
    margin: 1.5rem auto;
  }

  .vintage-footer-copyright {
    font-family: 'Crimson Text', serif;
    font-size: 0.9rem;
    color: var(--vintage-brown);
    margin-top: 1rem;
  }

  @media (max-width: 768px) {
    .vintage-footer {
      padding: 2rem 0 1.5rem;
      margin-top: 2rem;
    }

    .vintage-footer-brand {
      font-size: 1.25rem;
      letter-spacing: 2px;
    }

    .vintage-footer-tagline {
      font-size: 0.9rem;
    }
  }
</style>

<footer class="vintage-footer">
  <div class="container">
    <div class="vintage-footer-content">
      <div class="vintage-footer-brand">Retrova</div>
      <div class="vintage-footer-tagline">Timeless Treasures from Bygone Eras</div>
      <div class="vintage-footer-divider"></div>
      <div class="vintage-footer-copyright">© <?php echo date('Y'); ?> Retrova. All rights reserved.</div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
