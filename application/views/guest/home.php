<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php if(!empty($shop_logo)): ?>
    <link rel="icon" type="image/x-icon" href="<?= base_url('uploads/'.$shop_logo) ?>">
  <?php endif; ?>
  <title><?= $this->M_settings->get_setting('shop_name') ?: 'MariMatcha' ?> – Minuman Matcha Premium UMKM</title>
  <meta name="description"
    content="Minuman matcha segar berkualitas premium dari Tangerang. Pesan langsung secara online, pengiriman ke seluruh Indonesia.">

  <!-- Fonts & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css"/>
  <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>

  <!-- Smooth Scroll (Lenis) -->
  <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>

  <style>
    :root {
      /* MariMatcha Brand Palette */
      --green-dark: #102416;
      /* Harder dark */
      --green-main: #1B3B25;
      /* Primary as the main accent */
      --green-light: #53725D;
      /* Secondary */
      --tertiary: #8BAA7C;
      --cream: #F5F5F0;
      /* Neutral */
      --cream-2: #E8E8E4;
      /* Subtle contrast background */
      --white: #ffffff;
      --text: #1B3B25;
      /* Primary text */
      --text-muted: #53725D;
      /* Secondary as muted */
      --accent: #fbbf24;

      /* Flat & Elegant Shadows */
      --shadow-sm: 0 4px 12px rgba(5, 38, 26, 0.04);
      --shadow-md: 0 10px 30px rgba(5, 38, 26, 0.06);
      --shadow-lg: 0 20px 40px rgba(5, 38, 26, 0.1);
      --shadow-float: 0 16px 32px rgba(5, 38, 26, 0.15);

      /* Border Radius */
      --radius-sm: 8px;
      --radius-md: 16px;
      --radius-lg: 24px;
      --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
      font-size: 16px;
    }

    body {
      font-family: 'Outfit', sans-serif;
      background: var(--cream);
      color: var(--text);
      overflow-x: hidden !important;
      width: 100%;
      -webkit-font-smoothing: antialiased;
      position: relative;
    }

    html,
    body {
      max-width: 100vw;
      overflow-x: hidden;
    }

    html.lenis {
      height: auto;
    }

    .lenis.lenis-smooth {
      scroll-behavior: auto !important;
    }

    .lenis.lenis-smooth [data-lenis-prevent] {
      overscroll-behavior: contain;
    }

    .lenis.lenis-stopped {
      overflow: hidden;
    }

    .lenis.lenis-scrolling iframe {
      pointer-events: none;
    }

    /* ─── SCROLL PROGRESS ─── */
    .scroll-progress {
      position: fixed;
      top: 0;
      left: 0;
      width: 0%;
      height: 4px;
      background: linear-gradient(90deg, var(--green-main), var(--green-light));
      z-index: 10000;
    }

    /* ─── CUSTOM CURSOR ─── */
    .m-cursor {
      width: 10px;
      height: 10px;
      background: var(--green-main);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 9999;
      mix-blend-mode: normal;
      transition: transform 0.1s ease;
    }

    .m-follower {
      width: 40px;
      height: 40px;
      border: 2px solid var(--green-main);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 9998;
      transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    }

    /* ─── SCROLLBAR ─── */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: var(--cream);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--green-light);
      border-radius: 10px;
    }

    /* ─── PRELOADER ─── */
    .m-preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: var(--green-dark);
      z-index: 20000;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: var(--tertiary);
    }

    .preloader-logo-box {
      width: 120px;
      height: 120px;
      background: #fff;
      border-radius: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 30px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
      position: relative;
      overflow: hidden;
      z-index: 2;
    }

    .preloader-logo-box img {
      width: 80px;
      height: 80px;
      object-fit: contain;
      mix-blend-mode: multiply;
    }

    .preloader-logo-box i {
      font-size: 3rem;
      color: var(--green-main);
    }

    .preloader-logo-box .shine-effect {
      position: absolute;
      top: 0;
      left: -100%;
      width: 50%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
      transform: skewX(-20deg);
      animation: preloaderShine 2s infinite;
    }

    @keyframes preloaderShine {
      0% { left: -100%; }
      100% { left: 200%; }
    }

    .preloader-bar-wrap {
      width: 180px;
      height: 3px;
      background: rgba(255, 255, 255, 0.1);
      position: relative;
      overflow: hidden;
      border-radius: 10px;
    }

    .preloader-bar {
      position: absolute;
      top: 0;
      left: 0;
      width: 0%;
      height: 100%;
      background: var(--tertiary);
    }

    .preloader-num {
      margin-top: 15px;
      font-weight: 800;
      font-size: 0.8rem;
      letter-spacing: 3px;
      opacity: 0.6;
    }

    /* ─── MAGNETIC BUTTON WRAPPER ─── */
    .mag-btn-wrap {
      display: inline-block;
      transition: transform 0.3s ease-out;
    }

    /* ─── REVEAL MASKING ─── */
    .reveal-mask {
      overflow: hidden;
      display: block;
    }

    .reveal-item {
      display: block;
    }

    /* ─── CURSOR ENHANCEMENTS ─── */
    .m-follower.active {
      transform: scale(2.5);
      background: var(--green-main);
      mix-blend-mode: difference;
      border: none;
    }

    .follower-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(0);
      color: #fff;
      font-size: 5px;
      font-weight: 900;
      text-transform: uppercase;
      white-space: nowrap;
      transition: transform 0.3s ease;
    }

    .m-follower.view-more {
      width: 80px;
      height: 80px;
      background: var(--tertiary);
      border: none;
    }

    .m-follower.view-more .follower-text {
      transform: translate(-50%, -50%) scale(1);
      font-size: 10px;
      color: var(--green-dark);
    }

    /* ─── NAVBAR ─── */
    .navbar-macha {
      background: rgba(255, 255, 255, 0.97);
      backdrop-filter: blur(16px);
      box-shadow: 0 2px 20px rgba(45, 90, 39, 0.08);
      padding: 13px 0;
      transition: var(--transition);
      border-bottom: none;
    }

    .navbar-macha.scrolled {
      padding: 8px 0;
      background: rgba(255, 255, 255, 0.99);
      box-shadow: 0 10px 30px rgba(45, 90, 39, 0.12);
    }

    .navbar-brand {
      font-weight: 900;
      font-size: 1.5rem;
      color: var(--green-dark) !important;
      letter-spacing: -0.6px;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-right: 1.5rem;
      flex-shrink: 0;
    }

    .nav-link {
      font-weight: 700;
      font-size: 0.92rem;
      color: var(--green-dark) !important;
      margin: 0 8px;
      transition: 0.25s ease;
      position: relative;
      padding-bottom: 4px !important;
      border-radius: 0;
      white-space: nowrap;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      left: 50%;
      right: 50%;
      bottom: 0;
      height: 2.5px;
      background: var(--green-main);
      border-radius: 4px;
      transition: 0.25s ease;
    }

    .nav-link:hover {
      color: var(--green-main) !important;
      background: transparent !important;
    }

    .nav-link:hover::after,
    .nav-link.active-link::after {
      left: 0;
      right: 0;
    }

    .nav-link.active-link {
      color: var(--green-main) !important;
      font-weight: 800;
      background: transparent !important;
    }

    /* STATUS PILL (requested style) */
    .shop-status-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 3px 10px;
      background: #fff;
      border: 2px solid var(--green-main);
      color: #000 !important;
      border-radius: 50px;
      font-size: 0.65rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      margin-left: 5px;
      flex-shrink: 0;
    }

    .status-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
    }

    .status-dot.open {
      background: #25D366;
      box-shadow: 0 0 8px #25D366;
    }

    .status-dot.closed {
      background: #e63946;
      box-shadow: 0 0 8px #e63946;
    }

    /* ─── IOS FLOATING BAR (GUEST) ─── */
    .ios-navbar-guest {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      transform: none;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      padding: 10px 5px;
      border-radius: 0;
      z-index: 1040;
      box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.1);
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      width: 100%;
      max-width: none;
      justify-content: space-evenly;
      align-items: center;
      gap: 2px;
    }

    .ios-nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      color: var(--green-light);
      text-decoration: none;
      font-size: 0.6rem;
      font-weight: 700;
      transition: all 0.3s ease;
      position: relative;
      padding: 6px 2px;
      border-radius: 20px;
      gap: 3px;
      flex: 1;
      text-align: center;
    }

    .ios-nav-item i {
      font-size: 1.3rem;
      margin-bottom: 2px;
      transition: all 0.3s ease;
    }

    .ios-nav-item.active {
      background: rgba(27, 59, 37, 0.08);
      color: var(--green-main);
    }

    .ios-nav-item.active i {
      transform: translateY(-2px) scale(1.05);
    }

    @media (max-width: 768px) {

      .navbar-macha .navbar-nav,
      .navbar-macha .navbar-toggler {
        display: none !important;
      }

      .ios-navbar-guest {
        display: none !important;
      }

      .navbar-macha {
        padding: 10px 0;
      }

      .navbar-brand {
        font-size: 1.4rem;
      }
    }

    .invisible-init {
      opacity: 0;
      pointer-events: none;
      /* Disable interaction while hidden */
    }

    .btn-hdr {
      background: var(--green-main);
      color: #fff !important;
      border-radius: 50px;
      padding: 10px 22px;
      font-weight: 700;
      font-size: 0.95rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: 0.25s;
      border: 2px solid var(--green-main);
    }

    .btn-hdr:hover {
      background: var(--green-dark);
      border-color: var(--green-dark);
      transform: translateY(-2px);
    }

    .btn-hdr-out {
      border: 2px solid var(--green-main);
      color: var(--green-main) !important;
      background: transparent;
      border-radius: 50px;
      padding: 10px 22px;
      font-weight: 700;
      font-size: 0.95rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: 0.25s;
    }

    .btn-hdr-out:hover {
      background: var(--green-main);
      color: #fff !important;
      transform: translateY(-2px);
    }

    /* ─── TOAST ─── */
    .toast-wrap {
      position: fixed;
      top: 100px;
      right: 24px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .toast-custom {
      background: #fff;
      border-radius: 16px;
      box-shadow: var(--shadow-lg);
      padding: 16px 20px;
      display: flex;
      align-items: center;
      gap: 14px;
      min-width: 300px;
      max-width: 400px;
      border-left: 5px solid var(--green-main);
      animation: slideInToast 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideInToast {
      from {
        opacity: 0;
        transform: translateX(50px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .toast-icon {
      width: 40px;
      height: 40px;
      background: var(--green-pale);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--green-main);
      font-size: 1.1rem;
      flex-shrink: 0;
    }

    .toast-msg {
      font-weight: 600;
      font-size: 0.95rem;
      color: var(--text);
      flex: 1;
    }

    .toast-close {
      background: none;
      border: none;
      color: #a0aec0;
      cursor: pointer;
      padding: 0;
      font-size: 1.2rem;
      transition: var(--transition);
    }

    .toast-close:hover {
      color: var(--text);
      transform: scale(1.1);
    }

    /* ─── HERO ─── */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding-top: 140px;
      position: relative;
      overflow: hidden;
      background: radial-gradient(circle at top left, #eaf2eb 0%, var(--cream) 60%);
    }

    .hero-decorative {
      position: absolute;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--green-light), var(--green-main));
      opacity: 0.05;
      filter: blur(40px);
    }

    .hero-decorative.d1 {
      width: 700px;
      height: 700px;
      right: -200px;
      top: -150px;
      animation: blobAnim 15s ease-in-out infinite alternate;
    }

    .hero-decorative.d2 {
      width: 400px;
      height: 400px;
      left: -100px;
      bottom: -50px;
      animation: blobAnim 12s ease-in-out infinite alternate-reverse;
    }

    @keyframes blobAnim {
      from {
        transform: translate(0, 0) scale(1);
      }

      to {
        transform: translate(-30px, 30px) scale(1.05);
      }
    }

    .hero-tag {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #fff;
      color: var(--green-main);
      font-weight: 700;
      font-size: 0.85rem;
      padding: 8px 18px;
      border-radius: 50px;
      letter-spacing: 0.5px;
      margin-bottom: 24px;
      box-shadow: var(--shadow-sm);
      border: 1px solid rgba(52, 132, 74, 0.1);
      transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
      cursor: pointer;
    }

    .hero-tag:hover {
      transform: translateY(-3px) scale(1.04);
      box-shadow: 0 15px 30px rgba(52, 132, 74, 0.12);
      border-color: rgba(52, 132, 74, 0.25);
    }

    .hero h1 {
      font-size: clamp(2.5rem, 5.5vw, 4.5rem);
      font-weight: 900;
      line-height: 1.1;
      color: var(--green-dark);
      margin-bottom: 24px;
      letter-spacing: -1px;
    }

    .hero h1 .highlight {
      color: var(--green-main);
      position: relative;
      display: inline-block;
    }

    .hero h1 .highlight::after {
      content: '';
      position: absolute;
      bottom: 8px;
      left: 0;
      width: 100%;
      height: 12px;
      background: rgba(91, 170, 109, 0.2);
      border-radius: 4px;
      z-index: -1;
    }

    .hero-desc {
      font-size: 1.1rem;
      color: var(--text-muted);
      max-width: 500px;
      line-height: 1.8;
      margin-bottom: 40px;
    }

    .hero-cta {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 48px;
    }

    .btn-hero-primary {
      background: var(--green-dark);
      color: #fff;
      border-radius: 18px;
      padding: 18px 40px;
      font-weight: 700;
      font-size: 1.1rem;
      text-decoration: none;
      box-shadow: 0 12px 28px rgba(20, 56, 24, 0.2);
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 14px;
    }

    .btn-hero-primary:hover {
      background: var(--green-main);
      color: #fff;
      transform: translateY(-4px);
      box-shadow: var(--shadow-float);
    }

    .btn-hero-wa {
      background: #fff;
      color: var(--text);
      border-radius: 16px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.05rem;
      text-decoration: none;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 12px;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .btn-hero-wa:hover {
      border-color: #25d366;
      color: #25d366;
      transform: translateY(-4px);
      box-shadow: var(--shadow-md);
    }

    .hero-stats {
      display: flex;
      gap: 32px;
      flex-wrap: wrap;
      padding-top: 16px;
      border-top: 1px solid rgba(52, 132, 74, 0.1);
    }

    .stat-item {
      display: flex;
      flex-direction: column;
    }

    .stat-num {
      font-size: 2rem;
      font-weight: 900;
      color: var(--green-dark);
      line-height: 1.2;
    }

    .stat-label {
      font-size: 0.9rem;
      color: var(--text-muted);
      font-weight: 500;
    }

    .hero-img-wrap {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .hero-img-bg {
      position: absolute;
      width: min(550px, 100%);
      height: min(550px, 100%);
      background: var(--green-pale);
      border-radius: 50%;
      z-index: 0;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .hero-img-wrap img {
      width: min(480px, 100%);
      border-radius: 32px;
      box-shadow: var(--shadow-lg);
      object-fit: cover;
      aspect-ratio: 4/5;
      position: relative;
      z-index: 1;
      transform: rotate(2deg);
      transition: var(--transition);
    }

    .hero-img-wrap:hover img {
      transform: rotate(0deg) translateY(-10px);
    }

    .hero-badge-float {
      position: absolute;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      box-shadow: var(--shadow-md);
      padding: 16px 20px;
      z-index: 2;
      display: flex;
      align-items: center;
      gap: 14px;
      border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .hero-badge-float.b1 {
      bottom: 40px;
      left: -20px;
      animation: floatLeft 5s ease-in-out infinite alternate;
    }

    .hero-badge-float.b2 {
      top: 60px;
      right: -10px;
      animation: floatRight 6s ease-in-out infinite alternate;
    }

    @keyframes floatLeft {
      from {
        transform: translateY(0);
      }

      to {
        transform: translateY(-12px);
      }
    }

    @keyframes floatRight {
      from {
        transform: translateY(0);
      }

      to {
        transform: translateY(12px);
      }
    }

    .float-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: var(--green-pale);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--green-main);
      font-size: 1.2rem;
    }

    .float-label {
      font-size: 0.8rem;
      color: var(--text-muted);
      font-weight: 600;
    }

    .float-val {
      font-size: 1.05rem;
      font-weight: 800;
      color: var(--text);
    }

    /* ─── SECTION BASE ─── */
    section {
      padding: 100px 0;
    }

    .section-label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: transparent;
      color: var(--text-muted);
      font-weight: 500;
      font-size: 0.85rem;
      padding: 0;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 12px;
      box-shadow: none;
      border: none;
    }

    .section-h2 {
      font-size: clamp(2rem, 4vw, 2.5rem);
      font-weight: 800;
      color: var(--green-dark);
      margin-bottom: 20px;
      letter-spacing: -1px;
      line-height: 1.1;
    }

    .section-sub {
      color: var(--text-muted);
      font-size: 1.1rem;
      line-height: 1.7;
      max-width: 600px;
    }

    /* ─── PRODUCT CARDS ─── */
    .products-section {
      background: var(--cream);
    }

    .prod-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 30px;
    }

    .perspective-card {
      perspective: 1000px;
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      padding: 0 !important;
    }

    .prod-card-inner {
      background: #fff;
      border-radius: var(--radius-lg);
      padding: 16px;
      box-shadow: var(--shadow-sm);
      border: 1px solid rgba(0, 0, 0, 0.02);
      transition: transform 0.1s ease-out;
      transform-style: preserve-3d;
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .prod-card:hover .prod-card-inner {
      box-shadow: var(--shadow-lg);
    }

    /* ─── SHIMMER EFFECT ─── */
    .shimmer-btn {
      position: relative;
      overflow: hidden;
      background: var(--green-main) !important;
      color: #fff !important;
    }

    .shimmer-btn::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(to bottom right,
          rgba(255, 255, 255, 0) 0%,
          rgba(255, 255, 255, 0) 40%,
          rgba(255, 255, 255, 0.4) 50%,
          rgba(255, 255, 255, 0) 60%,
          rgba(255, 255, 255, 0) 100%);
      transform: rotate(45deg);
      transition: all 0.3s;
      animation: shimmer 3s infinite;
    }

    /* ─── PREMIUM SKELETON LOADING ─── */
    .skeleton-box {
      position: relative;
      overflow: hidden;
      background-color: #f0f3f1;
    }

    .skeleton-box .skeleton-img {
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background: #f0f3f1;
      z-index: 2; /* Below the badge, but above the image initially */
      transition: opacity 0.5s ease, visibility 0.5s;
    }

    .skeleton-box.loaded .skeleton-img {
      opacity: 0;
      visibility: hidden;
    }

    .prod-img-wrap img {
      position: relative;
      z-index: 1;
    }

    .prod-img-wrap {
      height: 280px;
      border-radius: 20px;
      overflow: hidden;
      position: relative;
      background: var(--cream-2);
      margin-bottom: 20px;
    }

    .prod-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .prod-card:hover .prod-img-wrap img {
      transform: scale(1.08);
    }

    .prod-badge-wrap {
      position: absolute;
      top: 16px;
      left: 16px;
      display: flex;
      gap: 8px;
      z-index: 1;
    }

    .prod-badge {
      font-size: 0.75rem;
      font-weight: 700;
      padding: 6px 14px;
      border-radius: 50px;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      background: rgba(255, 255, 255, 0.9);
      color: var(--green-main);
    }

    .prod-body {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .prod-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 8px;
    }

    .prod-name {
      font-size: 1.25rem;
      font-weight: 800;
      color: var(--green-dark);
      line-height: 1.3;
      margin: 0;
    }

    .prod-price {
      font-size: 1.15rem;
      font-weight: 800;
      color: var(--green-dark);
      margin: 0;
    }

    .prod-desc {
      font-size: 0.95rem;
      color: var(--text-muted);
      margin-bottom: 24px;
      line-height: 1.6;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .btn-add-cart {
      background: var(--green-dark);
      color: #fff;
      border: none;
      border-radius: 16px;
      padding: 14px 24px;
      font-weight: 800;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      width: 100%;
      text-decoration: none;
      text-align: center;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-top: auto;
    }

    .btn-add-cart:hover {
      background: var(--green-main);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(27, 59, 37, 0.25);
    }

    .btn-add-cart.sold-out {
      background: #F0F2F5;
      color: #A0AEC0;
      border-radius: 16px;
      pointer-events: none;
    }

    /* ─── PREMIUM ORGANIC MAP SECTION ─── */
    .premium-map-section {
      background: var(--green-dark);
      padding: 120px 0;
      position: relative;
      overflow: hidden;
    }

    .map-bg-glow {
      position: absolute;
      width: 60vw;
      height: 60vw;
      background: radial-gradient(circle, rgba(83, 114, 93, 0.15) 0%, transparent 70%);
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border-radius: 50%;
      pointer-events: none;
    }

    .premium-map-container {
      position: relative;
      max-width: 1000px;
      margin: 0 auto;
      padding: 40px 0;
      background: linear-gradient(to right, #c5d7b5 0%, #ebf1e4 6%, #f8fbf5 50%, #ebf1e4 94%, #c5d7b5 100%);
      border-radius: 6px;
      box-shadow: 0 30px 70px rgba(0, 0, 0, 0.45), inset 0 0 40px rgba(27, 59, 37, 0.15);
      border: 1px solid rgba(139, 170, 124, 0.35);
      z-index: 2;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .map-scroll-wrapper {
      width: 900px;
      position: relative;
      flex-shrink: 0;
      padding: 0 20px;
      transition: opacity 0.3s ease;
    }

    @media (max-width: 992px) {
      .map-scroll-wrapper {
        width: 700px;
      }
    }
    @media (max-width: 768px) {
      .map-scroll-wrapper {
        width: 500px;
      }
    }
    @media (max-width: 500px) {
      .map-scroll-wrapper {
        width: 360px;
        padding: 0 10px;
      }
    }

    /* Scroll Roller Pillars on Left & Right */
    .premium-map-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 16px;
      height: 100%;
      background: linear-gradient(to right, #2d4031, #8baa7c, #53725d, #1b2e21);
      box-shadow: 2px 0 10px rgba(0,0,0,0.3);
      z-index: 5;
    }

    .premium-map-container::after {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 16px;
      height: 100%;
      background: linear-gradient(to left, #2d4031, #8baa7c, #53725d, #1b2e21);
      box-shadow: -2px 0 10px rgba(0,0,0,0.3);
      z-index: 5;
    }

    .id-map-organic-svg {
      width: 100%;
      height: auto;
      display: block;
      filter: drop-shadow(0 4px 10px rgba(27, 59, 37, 0.15));
    }

    .map-curve,
    .map-curve-dot {
      fill: #e9f0e3;
      stroke: #53725D;
      stroke-width: 1.5;
      stroke-linejoin: round;
      stroke-linecap: round;
      transition: all 0.4s ease;
    }

    .map-curve:hover {
      fill: var(--green-light);
      stroke: none;
    }

    @keyframes dashflow {
      to {
        stroke-dashoffset: -20;
      }
    }

    .map-connection {
      fill: transparent;
      stroke: rgba(139, 170, 124, 0.6);
      stroke-width: 1.5;
      stroke-dasharray: 6 4;
      stroke-linecap: round;
      animation: dashflow 1.5s linear infinite;
    }

    .premium-marker {
      position: absolute;
      transform: translate(-50%, -50%);
      z-index: 10;
    }

    .marker-core {
      width: 12px;
      height: 12px;
      background-color: #fff;
      border-radius: 50%;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.8), 0 0 0 4px var(--green-main);
    }

    .marker-pulse {
      position: absolute;
      width: 40px;
      height: 40px;
      background: var(--tertiary);
      border-radius: 50%;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      animation: gentlePulse 2s infinite ease-out;
      z-index: -1;
    }

    /* Destination Dots */
    .dest-dot {
      position: absolute;
      transform: translate(-50%, -50%);
      z-index: 8;
      transition: all 0.3s ease;
    }

    .dest-dot::before {
      content: '';
      display: block;
      width: 8px;
      height: 8px;
      background: var(--tertiary);
      border-radius: 50%;
      border: 1.5px solid #fff;
      box-shadow: 0 0 8px rgba(139, 170, 124, 0.8);
      transition: all 0.2s ease;
    }

    .dest-dot:hover {
      z-index: 15;
    }

    .dest-dot:hover::before {
      transform: scale(1.4);
      background: #fff;
      border-color: var(--green-main);
      box-shadow: 0 0 12px #fff;
    }

    .dest-dot::after {
      content: attr(data-city);
      position: absolute;
      bottom: 12px;
      left: 50%;
      transform: translateX(-50%) translateY(5px);
      background: rgba(16, 36, 22, 0.95);
      color: #fff;
      padding: 4px 10px;
      border-radius: 8px;
      font-size: 0.7rem;
      font-weight: 700;
      white-space: nowrap;
      z-index: 100;
      pointer-events: none;
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s ease;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255,255,255,0.1);
    }

    .dest-dot:hover::after {
      opacity: 1;
      visibility: visible;
      transform: translateX(-50%) translateY(0);
    }

    @keyframes gentlePulse {
      0% {
        transform: translate(-50%, -50%) scale(0.5);
        opacity: 0.8;
      }

      100% {
        transform: translate(-50%, -50%) scale(2);
        opacity: 0;
      }
    }

    .location-card {
      position: absolute;
      background: rgba(255, 255, 255, 0.98);
      padding: 12px 20px;
      border-radius: 16px;
      box-shadow: var(--shadow-lg);
      transform: translate(-50%, -130%);
      pointer-events: none;
      z-index: 20;
      text-align: center;
      min-width: 150px;
      white-space: nowrap;
      border: 1px solid rgba(0,0,0,0.05);
    }

    .location-card::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 50%;
      transform: translateX(-50%) rotate(45deg);
      width: 10px;
      height: 10px;
      background: rgba(255, 255, 255, 0.98);
      border-right: 1px solid rgba(0,0,0,0.05);
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .loc-title {
      font-weight: 800;
      color: var(--green-dark);
      font-size: 1rem;
      margin-bottom: 2px;
    }

    .loc-desc {
      color: var(--text-muted);
      font-size: 0.8rem;
      font-weight: 500;
      white-space: nowrap;
    }

    /* ─── VIEW ALL BTN ─── */
    .btn-view-all {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      background: var(--green-dark);
      color: #fff;
      border-radius: 50px;
      padding: 14px 32px;
      font-weight: 700;
      font-size: 0.95rem;
      text-transform: uppercase;
      text-decoration: none;
      transition: var(--transition);
      box-shadow: var(--shadow-sm);
    }

    .btn-view-all:hover {
      background: var(--green-main);
      color: #fff;
      transform: translateY(-3px);
      box-shadow: var(--shadow-md);
    }

    /* ─── STEP PESANAN ─── */
    .steps-section {
      background: var(--cream-2);
    }

    .step-card {
      background: #fff;
      border-radius: var(--radius-md);
      padding: 40px 24px;
      text-align: center;
      box-shadow: var(--shadow-sm);
      border: 1px solid rgba(0, 0, 0, 0.02);
      height: 100%;
      position: relative;
      transition: var(--transition);
    }

    .step-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-md);
    }

    .step-num {
      width: 64px;
      height: 64px;
      border-radius: 20px;
      background: linear-gradient(135deg, var(--green-dark), var(--green-main));
      color: #fff;
      font-size: 1.6rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 24px;
      box-shadow: var(--shadow-float);
    }

    .step-card h5 {
      font-weight: 800;
      color: var(--green-dark);
      margin-bottom: 12px;
      font-size: 1.2rem;
    }

    .step-card p {
      color: var(--text-muted);
      font-size: 0.95rem;
      line-height: 1.6;
      margin: 0;
    }

    .step-connector {
      position: absolute;
      right: -24px;
      top: 50%;
      transform: translateY(-50%);
      width: 48px;
      height: 48px;
      background: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--green-light);
      font-size: 1.2rem;
      z-index: 2;
      box-shadow: var(--shadow-sm);
    }

    /* ─── ABOUT ─── */
    .about-section {
      background: #fff;
    }

    .about-img-wrap {
      position: relative;
      border-radius: var(--radius-lg);
      padding: 16px;
      background: var(--cream-2);
    }

    .about-img-wrap img {
      border-radius: var(--radius-md);
      width: 100%;
      object-fit: cover;
      aspect-ratio: 4/3;
      box-shadow: var(--shadow-md);
    }

    .about-badge {
      position: absolute;
      bottom: -20px;
      right: -10px;
      background: #fff;
      border-radius: 20px;
      padding: 20px 24px;
      box-shadow: var(--shadow-lg);
    }

    .feature-card {
      display: flex;
      align-items: flex-start;
      gap: 20px;
      padding: 24px;
      border-radius: var(--radius-md);
      transition: var(--transition);
      border: 1px solid transparent;
      background: #fff;
    }

    .feature-card:hover {
      background: var(--cream);
      border-color: rgba(52, 132, 74, 0.1);
      transform: translateX(8px);
      box-shadow: var(--shadow-sm);
    }

    .feature-icon-wrap {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      background: var(--green-pale);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      color: var(--green-main);
      flex-shrink: 0;
      transition: var(--transition);
    }

    .feature-card:hover .feature-icon-wrap {
      background: var(--green-dark);
      color: #fff;
    }

    .feature-card h6 {
      font-weight: 800;
      font-size: 1.1rem;
      color: var(--green-dark);
      margin-bottom: 8px;
    }

    .feature-card p {
      font-size: 0.95rem;
      color: var(--text-muted);
      margin: 0;
      line-height: 1.6;
    }

    /* ─── TESTIMONIALS ─── */
    .testi-section {
      background: var(--cream-2);
    }

    .testi-card {
      background: #fff;
      border-radius: var(--radius-md);
      padding: 32px;
      box-shadow: var(--shadow-sm);
      border: none;
      height: 100%;
      transition: var(--transition);
    }

    .testi-card:hover {
      box-shadow: var(--shadow-lg);
      transform: translateY(-6px);
    }

    .testi-slider-container {
      position: relative;
      padding: 0 10px;
    }

    .testi-slider {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;
      gap: 25px;
      padding: 40px 10px;
      scroll-behavior: smooth;
      scroll-snap-type: x mandatory;
      scrollbar-width: none;
      /* Firefox */
      -ms-overflow-style: none;
      /* IE/Edge */
    }

    .testi-slider::-webkit-scrollbar {
      display: none;
      /* Chrome/Safari */
    }

    .testi-item {
      flex: 0 0 calc(33.333% - 20px);
      scroll-snap-align: center;
      transition: all 0.5s ease;
    }

    .testi-nav {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 10px;
    }

    .testi-btn {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: var(--shadow-sm);
      transition: all 0.3s ease;
      color: var(--green-dark);
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .testi-btn:hover {
      background: var(--green-main);
      color: #fff;
      transform: scale(1.1);
    }

    @media (max-width: 991px) {
      .testi-item {
        flex: 0 0 calc(50% - 15px);
      }
    }

      @media (max-width: 768px) {
        .testi-item {
          flex: 0 0 85%; /* Peek next/prev cards for better swipe affordance */
        }
        .testi-slider {
          padding: 40px 0;
        }
        .testi-nav {
          display: none; /* Hide buttons on mobile, native swipe is better */
        }
      }

    .testi-stars {
      color: var(--accent);
      margin-bottom: 20px;
      font-size: 1.1rem;
      letter-spacing: 2px;
    }

    .testi-quote {
      color: var(--text);
      font-size: 1.05rem;
      line-height: 1.8;
      font-style: italic;
      margin-bottom: 24px;
    }

    .testi-user {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .testi-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: var(--green-pale);
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--green-main);
      font-weight: 800;
      flex-shrink: 0;
    }

    .testi-name {
      font-weight: 800;
      font-size: 1rem;
      color: var(--text);
    }

    .testi-loc {
      font-size: 0.85rem;
      color: var(--text-muted);
      margin-top: 4px;
    }

    .review-form-card {
      background: #fff;
      padding: 45px;
      border-radius: 30px;
      box-shadow: 0 15px 45px rgba(0, 0, 0, 0.06);
      border: 1px solid rgba(0, 0, 0, 0.03);
      position: relative;
    }

    .review-form-card .form-control {
      border-radius: 15px;
      border: 2px solid #f1f5f2;
      font-family: 'Outfit', sans-serif;
      padding: 14px 20px;
      background: #fdfdfb;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .review-form-card .form-control:focus {
      border-color: var(--green-main);
      background: #fff;
      box-shadow: 0 8px 24px rgba(27, 59, 37, 0.08);
    }

    .star-rating-input {
      display: flex;
      flex-direction: row-reverse;
      justify-content: center;
      gap: 12px;
      margin-bottom: 25px;
    }

    .star-rating-input input {
      display: none;
    }

    .star-rating-input label {
      font-size: 2rem;
      color: #e2e8f0;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .star-rating-input label:hover,
    .star-rating-input label:hover~label,
    .star-rating-input input:checked~label {
      color: #fbbf24;
      transform: scale(1.1);
      text-shadow: 0 0 10px rgba(251, 191, 36, 0.4);
    }

    .star-rating-input label:hover {
      transform: scale(1.2) rotate(8deg);
    }

    /* ─── WA BANNER ─── */
    .wa-section {
      background: #fff;
    }

    .wa-card {
      background: linear-gradient(135deg, #128C7E 0%, #25D366 100%);
      border-radius: var(--radius-lg);
      padding: 80px 40px;
      color: #fff;
      text-align: center;
      position: relative;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(37, 211, 102, 0.2);
    }

    .wa-card::before,
    .wa-card::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
    }

    .wa-card::before {
      width: 400px;
      height: 400px;
      top: -150px;
      right: -100px;
    }

    .wa-card::after {
      width: 250px;
      height: 250px;
      bottom: -80px;
      left: -80px;
    }

    .wa-card h3 {
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 900;
      margin-bottom: 16px;
      position: relative;
      z-index: 1;
    }

    .wa-card p {
      font-size: 1.15rem;
      opacity: 0.9;
      margin-bottom: 0;
      position: relative;
      z-index: 1;
      max-width: 600px;
      margin: 0 auto;
    }

    .btn-wa-big {
      background: #fff;
      color: #128C7E;
      border-radius: 16px;
      padding: 18px 48px;
      font-weight: 800;
      font-size: 1.1rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 12px;
      margin-top: 36px;
      transition: var(--transition);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      position: relative;
      z-index: 1;
    }

    .btn-wa-big:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      color: #075E54;
    }

    /* ─── FOOTER PREMIUM DESIGN ─── */
    footer {
      background: #0a1f1f;
      /* Deep dark green */
      color: rgba(255, 255, 255, 0.6);
      padding: 100px 0 40px;
      position: relative;
      overflow: hidden;
    }

    .footer-brand {
      color: #fff !important;
      font-size: 1.8rem;
      font-weight: 800;
      margin-bottom: 25px;
    }

    .footer-desc {
      font-size: 0.95rem;
      line-height: 1.8;
      max-width: 320px;
      margin-bottom: 30px;
    }

    .footer-heading {
      color: #fff;
      font-size: 0.9rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 30px;
      opacity: 0.8;
    }

    .footer-link {
      display: flex;
      align-items: center;
      gap: 10px;
      color: rgba(255, 255, 255, 0.6);
      margin-bottom: 15px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .footer-link i {
      font-size: 0.75rem;
      color: var(--tertiary);
    }

    .footer-link:hover {
      color: #fff;
      transform: translateX(5px);
    }

    .status-active-wrap {
      margin-bottom: 25px;
    }

    .status-active {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(37, 211, 102, 0.1);
      color: #25D366;
      padding: 6px 16px;
      border-radius: 50px;
      font-size: 0.75rem;
      font-weight: 900;
      letter-spacing: 1px;
      border: 1px solid rgba(37, 211, 102, 0.2);
    }

    .active-dot {
      width: 8px;
      height: 8px;
      background: #25D366;
      border-radius: 50%;
      box-shadow: 0 0 10px #25D366;
      animation: statusPulse 1.5s infinite;
    }

    @keyframes statusPulse {
      0% {
        opacity: 1;
        transform: scale(1);
      }

      50% {
        opacity: 0.5;
        transform: scale(1.2);
      }

      100% {
        opacity: 1;
        transform: scale(1);
      }
    }

    .footer-location-img-wrap {
      margin-top: 15px;
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      width: 100%;
      max-width: 250px;
      aspect-ratio: 16/10;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
      transition: all 0.4s ease;
      display: block;
    }

    .footer-location-img-wrap:hover {
      transform: translateY(-5px);
      border-color: rgba(255, 255, 255, 0.3);
    }

    .footer-location-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .map-overlay-text {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 10px;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
      color: #fff;
      font-size: 0.75rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .footer-social {
      display: flex;
      gap: 15px;
    }

    .social-btn {
      width: 42px;
      height: 42px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .social-btn:hover {
      background: var(--tertiary);
      transform: translateY(-3px);
    }

    /* ─── FLOATING CART (PULSING & MAGNETIC) ─── */
    .floating-cart {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 70px;
      height: 70px;
      border-radius: 24px;
      background: var(--green-dark);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      text-decoration: none;
      box-shadow: 0 20px 50px rgba(16, 36, 22, 0.4);
      z-index: 10000;
      transition: background 0.3s ease;
      cursor: pointer;
    }

    .floating-cart::before {
      content: '';
      position: absolute;
      inset: -8px;
      border: 2px solid var(--green-light);
      border-radius: 28px;
      opacity: 0;
      animation: cartPulse 2s infinite;
    }

    @keyframes cartPulse {
      0% {
        transform: scale(0.9);
        opacity: 0.8;
      }

      100% {
        transform: scale(1.3);
        opacity: 0;
      }
    }

    .floating-cart:hover {
      background: var(--green-main);
      color: #fff;
    }

    .floating-cart .fc-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: #e53e3e;
      color: #fff;
      font-size: 0.75rem;
      font-weight: 800;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 3px solid var(--cream);
    }

    /* ─── GSAP UTILITIES ─── */
    .invisible-init {
      visibility: hidden;
    }

    @media (max-width: 991px) {
      .navbar-collapse {
        background: #fff;
        padding: 30px 20px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        margin-top: 15px;
        border: 1px solid rgba(0, 0, 0, 0.05);
      }

      .nav-link {
        font-size: 1.1rem;
        padding: 12px 0 !important;
        text-align: center;
      }

      .hero {
        padding-top: 120px;
        text-align: center;
      }

      .hero-desc {
        margin-left: auto;
        margin-right: auto;
      }

      .hero-cta {
        justify-content: center;
      }

      .hero-stats {
        justify-content: center;
        gap: 20px;
      }

      .hero-img-wrap {
        margin-top: 20px;
      }
    }

    /* ─── STABLE HERO REDESIGN ─── */
    .hero {
      min-height: 90vh;
      display: flex;
      align-items: center;
      padding-top: 140px;
      padding-bottom: 80px;
      background: linear-gradient(135deg, #fdfdfb 0%, #f4f7f2 100%);
      position: relative;
      overflow: hidden;
    }

    .hero-text-col {
      animation: heroContentFadeIn 1s ease-out forwards;
    }

    @keyframes heroContentFadeIn {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero h1 {
      font-size: clamp(2.4rem, 6vw, 4.8rem);
      font-weight: 900;
      color: var(--green-dark);
      line-height: 1.1;
      margin-bottom: 20px;
      letter-spacing: -1.5px;
      overflow: hidden; /* For split reveal */
    }

    .hero h1 span.line-wrap {
      display: block;
      overflow: hidden;
    }

    .hero h1 span.line-inner {
      display: block;
      transform: translateY(100%);
    }

    .hero h1 .highlight {
      color: var(--green-main);
      display: inline-block;
      position: relative;
    }

    .hero-desc {
      font-size: 1.1rem;
      color: #556b5c;
      max-width: 520px;
      line-height: 1.7;
      margin-bottom: 35px;
    }

    .hero-cta {
      display: flex;
      gap: 15px;
      margin-bottom: 45px;
      flex-wrap: wrap;
    }

    .hero-tag {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: #fff;
      padding: 8px 18px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 0.8rem;
      color: var(--green-main);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(52, 132, 74, 0.1);
      margin-bottom: 25px;
      transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
      cursor: pointer;
    }

    .hero-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px;
      padding-top: 30px;
      border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .hero-img-wrap {
      position: relative;
      animation: heroImageAppear 1.2s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }

    @keyframes heroImageAppear {
      0% {
        opacity: 0;
        transform: translateX(50px) rotate(5deg);
      }

      100% {
        opacity: 1;
        transform: translateX(0) rotate(0);
      }
    }

    .hero-img-wrap img {
      width: 100%;
      max-width: 550px;
      border-radius: 40px;
      box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
      transition: all 0.5s ease;
    }

    @media (max-width: 991px) {
      .hero {
        padding-top: 120px;
        text-align: center;
      }

      .hero-text-col {
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      .hero-cta {
        justify-content: center;
      }

      .hero-desc {
        margin-left: auto;
        margin-right: auto;
      }

      .hero-stats {
        width: 100%;
        max-width: 450px;
      }
    }

    @media (max-width: 576px) {
      .hero h1 {
        font-size: 2.2rem;
      }

      .hero-stats {
        grid-template-columns: 1fr;
        gap: 20px;
        text-align: center;
      }

      .btn-hero-primary,
      .btn-hero-wa {
        width: 100%;
        justify-content: center;
      }
    }

    @media (max-width: 576px) {
      .hero h1 {
        font-size: 2.2rem;
      }

      .btn-hero-primary,
      .btn-hero-wa {
        width: 100%;
        justify-content: center;
      }

      .prod-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
      }

      .prod-img-wrap {
        height: 160px;
      }

      .prod-name {
        font-size: 0.95rem;
      }

      .prod-price {
        font-size: 1rem;
      }

      .btn-add-cart {
        padding: 10px;
        font-size: 0.8rem;
      }

      .stat-num {
        font-size: 1.6rem;
      }

      .stat-label {
        font-size: 0.75rem;
      }
    }

    /* Force clickable state after animation */
    .site-ready .invisible-init,
    .site-ready a,
    .site-ready button {
      pointer-events: auto !important;
      visibility: visible !important;
    }

    /* Disable custom cursor on touch devices */
    @media (hover: none) and (pointer: coarse) {

      .m-cursor,
      .m-follower {
        display: none !important;
      }
    }

    /* ─── UI & PERFORMANCE OPTIMIZATIONS ─── */
    .hero-img-wrap img,
    .prod-card-inner,
    .step-card,
    .testi-card,
    .feature-card,
    .f-leaf,
    .story-bg-text-wrapper,
    .story-track {
      will-change: transform, opacity;
    }

    /* CTA Popping Enhancements */
    .btn-hero-primary {
      box-shadow: 0 12px 28px rgba(37, 211, 102, 0.2);
    }

    .btn-hero-primary:hover {
      box-shadow: 0 16px 36px rgba(37, 211, 102, 0.4);
    }

    .btn-hero-wa {
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.05);
      border-color: #25d366;
    }

    @media (max-width: 768px) {

      /* Disable heavy animations & effects */
      .f-leaf,
      .marker-pulse,
      .hero-decorative {
        display: none !important;
      }

      .glass-content-wrap,
      .premium-map-container {
        backdrop-filter: none !important;
      }

      .navbar-macha {
        background: rgba(255, 255, 255, 0.99) !important;
        backdrop-filter: none !important;
      }

      .glass-content-wrap {
        background: rgba(16, 36, 22, 0.95) !important;
        border-radius: 20px;
      }

      /* Hide Floating Cart on mobile because ios-navbar-guest is used */
      .floating-cart {
        display: none !important;
      }
      
      .hero-cta {
        flex-direction: column;
        width: 100%;
      }
    }
  </style>
</head>

<body>

  <!-- ══════════ PRELOADER ══════════ -->
  <div class="m-preloader" id="preloader">
    <div class="preloader-logo-box" id="preloaderLogo">
      <?php if (!empty($shop_logo)): ?>
        <img src="<?= base_url('uploads/' . $shop_logo) ?>" id="preloaderLogoImg" alt="Logo">
      <?php else: ?>
        <i class="fa-solid fa-leaf"></i>
      <?php endif; ?>
      <div class="shine-effect"></div>
    </div>
    <div class="preloader-bar-wrap">
      <div class="preloader-bar" id="preloaderBar"></div>
    </div>
    <div class="preloader-num" id="preloaderNum">0%</div>
  </div>


  <!-- ══════════ NAVBAR ══════════ -->
  <?php $this->load->view('layout/navbar'); ?>

  <!-- Toast removed, now handled by navbar Dynamic Island -->
  <!-- ══════════ HERO IMMERSIVE ZOOM WRAPPER ══════════ -->
  <section class="hero-zoom-outer">
    <div class="hero-fixed-container">
      <section class="hero">
        <div class="hero-decorative d1"></div>
        <div class="hero-decorative d2"></div>
        <div class="container position-relative" style="z-index:1">
          <div class="row align-items-center gy-5 hero-main-row">
            <div class="col-lg-6 hero-text-col">
              <div class="hero-tag">
                <i class="fa-solid fa-location-dot"></i> UMKM Tangerang · Banten
              </div>
              <h1>
                <span class="line-wrap"><span class="line-inner">Nikmati Segar</span></span>
                <span class="line-wrap"><span class="line-inner">Minuman <span class="highlight">Matcha</span></span></span>
                <span class="line-wrap"><span class="line-inner">Terbaik Kami</span></span>
              </h1>
              <p class="hero-desc">Dibuat dari teh hijau grade premium, disajikan dingin maupun panas. Cocok untuk harimu yang penuh semangat dan rasa!</p>

              <div class="hero-cta">
                <a href="<?= base_url('shop') ?>" class="btn-hero-primary">
                  <i class="fa-solid fa-bag-shopping"></i> Pesan Sekarang
                </a>
                <a href="javascript:void(0)" id="btnTourHome" class="btn-hero-wa" style="border-color: var(--tertiary); color: var(--green-dark);">
                  <i class="fa-solid fa-map-location-dot" style="font-size:1.2rem"></i> Panduan Web
                </a>
              </div>

              <div class="hero-stats">
                <div class="stat-item">
                  <span class="stat-num">500+</span>
                  <span class="stat-label">Pelanggan Puas</span>
                </div>
                <div class="stat-item">
                  <span class="stat-num">15+</span>
                  <span class="stat-label">Varian Menu</span>
                </div>
                <div class="stat-item">
                  <span class="stat-num">4.9<i class="fa-solid fa-star ms-1" style="color:var(--accent);font-size:1rem"></i></span>
                  <span class="stat-label">Rating Kami</span>
                </div>
              </div>
            </div>

            <div class="col-lg-6 hero-img-col d-flex justify-content-center">
              <div class="hero-img-wrap">
                <div class="hero-img-bg"></div>
                <img src="<?= base_url('assets/img/productORI.png'); ?>" alt="Premium Matcha" class="hero-main-img">
                
                <div class="hero-badge-float b1">
                  <div class="float-icon"><i class="fa-solid fa-truck-fast"></i></div>
                  <div>
                    <div class="float-label">Pengiriman Aman</div>
                    <div class="float-val">Dan Cepat</div>
                  </div>
                </div>
                
                <div class="hero-badge-float b2">
                  <div class="float-icon"><i class="fa-solid fa-award"></i></div>
                  <div>
                    <div class="float-label">Bahan Alami</div>
                    <div class="float-val">100% Premium</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

  <!-- ══════════ PREMIUM STORYTELLING SECTION ══════════ -->
  <section class="premium-story-section" id="storySection">
    <div class="story-bg-text-wrapper">
      <div class="story-bg-text">MATCHA MATCHA MATCHA MATCHA MATCHA</div>
      <div class="story-bg-text">MATCHA MATCHA MATCHA MATCHA MATCHA</div>
      <div class="story-bg-text">MATCHA MATCHA MATCHA MATCHA MATCHA</div>
    </div>

    <div class="story-track">
      <!-- Story Panel 1: Origin -->
      <div class="story-slide slide-1">
        <div class="container">
          <div class="glass-content-wrap">
            <div class="row align-items-center gx-5">
              <div class="col-lg-6">
                <div class="story-label">PHASE 01: QUALITY</div>
                <h2 class="story-h2">Umkm Matcha yg harganya terjangkau tetapi rasanya <span
                    class="highlight">berkelas</span></h2>
                <p class="story-p">matcha yg terbilang harganya murah tetapi rasanya tidak murahan. mulai dari 13K - 15K
                </p>
                <div class="story-stats-row">
                  <div class="s-stat"><span>Premium</span> Grade</div>
                  <div class="s-stat"><span>Affordable</span> Price</div>
                </div>
              </div>
              <div class="col-lg-6 text-center">
                <div class="floating-img-frame">
                  <img src="<?= base_url('assets/img/KONTEN01.jpeg'); ?>" alt="Quality Matcha" class="img-fluid">
                  <div class="floating-badge">Laris Manis</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Story Panel 2: Process -->
      <div class="story-slide slide-2">
        <div class="container">
          <div class="glass-content-wrap inverse">
            <div class="row align-items-center gx-5">
              <div class="col-lg-6 order-lg-2">
                <div class="story-label">PHASE 02: MENU</div>
                <h2 class="story-h2">Matcha yang segar, manis dan <span class="highlight">banyak menu-nya</span></h2>
                <p class="story-p">menyediakan banyak menu blend dan tidak cuma matcha aja!</p>
                <div class="process-tag">Freshly Bold • Many Selections</div>
              </div>
              <div class="col-lg-6 order-lg-1 text-center">
                <div class="floating-img-frame s2">
                  <img src="<?= base_url('assets/img/KONTEN02.jpeg'); ?>" alt="Process" class="img-fluid">
                  <div class="floating-badge">Sehat & Nikmat</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Story Panel 3: Result -->
      <div class="story-slide slide-3">
        <div class="container">
          <div class="final-reveal-wrap">
            <div class="story-label">PHASE 03: EXPERIENCE</div>
            <h2 class="story-h2 lg">PESAN <br><span class="highlight">SEKARANG</span></h2>
            <p class="story-p center">MATCHA YG BERKELAZ</p>
            <div class="final-cta-wrap">
              <a href="https://wa.me/<?= $this->config->item('admin_wa') ?>?text=Halo+MariMatcha,+saya+ingin+tanya+produk"
                class="btn-macha-white" target="_blank" rel="noopener noreferrer">Order via WhatsApp <i
                  class="fa-solid fa-arrow-right ms-2"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ══════════ PRODUK UNGGULAN ══════════ -->
  <section class="products-section">
    <div class="container">
      <div class="row align-items-end mb-5 reveal-up invisible-init">
        <div class="col-md-7">
          <div class="section-label" style="text-transform: uppercase;"><i class="fa-solid fa-fire-flame-curved"></i>
            Menu Unggulan</div>
          <h2 class="section-h2" style="font-weight: 800;">Minuman Terlaris</h2>
          <p class="section-sub mb-0">Yang paling sering dipesan oleh pelanggan setia kami ❤️</p>
        </div>
        <div class="col-md-5 text-md-end mt-4 mt-md-0">
          <a href="<?= base_url('shop') ?>" class="btn-view-all">
            Lihat Semua Menu <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="prod-grid gs-prod-grid">
        <?php if (!empty($featured_products) && is_array($featured_products)): ?>
          <?php foreach ($featured_products as $prod): ?>
            <div class="prod-card invisible-init perspective-card">
              <div class="prod-card-inner">
                  <div class="prod-img-wrap skeleton-box">
                    <div class="skeleton-img"></div>
                    <div class="prod-badge-wrap">
                      <?php if ($prod['stock'] > 0): ?>
                        <span class="prod-badge">Tersedia</span>
                      <?php else: ?>
                        <span class="prod-badge" style="background: rgba(229, 62, 62, 0.9); color: white;">Habis</span>
                      <?php endif; ?>
                    </div>
                    <?php
                    $img_link = base_url('assets/img/productORI.png'); // Default fallback
                    if (!empty($prod['image'])) {
                      if (file_exists(FCPATH . 'uploads/' . $prod['image'])) {
                        $img_link = base_url('uploads/' . $prod['image']);
                      } elseif (file_exists(FCPATH . 'assets/img/' . $prod['image'])) {
                        $img_link = base_url('assets/img/' . $prod['image']);
                      }
                    }
                    ?>
                    <img src="<?= $img_link ?>" alt="<?= htmlspecialchars($prod['name']) ?>" loading="lazy"
                      onerror="this.src='<?= base_url('assets/img/productORI.png'); ?>'">
                  </div>
                <div class="prod-body">
                  <div class="prod-header">
                    <h3 class="prod-name"><?= htmlspecialchars($prod['name']) ?></h3>
                    <div class="prod-price">Rp <?= number_format($prod['price'], 0, ',', '.') ?></div>
                  </div>
                  <div class="prod-desc">
                    <?= htmlspecialchars($prod['description'] ?? 'Minuman matcha segar dengan resep rahasia.') ?>
                  </div>
                  <?php if ($prod['stock'] > 0): ?>
                    <?php if ($this->session->userdata('role') == 'admin'): ?>
                      <div class="btn-add-cart text-center"
                        style="background:#eef3eb; color:#8aa898; cursor:default; box-shadow:none;">
                        <i class="fa-solid fa-lock me-1"></i> Mode Kelola
                      </div>
                    <?php else: ?>
                      <a href="<?= base_url('shop/add_to_cart/' . $prod['id']) ?>" class="btn-add-cart">
                        <i class="fa-solid fa-cart-shopping me-1"></i> Tambah Keranjang
                      </a>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="btn-add-cart sold-out">
                      <i class="fa-solid fa-ban me-1"></i> Stok Habis
                    </span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Dummy Products for UI testing if data is empty -->
          <div class="prod-card invisible-init perspective-card">
            <div class="prod-card-inner">
              <div class="prod-img-wrap">
                <div class="prod-badge-wrap"><span class="prod-badge">Terlaris</span></div>
                <img src="https://images.unsplash.com/photo-1597481499750-3e6b22637e12?q=80&w=400&auto=format&fit=crop"
                  alt="Signature Iced Matcha" loading="lazy">
              </div>
              <div class="prod-body">
                <div class="prod-header">
                  <h3 class="prod-name">Iced Matcha Latte</h3>
                  <div class="prod-price">Rp 45k</div>
                </div>
                <div class="prod-desc">Uji Grade A + Oat Milk. Perpaduan matcha premium dengan susu segar.</div>
                <a href="#" class="btn-add-cart shimmer-btn"><i class="fa-solid fa-cart-shopping me-1"></i> Tambah
                  Keranjang</a>
              </div>
            </div>
          </div>
          <div class="prod-card invisible-init perspective-card">
            <div class="prod-card-inner">
              <div class="prod-img-wrap">
                <div class="prod-badge-wrap"><span class="prod-badge">Baru</span></div>
                <img src="https://images.unsplash.com/photo-1582785515220-410a563ee9a7?q=80&w=400&auto=format&fit=crop"
                  alt="Matcha Oat Latte" loading="lazy">
              </div>
              <div class="prod-body">
                <div class="prod-header">
                  <h3 class="prod-name">Ceremonial Hot Matcha</h3>
                  <div class="prod-price">Rp 42k</div>
                </div>
                <div class="prod-desc">Pure whisked tradition. Pilihan autentik yang menenangkan.</div>
                <a href="#" class="btn-add-cart shimmer-btn"><i class="fa-solid fa-cart-shopping me-1"></i> Tambah
                  Keranjang</a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ══════════ CARA PESAN ══════════ -->
  <section id="cara-pesan" class="steps-section">
    <div class="container">
      <div class="text-center mb-5 reveal-up invisible-init">
        <div class="section-label"><i class="fa-solid fa-map-signs"></i> Panduan Pesan</div>
        <h2 class="section-h2">Cara Pesan di MariMatcha</h2>
        <p class="section-sub mx-auto">Cuma 4 langkah mudah, pesananmu langsung diproses dan dikirim!</p>
      </div>
      <div class="row g-4 gs-steps-row">
        <?php
        $steps = [
          ['num' => '1', 'icon' => 'fa-mug-hot', 'title' => 'Pilih Menu', 'desc' => 'Jelajahi katalog dan pilih minuman matcha favoritmu.'],
          ['num' => '2', 'icon' => 'fa-cart-plus', 'title' => 'Tambah Keranjang', 'desc' => 'Masukkan item ke keranjang, atur jumlah kebutuhan.'],
          ['num' => '3', 'icon' => 'fa-credit-card', 'title' => 'Checkout & Bayar', 'desc' => 'Isi data pengiriman lalu transfer ke rekening kami.'],
          ['num' => '4', 'icon' => 'fa-paper-plane', 'title' => 'Upload Bukti', 'desc' => 'Upload bukti transfer, kami proses dan segera kirim!'],
        ];
        foreach ($steps as $i => $s):
          ?>
          <div class="col-sm-6 col-lg-3">
            <div class="step-card invisible-init">
              <div class="step-num"><i class="fa-solid <?= $s['icon'] ?>"></i></div>
              <h5><?= $s['title'] ?></h5>
              <p><?= $s['desc'] ?></p>
              <?php if ($i < 3): ?>
                <div class="step-connector d-none d-lg-flex"><i class="fa-solid fa-chevron-right"></i></div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-5 reveal-up invisible-init">
        <a href="<?= base_url('shop') ?>" class="btn-view-all">
          <i class="fa-solid fa-bag-shopping"></i> Mulai Belanja Sekarang
        </a>
      </div>
    </div>
  </section>

  <!-- ══════════ TENTANG ══════════ -->
  <section id="tentang" class="about-section">
    <div class="container">
      <div class="row align-items-center gy-5 gs-about-row">
        <div class="col-lg-5 about-img-col invisible-init">
          <div class="about-img-wrap"
            style="display:flex; align-items:center; justify-content:center; background:#f4f9f6; border-radius:24px; padding:40px;">
            <?php $shop_logo = $this->M_settings->get_setting('shop_logo'); ?>
            <?php if (!empty($shop_logo)): ?>
              <img src="<?= base_url('uploads/' . $shop_logo) ?>" alt="MariMatcha Store"
                style="width:100%; height:auto; max-height:400px; object-fit:contain; animation: float 6s ease-in-out infinite;">
            <?php else: ?>
              <i class="fa-solid fa-leaf text-success" style="font-size:120px; opacity:0.2;"></i>
            <?php endif; ?>

            <div class="about-badge">
              <div style="font-size:0.85rem;color:var(--text-muted);font-weight:600">Sudah dipercaya</div>
              <div style="font-size:1.6rem;font-weight:900;color:var(--green-dark)">500+ Pelanggan</div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 ps-lg-5 about-text-col invisible-init">
          <div class="section-label"><i class="fa-solid fa-leaf"></i> Tentang Kami</div>
          <h2 class="section-h2">Kenapa Pilih <br>MariMatcha?</h2>
          <p class="section-sub mb-4">Kami UMKM asal Tangerang yang berdedikasi menghadirkan minuman berbahan matcha
            berkualitas premium. Semua produk dibuat segar setiap hari, khusus untuk kamu!</p>

          <div class="d-flex flex-column gap-3 gs-features">
            <?php
            $features = [
              ['icon' => 'fa-award', 'title' => 'Bahan Berkualitas Premium', 'desc' => 'Matcha grade premium, diproses higienis dan disajikan segar setiap hari.'],
              ['icon' => 'fa-truck-fast', 'title' => 'Pengiriman Cepat & Aman', 'desc' => 'Siap kirim dari Tangerang ke seluruh wilayah Indonesia dengan packaging rapi.'],
              ['icon' => 'fa-shield-halved', 'title' => 'Terpercaya & Halal', 'desc' => 'Produk dijamin kebersihannya, halal, dan sudah dipercaya ratusan pelanggan.'],
            ];
            foreach ($features as $f):
              ?>
              <div class="feature-card invisible-init">
                <div class="feature-icon-wrap"><i class="fa-solid <?= $f['icon'] ?>"></i></div>
                <div>
                  <h6><?= $f['title'] ?></h6>
                  <p><?= $f['desc'] ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════ TESTIMONIAL ══════════ -->
  <section class="testi-section" id="ulasan">
    <div class="container">
      <div class="text-center mb-5 reveal-up invisible-init">
        <div class="section-label"><i class="fa-solid fa-star"></i> Ulasan Pelanggan</div>
        <h2 class="section-h2">Kata Mereka Tentang Kami</h2>
        <p class="section-sub mx-auto">Lebih dari ratusan pelanggan puas setiap bulannya. Ini yang mereka katakan.</p>
      </div>
      <div class="testi-slider-container reveal-up invisible-init gs-testi-row">
        <div class="testi-slider" id="testiSlider">
          <?php if (!empty($testimonials)):
            foreach ($testimonials as $t): ?>
              <div class="testi-item">
                <div class="testi-card">
                  <div class="testi-stars"><?= str_repeat('<i class="fa-solid fa-star"></i>', $t['stars']) ?></div>
                  <p class="testi-quote" style="min-height: 100px;">"<?= htmlspecialchars($t['quote']) ?>"</p>
                  <div class="testi-user mt-4">
                    <div class="testi-avatar"
                      style="background-color: var(--tertiary-light); color: var(--green-dark); font-weight: bold;">
                      <?= strtoupper(substr($t['name'] ?? 'M', 0, 1)) ?>
                    </div>
                    <div>
                      <div class="testi-name"><?= htmlspecialchars($t['name'] ?? 'Pelanggan') ?></div>
                      <div class="testi-loc" style="font-size: 0.8rem;"><i
                          class="fa-solid fa-location-dot me-1"></i><?= htmlspecialchars($t['location'] ?? 'Indonesia') ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; else: ?>
            <div class="col-12 text-center text-muted py-4 w-100">Belum ada ulasan yang ditampilkan.</div>
          <?php endif; ?>
        </div>

        <div class="testi-nav">
          <div class="testi-btn" onclick="slideTesti('left')"><i class="fa-solid fa-chevron-left"></i></div>
          <div class="testi-btn" onclick="slideTesti('right')"><i class="fa-solid fa-chevron-right"></i></div>
        </div>
      </div>

      <!-- PREMIUM REVIEW FORM -->
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="review-form-card reveal-up invisible-init">
            <h4 class="mb-4 text-center">
              <?= !empty($my_review) ? 'Edit Ulasan Kamu' : 'Beri Ulasan Kamu' ?>
              <i class="fa-solid fa-heart ms-2" style="color:var(--accent)"></i>
            </h4>
            <form action="<?= base_url('home/submit_review') ?>" method="POST">
              <div class="row g-4 gs-prod-grid">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="small fw-bold text-muted mb-2 ms-2">NAMA LENGKAP</label>
                    <input type="text" name="name" class="form-control" placeholder="Tulis nama kamu..."
                      value="<?= htmlspecialchars($my_review['name'] ?? $this->session->userdata('full_name') ?? '') ?>"
                      required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="small fw-bold text-muted mb-2 ms-2">LOKASI (KOTA)</label>
                    <input type="text" name="location" class="form-control" placeholder="Contoh: Bekasi, Tangerang..."
                      value="<?= htmlspecialchars($my_review['location'] ?? '') ?>">
                  </div>
                </div>

                <div class="col-12 py-2">
                  <div class="section-label d-flex justify-content-center mb-0" style="font-size: 0.7rem;">Nilai
                    Pengalamanmu</div>
                  <div class="star-rating-input">
                    <?php $currStars = $my_review['stars'] ?? 5; ?>
                    <input type="radio" name="stars" value="5" id="st5" <?= ($currStars == 5) ? 'checked' : '' ?>><label
                      for="st5"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" name="stars" value="4" id="st4" <?= ($currStars == 4) ? 'checked' : '' ?>><label
                      for="st4"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" name="stars" value="3" id="st3" <?= ($currStars == 3) ? 'checked' : '' ?>><label
                      for="st3"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" name="stars" value="2" id="st2" <?= ($currStars == 2) ? 'checked' : '' ?>><label
                      for="st2"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" name="stars" value="1" id="st1" <?= ($currStars == 1) ? 'checked' : '' ?>><label
                      for="st1"><i class="fa-solid fa-star"></i></label>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label class="small fw-bold text-muted mb-2 ms-2">ULASAN / PESAN KAMU</label>
                    <textarea name="quote" class="form-control" rows="4"
                      placeholder="Ceritakan pengalamanmu mengonsumsi produk MariMatcha..."
                      required><?= htmlspecialchars($my_review['quote'] ?? '') ?></textarea>
                  </div>
                </div>

                <div class="col-12 text-center mt-4">
                  <button type="submit" class="btn-hero-primary"
                    style="padding: 18px 60px; border-radius: 50px; font-size: 1.1rem; width: 100%;">
                    <?= !empty($my_review) ? 'Update Ulasan Saya' : 'Kirim Ulasan Sekarang' ?> <i
                      class="fa-solid fa-paper-plane ms-2"></i>
                  </button>
                  <?php if (!empty($my_review)): ?>
                    <p class="small text-muted mt-3"><i class="fa-solid fa-info-circle me-1"></i> Kamu sudah memberikan
                      ulasan. Mengirim ulang akan memperbarui ulasan lamamu.</p>
                  <?php endif; ?>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════ WA BANNER ══════════ -->
  <section class="wa-section">
    <div class="container reveal-up invisible-init">
      <div class="wa-card gs-wa-card">
        <i class="fa-brands fa-whatsapp"
          style="font-size:4rem; margin-bottom:20px; display:block; position:relative; z-index:1;"></i>
        <h3>Ada Pertanyaan atau Custom Order?</h3>
        <p>Jangan ragu untuk bertanya! Tim CS kami siap membantu kelancaran pesanan kamu dengan respon yang cepat.</p>
        <a href="https://wa.me/<?= $this->config->item('admin_wa') ?>?text=Halo+MariMatcha,+saya+mau+tanya+pesanan"
          target="_blank" rel="noopener noreferrer" class="btn-wa-big">
          <i class="fa-brands fa-whatsapp" style="font-size:1.3rem"></i> Chat WhatsApp Sekarang
        </a>
      </div>
    </div>
  </section>

  <!-- ══════════ ELEGANT MAP SECTION ══════════ -->
  <section class="premium-map-section" id="lokasi-kami">
    <div class="map-bg-glow"></div>
    <div class="container reveal-up">
      <div class="text-center mb-5">
        <h2 class="section-h2 text-white">Dikirim ke <span style="color: var(--tertiary);">Seluruh Indonesia</span></h2>
        <p style="color: rgba(255,255,255,0.6); max-width: 600px; margin: 0 auto; font-size: 1.1rem;">Dari jantung
          Tangerang, kami memastikan setiap produk MariMatcha sampai di tangan Anda dalam kondisi segar dan sempurna.
        </p>
      </div>

      <div class="premium-map-container">
        <div class="map-scroll-wrapper">
          <!-- Elegant Minimalist Map of Indonesia SVG -->
          <svg class="id-map-organic-svg" viewBox="0 0 1000 400" xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="xMidYMid meet">
            
            <!-- Subtle Coordinate Grid Lines -->
            <line x1="100" y1="0" x2="100" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="200" y1="0" x2="200" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="300" y1="0" x2="300" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="400" y1="0" x2="400" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="500" y1="0" x2="500" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="600" y1="0" x2="600" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="700" y1="0" x2="700" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="800" y1="0" x2="800" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="900" y1="0" x2="900" y2="400" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            
            <line x1="0" y1="50" x2="1000" y2="50" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="0" y1="100" x2="1000" y2="100" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="0" y1="150" x2="1000" y2="150" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="0" y1="200" x2="1000" y2="200" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="0" y1="250" x2="1000" y2="250" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="0" y1="300" x2="1000" y2="300" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />
            <line x1="0" y1="350" x2="1000" y2="350" stroke="rgba(83, 114, 93, 0.08)" stroke-width="0.8" />

            <!-- Flowing elegant paths representing Indonesia's 5 major islands -->
            <!-- Sumatra -->
            <path class="map-curve" d="M90,70 C140,90 200,160 260,230 C280,250 300,285 295,295 C285,295 260,270 230,240 C170,180 110,130 85,90 C80,80 85,75 90,70 Z" />
            <!-- Jawa -->
            <path class="map-curve" d="M295,300 C330,305 380,310 440,312 C490,315 520,318 520,325 C500,332 440,332 380,330 C340,325 300,315 295,300 Z" />
            <!-- Kalimantan -->
            <path class="map-curve" d="M400,90 C430,70 480,75 510,95 C530,120 540,150 525,185 C510,215 450,225 410,200 C370,170 380,120 400,90 Z" />
            <!-- Sulawesi -->
            <path class="map-curve" d="M570,120 Q610,115 650,115 Q610,130 595,145 Q620,155 640,160 Q610,170 590,175 Q605,200 620,220 Q590,210 580,185 Q570,205 565,225 Q560,195 570,175 Q540,175 525,170 Q555,160 575,150 Q565,135 570,120 Z" />
            <!-- Papua -->
            <path class="map-curve" d="M770,195 C750,180 770,165 800,165 C840,165 870,180 890,185 C925,190 945,195 940,210 C930,235 900,240 880,240 C850,240 830,230 810,235 C790,240 780,220 770,195 Z" />

            <!-- Smaller Islands / Nusa Tenggara & Maluku -->
            <circle cx="530" cy="328" r="3" class="map-curve-dot" />
            <circle cx="550" cy="329" r="4" class="map-curve-dot" />
            <circle cx="575" cy="331" r="3.5" class="map-curve-dot" />
            <circle cx="600" cy="332" r="5" class="map-curve-dot" />
            <path class="map-curve" d="M640,332 Q680,335 720,325 Q680,328 640,332 Z" />

            <!-- Connection Lines radiating from Tangerang (320, 305) -->
            <path class="map-connection c1" d="M320,305 Q220,200 150,130" /> <!-- To Medan -->
            <path class="map-connection c2" d="M320,305 Q380,220 470,165" /> <!-- To Balikpapan -->
            <path class="map-connection c3" d="M320,305 Q450,230 580,180" /> <!-- To Makassar -->
            <path class="map-connection c4" d="M320,305 Q600,200 900,205" /> <!-- To Jayapura -->
            <path class="map-connection c5" d="M320,305 Q390,315 450,320" /> <!-- To Surabaya -->

            <!-- Elegant Compass Rose in Top Right -->
            <g transform="translate(880, 80) scale(0.8)" opacity="0.45">
              <circle cx="0" cy="0" r="40" fill="none" stroke="#53725D" stroke-width="1.2" stroke-dasharray="2 2" />
              <circle cx="0" cy="0" r="34" fill="none" stroke="#53725D" stroke-width="1" />
              <path d="M 0,-44 L 6,-10 L 0,0 L -6,-10 Z" fill="#2d4031" />
              <path d="M 0,44 L 6,10 L 0,0 L -6,10 Z" fill="#8baa7c" />
              <path d="M 44,0 L 10,6 L 0,0 L 10,-6 Z" fill="#2d4031" />
              <path d="M -44,0 L -10,6 L 0,0 L -10,-6 Z" fill="#8baa7c" />
              <text x="-4" y="-48" font-size="10" font-family="Outfit" font-weight="900" fill="#2d4031">N</text>
            </g>

            <!-- Vintage Red X Tangerang Marker -->
            <g transform="translate(320, 305)">
              <line x1="-7" y1="-7" x2="7" y2="7" stroke="#d63031" stroke-width="2.5" stroke-linecap="round" />
              <line x1="7" y1="-7" x2="-7" y2="7" stroke="#d63031" stroke-width="2.5" stroke-linecap="round" />
              <text x="-18" y="24" font-size="9" font-family="monospace" font-weight="800" fill="#1b2e21" letter-spacing="1">TNG-ID</text>
            </g>
          </svg>

          <!-- Elegant Location Marker Glow (Pulsing around the X) -->
          <div class="premium-marker" style="top: 76.25%; left: 32%;">
            <div class="marker-pulse" style="background: rgba(214, 48, 49, 0.45);"></div>
          </div>

          <!-- Destination Cities (Interactive Dots with Tooltips) -->
          <div class="dest-dot" style="top: 32.5%; left: 15%;" data-city="Medan (2-3 Hari)"></div>
          <div class="dest-dot" style="top: 80%; left: 45%;" data-city="Surabaya (1-2 Hari)"></div>
          <div class="dest-dot" style="top: 41.25%; left: 47%;" data-city="Balikpapan (2-3 Hari)"></div>
          <div class="dest-dot" style="top: 45%; left: 58%;" data-city="Makassar (2-3 Hari)"></div>
          <div class="dest-dot" style="top: 51.25%; left: 90%;" data-city="Jayapura (4-5 Hari)"></div>

          <!-- Hover Location Card (Tangerang) -->
          <div class="location-card" style="top: 59%; left: 32%;">
            <div class="loc-title">MariMatcha</div>
            <div class="loc-desc"><i class="fa-solid fa-location-dot me-1"></i> Tangerang, Banten</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    /* ─── PREMIUM STORY STYLES ─── */
    .premium-story-section {
      background: var(--green-dark);
      position: relative;
      overflow: hidden;
      height: 100vh;
    }

    .story-bg-text-wrapper {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      pointer-events: none;
      z-index: 1;
      opacity: 0.015;
      overflow: hidden;
      filter: blur(1px);
    }


    .story-bg-text {
      font-size: clamp(8rem, 22vw, 25rem);
      font-weight: 950;
      color: #fff;
      white-space: nowrap;
      line-height: 0.82;
      letter-spacing: -0.03em;
      text-transform: uppercase;
      user-select: none;
    }

    .story-track {
      position: relative;
      width: 100%;
      height: 100%;
      z-index: 2;
    }

    .story-slide {
      position: absolute;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100dvh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 5%;
      padding-bottom: 50px; /* Push content up slightly */
      opacity: 0;
      visibility: hidden;
      will-change: transform, opacity, filter;
    }

    .glass-content-wrap {
      background: rgba(255, 255, 255, 0.03);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 40px;
      padding: 60px 80px;
      box-shadow: 0 40px 100px rgba(0, 0, 0, 0.3);
      max-width: 1100px;
      margin: 0 auto;
      transform: translateY(-20px); /* Move card up visually */
    }


    .story-label {
      color: var(--tertiary);
      font-weight: 800;
      letter-spacing: 4px;
      font-size: 0.9rem;
      margin-bottom: 20px;
      display: block;
    }

    .story-h2 {
      font-size: clamp(2.4rem, 5vw, 3.2rem);
      font-weight: 900;
      color: #fff;
      margin-bottom: 24px;
      line-height: 1.2;
      letter-spacing: -1.5px;
    }


    .story-h2.lg {
      font-size: 6rem;
      text-align: center;
    }

    .story-h2 .highlight {
      color: var(--tertiary);
      position: relative;
    }


    .story-p {
      color: rgba(255, 255, 255, 0.7);
      font-size: 1.25rem;
      line-height: 1.7;
      max-width: 500px;
      margin-bottom: 40px;
      font-weight: 500;
    }


    .story-p.center {
      margin: 0 auto 40px;
      text-align: center;
      max-width: 600px;
    }

    .story-stats-row {
      display: flex;
      gap: 30px;
    }

    .s-stat {
      color: #fff;
      font-weight: 600;
      font-size: 0.9rem;
    }

    .s-stat span {
      display: block;
      font-size: 1.8rem;
      font-weight: 900;
      color: var(--tertiary);
    }

    .floating-img-frame {
      position: relative;
      width: 100%;
      max-width: 320px;
      margin: 0 auto;
    }

    .floating-img-frame img {
      width: 100%;
      aspect-ratio: 1/1;
      object-fit: cover;
      border-radius: 40px;
      transform: rotate(-1.5deg);
      box-shadow: 0 40px 100px rgba(0, 0, 0, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }


    .floating-img-frame.s2 img {
      transform: rotate(1.5deg);
    }


    .floating-badge {
      position: absolute;
      bottom: -20px;
      right: -20px;
      background: var(--tertiary);
      color: var(--green-dark);
      padding: 20px 30px;
      font-weight: 900;
      border-radius: 20px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      transform: rotate(10deg);
      font-size: 1.1rem;
    }

    .final-reveal-wrap {
      text-align: center;
      position: relative;
    }

    .btn-macha-white {
      display: inline-flex;
      align-items: center;
      background: #fff;
      color: var(--green-dark);
      padding: 20px 45px;
      border-radius: 100px;
      font-weight: 800;
      font-size: 1.2rem;
      text-decoration: none;
      transition: all 0.4s ease;
      box-shadow: 0 15px 40px rgba(255, 255, 255, 0.2);
    }

    .btn-macha-white:hover {
      transform: translateY(-10px) scale(1.05);
      background: var(--tertiary);
      color: #fff;
    }

    .floating-elements {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      pointer-events: none;
    }

    .f-leaf {
      position: absolute;
      font-size: 3rem;
      filter: blur(2px);
    }

    .f-leaf.l1 {
      top: -50px;
      left: 10%;
    }

    .f-leaf.l2 {
      bottom: -80px;
      right: 15%;
    }

    .f-leaf.l3 {
      top: 40%;
      right: 5%;
      font-size: 5rem;
    }

    @media (max-width: 991px) {
      .story-h2 {
        font-size: 2.8rem;
      }

      .glass-content-wrap {
        padding: 30px;
      }

      .story-slide {
        padding: 0 15px;
      }
    }

    @media (max-width: 768px) {
      .story-h2 {
        font-size: 1.8rem;
        margin-bottom: 15px;
      }

      .story-h2.lg {
        font-size: 2.5rem;
      }

      .story-p {
        font-size: 1rem;
        margin-bottom: 20px;
      }

      .glass-content-wrap {
        padding: 25px;
        border-radius: 25px;
      }

      .floating-img-frame {
        max-width: 220px;
        margin-top: 25px;
      }

      .floating-badge {
        padding: 10px 18px;
        font-size: 0.85rem;
        bottom: -10px;
        right: -10px;
      }

      .s-stat span {
        font-size: 1.4rem;
      }

      .btn-macha-white {
        padding: 15px 35px;
        font-size: 1.1rem;
      }

      .floating-cart {
        width: 60px;
        height: 60px;
        bottom: 20px;
        right: 20px;
        font-size: 1.3rem;
      }
    }
  </style>

  <!-- ══════════ FOOTER ══════════ -->
  <footer class="reveal-up invisible-init">
    <div class="container">
      <div class="row g-5 mb-5 gs-footer">
        <div class="col-lg-4 invisible-init">
          <div class="footer-brand mb-4">
            <div class="footer-brand-icon"><i class="fa-solid fa-leaf" style="color:#fff;font-size:1.1rem"></i></div>
            MariMatcha
          </div>
          <p class="footer-desc">Crafting the finest premium matcha experiences in Tangerang. Our journey is about
            purity, tradition, and refreshing moments in every cup.</p>
          <div class="footer-social">
            <a href="https://www.instagram.com/marimatcha_panongan?igsh=Y2F0NGs5YjMwa3N4" class="social-btn"
              title="Instagram" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://wa.me/<?= $this->config->item('admin_wa') ?>" class="social-btn" title="WhatsApp"><i
                class="fa-brands fa-whatsapp"></i></a>
            <a href="#" class="social-btn" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
            <a href="#" class="social-btn" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
          </div>
        </div>
        <div class="col-md-4 col-lg-2 offset-lg-1 invisible-init">
          <div class="footer-heading">Navigasi</div>
          <a class="footer-link" href="<?= base_url() ?>"><i class="fa-solid fa-chevron-right"></i> Beranda</a>
          <a class="footer-link" href="<?= base_url('shop') ?>"><i class="fa-solid fa-chevron-right"></i> Katalog</a>
          <a class="footer-link" href="#tentang"><i class="fa-solid fa-chevron-right"></i> Tentang</a>
          <a class="footer-link" href="#cara-pesan"><i class="fa-solid fa-chevron-right"></i> Pesan</a>
          <a class="footer-link" href="#lokasi-kami"><i class="fa-solid fa-chevron-right"></i> Lokasi</a>
        </div>
        <div class="col-md-4 col-lg-2 invisible-init">
          <div class="footer-heading">Kontak</div>
          <div class="status-active-wrap">
            <div class="status-active">
              <div class="active-dot"></div> ACTIVE
            </div>
          </div>
          <a class="footer-link" href="https://wa.me/<?= $this->config->item('admin_wa') ?>" target="_blank"
            rel="noopener noreferrer" style="color: #fff; font-weight: 700;">
            <i class="fa-brands fa-whatsapp"></i> 0<?= substr($this->config->item('admin_wa'), 2) ?>
          </a>
          <p class="footer-link mb-2"><i class="fa-regular fa-envelope"></i> hello@marimacha.id</p>
          <p class="footer-link"><i class="fa-solid fa-clock"></i> 09:00 - 21:00 WIB</p>
        </div>
        <div class="col-md-4 col-lg-3 invisible-init">
          <div class="footer-heading">Lokasi Kami</div>
          <p class="footer-link mb-3"><i class="fa-solid fa-map-pin me-2"></i> Citra Raya, Tangerang, Banten</p>
          <a href="https://maps.app.goo.gl/dsyGHbvKsbVAKbiJ9" target="_blank" rel="noopener noreferrer"
            class="footer-location-img-wrap">
            <img src="<?= base_url('assets/img/macha_location_footer.png'); ?>" alt="Location Map Preview"
              onerror="this.src='https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=400&auto=format&fit=crop'">
            <div class="map-overlay-text">
              <i class="fa-solid fa-up-right-from-square"></i> Lihat di Google Maps
            </div>
          </a>
        </div>
      </div>
      <hr class="footer-divider" style="opacity: 0.1; background: #fff;">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start">
          <p class="footer-copy mb-0">© <?= date('Y') ?> <strong style="color:#fff">MariMatcha Premium</strong> ·
            Crafting Quality.</p>
        </div>
        <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
          <div class="d-flex gap-3 justify-content-center justify-content-md-end footer-copy">
            <span>Privacy Policy</span>
            <span>Terms of Service</span>
          </div>
        </div>
      </div>
    </div>
  </footer>


  <!-- ══════════ FLOATING CART ══════════ -->
  <?php 
  $cart = $this->session->userdata('cart') ?? [];
  $current_cart_count = is_array($cart) ? count($cart) : 0;
  if ($current_cart_count > 0): 
  ?>
    <a href="<?= base_url('shop/cart') ?>" class="floating-cart" title="Lihat Keranjang (<?= $current_cart_count ?> item)">
      <i class="fa-solid fa-cart-shopping"></i>
      <span class="fc-badge"><?= $current_cart_count ?></span>
    </a>
  <?php endif; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- GSAP & ScrollTrigger JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

  <div class="scroll-progress" id="scrollProgress"></div>
  <div class="m-cursor" id="cursor"></div>
  <div class="m-follower" id="follower">
    <div class="follower-text">LIHAT</div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // 1. REVEAL SITE FALLBACK (Safety)
      const forceReveal = setTimeout(() => {
        const p = document.getElementById('preloader');
        if (p && p.style.display !== 'none') {
          p.style.opacity = '0';
          setTimeout(() => p.style.display = 'none', 500);
          document.body.classList.add('site-ready');
        }
      }, 5000);

      // 2. SMOOTH SCROLL (Lenis synced with GSAP Ticker for 120Hz+ displays)
      const lenis = new Lenis({
        duration: 1.1, // Snappier and more responsive
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
        smoothTouch: false
      });

      lenis.on('scroll', ScrollTrigger.update);
      
      gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
      });
      gsap.ticker.lagSmoothing(0);

      // 2. MAGNETIC BUTTONS LOGIC (Only Desktop)
      if (!('ontouchstart' in window)) {
        const magneticTargets = document.querySelectorAll('.btn-hdr, .btn-hero-primary, .btn-hero-wa, .btn-add-cart, .btn-view-all, .social-btn, .navbar-brand');
        magneticTargets.forEach(btn => {
          btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            gsap.to(btn, {
              x: x * 0.35,
              y: y * 0.35,
              duration: 0.4,
              ease: "power2.out"
            });
          });
          btn.addEventListener('mouseleave', () => {
            gsap.to(btn, { x: 0, y: 0, duration: 0.6, ease: "elastic.out(1, 0.3)" });
          });
        });
      }

      // 1. LIBS REGISTRATION
      gsap.registerPlugin(ScrollTrigger);

      // 2. MOBILE OPTIMIZATION
      if (window.innerWidth <= 1024) {
        ScrollTrigger.normalizeScroll({ allowNestedScroll: true });
        ScrollTrigger.config({ ignoreMobileResize: true });
      }



      // 4. MOUSE CURSOR (Desktop Only)
      if (window.innerWidth > 1024) {
        const cursor = document.getElementById('cursor');
        const follower = document.getElementById('follower');
        window.addEventListener('mousemove', (e) => {
          gsap.to(cursor, { x: e.clientX, y: e.clientY, duration: 0.1 });
          gsap.to(follower, { x: e.clientX - 20, y: e.clientY - 20, duration: 0.4, ease: "power3.out" });
        });
      }

      // 4. PRELOADER & HERO ENTRANCE (PRO)
      let progress = 0;
      const pNum = document.getElementById('preloaderNum');
      const pBar = document.getElementById('preloaderBar');
      const preloaderLogoImg = document.getElementById('preloaderLogoImg');

      function startProgress() {
        if (window.progressIntervalStarted) return;
        window.progressIntervalStarted = true;
        const progressInterval = setInterval(() => {
          progress += Math.floor(Math.random() * 15) + 5;
          if (progress >= 100) {
            progress = 100;
            clearInterval(progressInterval);
            clearTimeout(forceReveal);
            revealSite();
          }
          if (pNum) pNum.innerText = progress + "%";
          if (pBar && typeof gsap !== 'undefined') {
            gsap.to(pBar, { width: progress + "%", duration: 0.1 });
          }
        }, 50);
      }

      if (preloaderLogoImg) {
        if (preloaderLogoImg.complete) {
          startProgress();
        } else {
          preloaderLogoImg.addEventListener('load', startProgress);
          preloaderLogoImg.addEventListener('error', startProgress);
          // Safety fallback if it takes longer than 1.5 seconds to load the image
          setTimeout(startProgress, 1500);
        }
      } else {
        startProgress();
      }

      function revealSite() {
        if (typeof gsap === 'undefined') {
          const p = document.getElementById('preloader');
          if (p) p.style.display = 'none';
          return;
        }

        const tl = gsap.timeline({
          onComplete: () => {
            const p = document.getElementById('preloader');
            if (p) p.style.display = 'none';
            document.body.classList.add('site-ready');
            if (typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();
          }
        });

        tl.to('.preloader-bar-wrap, .preloader-num', {
          opacity: 0, y: -20, duration: 0.4
        })
        .to('#preloaderLogo', {
          scale: 35, opacity: 0, duration: 1.4, ease: "power4.in"
        }, "-=0.2")
        .to('#preloader', {
          filter: "blur(60px)", opacity: 0, duration: 1, ease: "power2.inOut"
        }, "-=0.8")
        .fromTo('.navbar-macha', { y: -80, opacity: 0 }, { y: 0, opacity: 1, duration: 1, ease: "expo.out" }, "-=0.4")
        .fromTo('.line-inner', { y: "110%" }, { y: "0%", duration: 1.2, stagger: 0.15, ease: "power4.out" }, "-=0.6")
        .fromTo('.hero-desc, .hero-cta, .hero-stats', { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 1, stagger: 0.1, ease: "power3.out" }, "-=0.8")
        .fromTo('.hero-img-wrap', { scale: 0.8, opacity: 0, rotate: 5 }, { scale: 1, opacity: 1, rotate: 0, duration: 1.5, ease: "power4.out" }, "-=1.2");
      }

      // 5. SCROLL PROGRESS & RESPONSIVE MENU
      // Testimonial Slider Navigation
      window.slideTesti = function(dir) {
        const slider = document.getElementById('testiSlider');
        if(!slider) return;
        const scrollAmount = slider.offsetWidth > 768 ? 400 : slider.offsetWidth * 0.85;
        if (dir === 'left') {
          slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
          slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
      };

      // Existing parallax & logic
      window.addEventListener('scroll', () => {
        const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
        gsap.to('#scrollProgress', { width: scrolled + "%", duration: 0.1 });

        const nav = document.getElementById('mainNav');
        if (window.scrollY > 50) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
      });

      const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
      const navbarCollapse = document.getElementById('navMain');
      navLinks.forEach(link => {
        link.addEventListener('click', () => {
          if (navbarCollapse.classList.contains('show')) {
            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse, { toggle: false });
            bsCollapse.hide();
          }
        });
      });

      // 6. SCROLL TRIGGER ANIMATIONS & UTILS
      gsap.registerPlugin(ScrollTrigger);
      
      // Normalize scroll for mobile to prevent stuttering
      if (window.innerWidth <= 1024) {
        ScrollTrigger.normalizeScroll({ allowNestedScroll: true });
        ScrollTrigger.config({ ignoreMobileResize: true });
      }

      const commonTrigger = (el) => ({ trigger: el, start: "top 85%", toggleActions: "play none none reverse" });

      // 6. PREMIUM STORYTELLING: CENTER REVEAL & SCATTER
      if (document.querySelector('#storySection')) {
        const slides = gsap.utils.toArray('.story-slide');
        const storyTl = gsap.timeline({
          scrollTrigger: {
            trigger: "#storySection",
            start: "top top",
            end: "+=3500", // Increased duration for smoothness
            scrub: 1.2,
            pin: true,
            anticipatePin: 1
          }
        });

        // Parallax background text movement
        storyTl.to(".story-bg-text", {
          x: '-20%',
          duration: 3,
          ease: "none"
        }, 0);

        // --- PHASE 01: Reveal & Move Up (Shadcn Sleek Style) ---
        storyTl.fromTo(slides[0], {
          y: 80,
          opacity: 0,
          visibility: "visible"
        }, {
          y: 0,
          opacity: 1,
          duration: 1,
          ease: "power4.out"
        })
        .to(slides[0], {
          y: -150,
          opacity: 0,
          scale: 0.95,
          filter: "blur(8px)",
          duration: 1,
          ease: "power3.inOut"
        }, "+=0.6");

        // --- PHASE 02: Reveal & Move Up ---
        storyTl.fromTo(slides[1], {
          y: 80,
          opacity: 0,
          visibility: "visible"
        }, {
          y: 0,
          opacity: 1,
          duration: 1,
          ease: "power4.out"
        }, "-=0.2")
        .to(slides[1], {
          y: -150,
          opacity: 0,
          scale: 0.95,
          filter: "blur(8px)",
          duration: 1,
          ease: "power3.inOut"
        }, "+=0.6");

        // --- PHASE 03: Reveal & Final Zoom ---
        storyTl.fromTo(slides[2], {
          y: 80,
          opacity: 0,
          visibility: "visible"
        }, {
          y: 0,
          opacity: 1,
          duration: 1,
          ease: "power4.out"
        }, "-=0.2")
        .to(slides[2], {
          scale: 1.2,
          opacity: 0,
          filter: "blur(20px)",
          duration: 1.2,
          ease: "power4.inOut"
        }, "+=0.8");

        // Background color transition
        ScrollTrigger.create({
          trigger: "#storySection",
          start: "top center",
          end: "bottom center",
          onEnter: () => gsap.to("body", { backgroundColor: "#102416", duration: 1 }),
          onLeave: () => gsap.to("body", { backgroundColor: "#F5F5F0", duration: 1 }),
          onEnterBack: () => gsap.to("body", { backgroundColor: "#102416", duration: 1 }),
          onLeaveBack: () => gsap.to("body", { backgroundColor: "#F5F5F0", duration: 1 })
        });
      }

      // Floating particles in story section (Disabled on mobile for performance)
      if (window.innerWidth > 768) {
        gsap.utils.toArray('.f-leaf').forEach(leaf => {
          gsap.to(leaf, {
            y: "random(-50, 50)",
            x: "random(-30, 30)",
            rotation: "random(-90, 90)",
            duration: "random(3, 6)",
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
          });
        });
      }

      // General reveals for elements with .reveal-up
      gsap.utils.toArray('.reveal-up').forEach(elem => {
        gsap.fromTo(elem, { y: 50, autoAlpha: 0 }, {
          y: 0, autoAlpha: 1, pointerEvents: "auto", duration: 1, ease: "power4.out",
          scrollTrigger: commonTrigger(elem)
        });
      });

      gsap.fromTo('.prod-card', { y: 60, autoAlpha: 0 }, {
        y: 0, autoAlpha: 1, pointerEvents: "auto", duration: 0.8, stagger: 0.15, ease: "power3.out",
        scrollTrigger: commonTrigger('.gs-prod-grid')
      });

      gsap.fromTo('.step-card', { x: -40, autoAlpha: 0 }, {
        x: 0, autoAlpha: 1, pointerEvents: "auto", duration: 0.8, stagger: 0.2,
        scrollTrigger: commonTrigger('.gs-steps-row')
      });

      gsap.fromTo('.testi-card', { scale: 0.9, autoAlpha: 0 }, {
        scale: 1, autoAlpha: 1, pointerEvents: "auto", duration: 0.6, stagger: 0.15, ease: "back.out(1.2)",
        scrollTrigger: commonTrigger('.gs-testi-row')
      });

      // About & Footer Animations (RE-ADDED)
      gsap.fromTo(".about-img-col", { x: -50, autoAlpha: 0 }, { x: 0, autoAlpha: 1, pointerEvents: "auto", duration: 0.8, ease: "power3.out", scrollTrigger: commonTrigger(".gs-about-row") });
      gsap.fromTo(".about-text-col", { x: 50, autoAlpha: 0 }, { x: 0, autoAlpha: 1, pointerEvents: "auto", duration: 0.8, ease: "power3.out", scrollTrigger: commonTrigger(".gs-about-row") });
      gsap.fromTo(".feature-card", { y: 30, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 0.6, stagger: 0.15, ease: "power3.out", scrollTrigger: commonTrigger(".gs-features") });
      gsap.fromTo(".gs-footer > div", { y: 40, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 0.8, stagger: 0.2, ease: "power3.out", scrollTrigger: commonTrigger(".gs-footer") });

      // Storytelling trigger for the Wa Section
      gsap.fromTo(".gs-wa-card", { y: 60, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 1, scrollTrigger: commonTrigger(".wa-section") });

      // Immersive Map Scroll Unrolling Animation (Parchment Effect)
      const mapScrollTl = gsap.timeline({
        scrollTrigger: {
          trigger: ".premium-map-section",
          start: "top 80%",
          end: "top 30%",
          scrub: 1.2,
          invalidateOnRefresh: true
        }
      });

      mapScrollTl.fromTo(".premium-map-container", 
        { 
          width: "32px",
          opacity: 0.7 
        }, 
        { 
          width: "100%", 
          opacity: 1, 
          ease: "power2.inOut" 
        }
      )
      .fromTo(".map-scroll-wrapper", 
        { 
          opacity: 0,
          scale: 0.95
        }, 
        { 
          opacity: 1,
          scale: 1,
          ease: "power2.out" 
        }, 
        "-=0.4"
      );

      // 3D TILT EFFECT REFINED
      document.querySelectorAll('.perspective-card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
          const rect = card.getBoundingClientRect();
          const dx = e.clientX - rect.left - rect.width / 2;
          const dy = e.clientY - rect.top - rect.height / 2;
          gsap.to(card.querySelector('.prod-card-inner'), {
            rotationY: dx / 12,
            rotationX: -dy / 12,
            duration: 0.4,
            ease: "power2.out"
          });
        });
        card.addEventListener('mouseleave', () => {
          gsap.to(card.querySelector('.prod-card-inner'), {
            rotationY: 0, rotationX: 0, duration: 0.6, ease: "elastic.out(1, 0.3)"
          });
        });
      });

      // Liquid BG Color Change
      ScrollTrigger.create({
        trigger: "#storySection",
        start: "top center",
        onEnter: () => gsap.to("body", { backgroundColor: "#102416", duration: 1 }),
        onLeaveBack: () => gsap.to("body", { backgroundColor: "#F5F5F0", duration: 1 })
      });

      // 7. IMMERSIVE HERO ZOOM REVEAL
      if (document.querySelector('.hero-zoom-outer')) {
        const heroTl = gsap.timeline({
          scrollTrigger: {
            trigger: ".hero-zoom-outer",
            start: "top top",
            end: "bottom bottom",
            scrub: 1,
            invalidateOnRefresh: true
          }
        });

        heroTl.to(".hero-text-col", {
          opacity: 0,
          x: -100,
          scale: 0.9,
          duration: 1,
          ease: "power2.in"
        }, 0)
        .to(".hero-img-wrap", {
          scale: 15,
          filter: "blur(20px)",
          opacity: 0,
          duration: 2,
          ease: "power2.in"
        }, 0)
        .to(".hero-decorative", {
          scale: 3,
          opacity: 0,
          duration: 1.5
        }, 0);
      }

      // 8. TESTIMONIAL FOCUS REVEAL (INVERSE ZOOM)
      const testiCards = gsap.utils.toArray('.testi-item');
      if (testiCards.length > 0) {
        testiCards.forEach((card, i) => {
          gsap.fromTo(card, {
            scale: 3,
            filter: "blur(20px)",
            opacity: 0,
            y: 100
          }, {
            scale: 1,
            filter: "blur(0px)",
            opacity: 1,
            y: 0,
            duration: 1.5,
            ease: "power3.out",
            scrollTrigger: {
              trigger: card,
              start: "top bottom",
              end: "top center",
              scrub: 1
            }
          });
        });
      }

      // 9. MAGNETIC BUTTONS EFFECT
      const magneticButtons = document.querySelectorAll('.btn-hero-primary, .btn-hero-wa, .btn-hdr, .btn-view-all');
      magneticButtons.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
          const rect = btn.getBoundingClientRect();
          const x = e.clientX - rect.left - rect.width / 2;
          const y = e.clientY - rect.top - rect.height / 2;
          gsap.to(btn, { x: x * 0.3, y: y * 0.3, duration: 0.4, ease: "power2.out" });
        });
        btn.addEventListener('mouseleave', () => {
          gsap.to(btn, { x: 0, y: 0, duration: 0.6, ease: "elastic.out(1, 0.3)" });
        });
      });

      // 10. GLOBAL SKELETON HANDLER
      window.addEventListener('load', () => {
        document.querySelectorAll('.skeleton-box').forEach(el => el.classList.add('loaded'));
      });

      ScrollTrigger.refresh();
    });

    // ─── TOUR DRIVER.JS HOME ───
    const driver = window.driver.js.driver;
    
    // Siapkan step dasar
    let tourSteps = [
      { popover: { title: 'Welcome to MariMatcha! 🍃', description: 'Siap untuk merasakan matcha premium terbaik? Mari kita mulai tour singkat ini.' } },
      { element: '.navbar-macha', popover: { title: 'Menu Navigasi', description: 'Gunakan navigasi utama ini untuk pindah ke Katalog Menu, melihat Keranjang, atau masuk ke Akun kamu.', side: "bottom", align: 'center' } }
    ];

    // Cek jika di perangkat mobile, tambahkan panduan mobile navbar
    if (window.innerWidth < 992) {
      tourSteps.push({ element: '#iosNavGuest', popover: { title: 'Mobile Floating Bar', description: 'Kalau kamu pakai HP, navigasi pintar ini bakal nemenin kamu terus di bawah layar.', side: "top", align: 'center' } });
    }

    // Tambahkan sisa step untuk menjelajah seluruh halaman (tanpa label "Phase")
    tourSteps.push(
      { element: '.hero-stats', popover: { title: 'Kepercayaan Pelanggan', description: 'Bergabunglah bersama ratusan pelanggan lain yang puas dengan MariMatcha. Kualitas terjamin!', side: "bottom", align: 'center' } },
      { element: '#storySection', popover: { title: 'Cerita MariMatcha', description: 'Kenali lebih dekat dedikasi dan perjalanan kami dalam menyajikan racikan matcha paling otentik.', side: "top", align: 'center' } },
      { element: '.btn-view-all', popover: { title: 'Eksplorasi Menu', description: 'Klik tombol ini untuk melihat seluruh katalog menu, varian rasa, dan produk best-seller kami.', side: "top", align: 'center' } },
      { element: '#cara-pesan', popover: { title: 'Mudahnya Memesan', description: 'Nggak perlu bingung! Ini adalah alur praktis dari proses pemilihan menu sampai pesanan tiba di rumahmu.', side: "top", align: 'center' } },
      { element: '#ulasan', popover: { title: 'Apa Kata Mereka?', description: 'Lihat rating dan review jujur dari para penikmat MariMatcha lainnya di sini.', side: "top", align: 'center' } },
      { element: '#btnTourHome', popover: { title: 'Ulangi Panduan', description: 'Kamu selalu bisa mengklik tombol ini kapan pun kamu ingin mengulang panduan interaktif ini. Selamat menjelajah!', side: "top", align: 'center' } }
    );

    const tourDriverHome = driver({
      showProgress: true,
      animate: true,
      nextBtnText: 'Lanjut',
      prevBtnText: 'Kembali',
      doneBtnText: 'Selesai',
      onHighlightStarted: (element) => {
        if (element && element.classList && element.classList.contains('navbar-macha')) {
            element.classList.remove('scrolled'); // Memaksa lebarin navbar
        }
      },
      steps: tourSteps
    });

    document.getElementById('btnTourHome').addEventListener('click', () => {
        tourDriverHome.drive();
    });
  </script>
  <!-- ══════════ IOS FLOATING BAR (GUEST) ══════════ -->
  <nav class="ios-navbar-guest" id="iosNavGuest">
    <a href="<?= base_url(); ?>" class="ios-nav-item <?= (current_url() == base_url()) ? 'active' : '' ?>">
      <i class="fa-solid fa-house"></i>
      <span>Home</span>
    </a>
    <a href="<?= base_url('shop'); ?>"
      class="ios-nav-item <?= (strpos(current_url(), 'shop') !== false && strpos(current_url(), 'cart') === false) ? 'active' : '' ?>">
      <i class="fa-solid fa-mug-hot"></i>
      <span>Menu</span>
    </a>
    <a href="#ulasan" class="ios-nav-item">
      <i class="fa-solid fa-star"></i>
      <span>Ulasan</span>
    </a>
    <a href="<?= base_url('shop/cart'); ?>"
      class="ios-nav-item <?= (strpos(current_url(), 'cart') !== false) ? 'active' : '' ?>" style="position: relative;">
      <i class="fa-solid fa-cart-shopping"></i>
      <span>Cart</span>
      <?php 
      $cart_mobile = $this->session->userdata('cart') ?? [];
      $cart_count_mobile = is_array($cart_mobile) ? count($cart_mobile) : 0;
      if ($cart_count_mobile > 0): 
      ?>
          <span style="position:absolute; top:-5px; right:12px; background:#e53e3e; color:#fff; font-size:0.65rem; font-weight:800; border-radius:50%; width:18px; height:18px; display:flex; align-items:center; justify-content:center; border:2px solid #fff;"><?= $cart_count_mobile ?></span>
      <?php endif; ?>
    </a>
    <?php if ($this->session->userdata('userid')): ?>
      <a href="<?= ($this->session->userdata('role') == 'admin') ? base_url('dashboard') : base_url('user'); ?>"
        class="ios-nav-item">
        <i class="fa-solid fa-user-circle"></i>
        <span>Akun</span>
      </a>
    <?php else: ?>
      <a href="<?= base_url('auth'); ?>" class="ios-nav-item">
        <i class="fa-solid fa-right-to-bracket"></i>
        <span>Masuk</span>
      </a>
    <?php endif; ?>
  </nav>

  <script>
    // Navigation bar functionality logic can go here.
    // Auto-hide feature has been disabled to keep it persistent.
  </script>
</body>

</html>