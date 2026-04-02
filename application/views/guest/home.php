<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MariMacha – Minuman Matcha Premium UMKM</title>
  <meta name="description"
    content="Minuman matcha segar berkualitas premium dari Tangerang. Pesan langsung secara online, pengiriman ke seluruh Indonesia.">

  <!-- Fonts & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Smooth Scroll (Lenis) -->
  <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>

  <style>
    :root {
      /* MariMacha Brand Palette */
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

    html, body {
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

    .preloader-logo {
      font-size: 3rem;
      font-weight: 900;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .preloader-bar-wrap {
      width: 200px;
      height: 2px;
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
      margin-top: 10px;
      font-weight: 700;
      font-size: 0.9rem;
      letter-spacing: 2px;
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
      font-size: 1.62rem;
      color: var(--green-dark) !important;
      letter-spacing: -0.6px;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-right: 2rem;
    }

    .nav-link {
      font-weight: 700;
      font-size: 0.95rem;
      color: var(--green-dark) !important;
      margin: 0 6px;
      transition: 0.25s ease;
      position: relative;
      padding-bottom: 4px !important;
      border-radius: 0;
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

    /* ─── IOS FLOATING BAR (GUEST) ─── */
    .ios-navbar-guest {
        display: none;
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 8px 20px;
        border-radius: 40px;
        z-index: 10000;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.3);
        width: 90%;
        max-width: 360px;
        justify-content: space-around;
        align-items: center;
    }
    .ios-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: var(--green-light);
        text-decoration: none;
        font-size: 0.65rem;
        font-weight: 700;
        gap: 2px;
    }
    .ios-nav-item i { font-size: 1.3rem; }
    .ios-nav-item.active { color: var(--green-main); }
    
    @media (max-width: 768px) {
        .navbar-macha .navbar-nav, .navbar-macha .navbar-toggler { display: none !important; }
        .ios-navbar-guest { display: flex; }
        .navbar-macha { padding: 10px 0; }
        .navbar-brand { font-size: 1.4rem; }
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

    @keyframes shimmer {
      0% {
        transform: translateX(-150%) rotate(45deg);
      }

      100% {
        transform: translateX(150%) rotate(45deg);
      }
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
      background: #f0f3f1;
      color: var(--green-dark);
      border: none;
      border-radius: 50px;
      padding: 14px 24px;
      font-weight: 700;
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
    }

    .btn-add-cart.sold-out {
      background: #F0F2F5;
      color: #A0AEC0;
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
      padding: 20px;
      padding-top: 40px;
      border-radius: 24px;
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      z-index: 2;
    }

    .id-map-organic-svg {
      width: 100%;
      height: auto;
      display: block;
      filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.4));
    }

    .map-curve,
    .map-curve-dot {
      fill: transparent;
      stroke: var(--green-light);
      stroke-width: 1.5;
      stroke-linejoin: round;
      stroke-linecap: round;
    }

    .map-curve-dot {
      fill: var(--green-light);
      stroke: none;
    }

    .map-connection {
      fill: transparent;
      stroke: rgba(255, 255, 255, 0.4);
      stroke-width: 1.5;
      stroke-dasharray: 6 6;
      stroke-linecap: round;
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
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.8), 0 0 0 4px var(--tertiary);
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
      background: rgba(255, 255, 255, 0.95);
      padding: 12px 20px;
      border-radius: 12px;
      box-shadow: var(--shadow-lg);
      transform: translate(-50%, -130%);
      pointer-events: none;
      z-index: 20;
      text-align: center;
      min-width: 150px;
      white-space: nowrap;
    }

    .location-card::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 50%;
      transform: translateX(-50%) rotate(45deg);
      width: 10px;
      height: 10px;
      background: rgba(255, 255, 255, 0.95);
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
      scrollbar-width: none; /* Firefox */
      -ms-overflow-style: none; /* IE/Edge */
    }

    .testi-slider::-webkit-scrollbar {
      display: none; /* Chrome/Safari */
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
      border: 1px solid rgba(0,0,0,0.05);
    }

    .testi-btn:hover {
      background: var(--green-main);
      color: #fff;
      transform: scale(1.1);
    }

    @media (max-width: 991px) {
      .testi-item { flex: 0 0 calc(50% - 15px); }
    }

    @media (max-width: 767px) {
      .testi-item { flex: 0 0 100%; }
      .testi-slider { padding: 40px 0; }
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
      padding: 40px;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-lg);
      border: 1px solid rgba(0,0,0,0.05);
    }
    .review-form-card .form-control {
      border-radius: 12px;
      border: 2px solid #f0f4f0;
      font-family: 'Outfit', sans-serif;
      padding: 12px 16px;
    }
    .review-form-card .form-control:focus {
      border-color: var(--green-main);
      box-shadow: 0 0 0 4px rgba(27, 59, 37, 0.05);
    }
    .star-rating-input label {
      cursor: pointer;
      font-size: 1.2rem;
      filter: grayscale(1);
      transition: 0.2s;
    }
    .star-rating-input input:checked + label {
      filter: grayscale(0);
      transform: scale(1.2);
    }
    .star-rating-input input { display: none; }

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
    .hero-img-wrap img, .prod-card-inner, .step-card, .testi-card, .feature-card, .f-leaf, .story-bg-text-wrapper, .story-track {
      will-change: transform, opacity;
    }

    /* CTA Popping Enhancements */
    .btn-hero-primary { box-shadow: 0 12px 28px rgba(37, 211, 102, 0.2); }
    .btn-hero-primary:hover { box-shadow: 0 16px 36px rgba(37, 211, 102, 0.4); }
    .btn-hero-wa { box-shadow: 0 12px 28px rgba(0, 0, 0, 0.05); border-color: #25d366; }

    @media (max-width: 768px) {
      /* Disable heavy animations & effects */
      .f-leaf, .marker-pulse, .hero-decorative { display: none !important; }
      .glass-content-wrap, .premium-map-container { 
        backdrop-filter: none !important; 
      }
      .navbar-macha { background: rgba(255, 255, 255, 0.99) !important; backdrop-filter: none !important; }
      .glass-content-wrap { background: rgba(16, 36, 22, 0.95) !important; border-radius: 20px; }
      
      /* Make Floating Cart easier to tap on mobile */
      .floating-cart {
        width: auto !important;
        padding: 0 24px;
        height: 56px;
        border-radius: 28px;
        font-size: 1.1rem;
        gap: 12px;
        bottom: 20px;
        right: 20px;
        box-shadow: 0 10px 25px rgba(16, 36, 22, 0.5);
      }
      .floating-cart::after {
        content: 'Lihat Keranjang';
        font-weight: 800;
        font-size: 0.95rem;
      }
    }
  </style>
</head>

<body>

  <!-- ══════════ PRELOADER ══════════ -->
  <div class="m-preloader" id="preloader">
    <div class="preloader-logo">
      <i class="fa-solid fa-leaf" id="preloaderLeaf"></i>
      <span id="preloaderText">MariMacha</span>
    </div>
    <div class="preloader-bar-wrap">
      <div class="preloader-bar" id="preloaderBar"></div>
    </div>
    <div class="preloader-num" id="preloaderNum">0%</div>
  </div>


  <!-- ══════════ NAVBAR ══════════ -->
  <nav class="navbar navbar-expand-lg navbar-macha fixed-top" id="mainNav">
    <div class="container position-relative">
      <a class="navbar-brand" href="<?= base_url(); ?>">
        <i class="fa-solid fa-leaf me-2" style="color:var(--green-main)"></i>MariMacha
      </a>
      <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
        aria-controls="navMain" aria-expanded="false">
        <i class="fa-solid fa-bars-staggered" style="color:var(--green-dark);font-size:1.4rem"></i>
      </button>
      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav mx-auto gap-2">
          <li class="nav-item"><a class="nav-link active-link" href="<?= base_url(); ?>">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('shop'); ?>">Katalog</a></li>
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="#cara-pesan">Cara Pesan</a></li>
        </ul>
        <div class="d-flex align-items-center gap-3 flex-wrap mt-3 mt-lg-0">
          <?php
          $cart = $this->session->userdata('cart') ?? [];
          $cart_count = count($cart);
          ?>
          <a href="<?= base_url('shop/cart') ?>" class="btn-hdr-out position-relative">
            <i class="fa-solid fa-cart-shopping"></i>
            Keranjang
            <?php if ($cart_count > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="font-size:0.6rem"><?= $cart_count ?></span>
            <?php endif; ?>
          </a>
          <?php if ($this->session->userdata('userid')): ?>
            <a href="<?= ($this->session->userdata('role') == 'admin') ? base_url('dashboard') : base_url('user'); ?>"
              class="btn-hdr">
              <i class="fa-solid fa-user"></i> Akun Saya
            </a>
          <?php else: ?>
            <div class="d-flex gap-2">
              <a href="<?= base_url('auth') ?>" class="btn-hdr-out">Masuk</a>
              <a href="<?= base_url('auth/register') ?>" class="btn-hdr">Daftar</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- ══════════ TOAST ══════════ -->
  <?php if ($this->session->flashdata('success')): ?>
    <div class="toast-wrap" id="toastWrap">
      <div class="toast-custom">
        <div class="toast-icon"><i class="fa-solid fa-check"></i></div>
        <div class="toast-msg"><?= $this->session->flashdata('success') ?></div>
        <button class="toast-close" onclick="this.parentElement.remove()">✕</button>
      </div>
    </div>
  <?php endif; ?>

  <!-- ══════════ HERO ══════════ -->
  <section class="hero">
    <div class="hero-decorative d1"></div>
    <div class="hero-decorative d2"></div>
    <div class="container position-relative" style="z-index:1">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6 hero-text-col">
          <div class="hero-tag">
            <i class="fa-solid fa-location-dot"></i> UMKM Tangerang · Banten
          </div>
          <h1>Nikmati Segar <br>Minuman <span class="highlight">Matcha</span> <br>Terbaik Kami</h1>
          <p class="hero-desc">Dibuat dari teh hijau grade premium, disajikan dingin maupun panas. Cocok untuk harimu
            yang penuh semangat dan rasa!</p>

          <div class="hero-cta">
            <a href="<?= base_url('shop') ?>" class="btn-hero-primary">
              <i class="fa-solid fa-bag-shopping"></i> Pesan Sekarang
            </a>
            <a href="https://wa.me/<?= $this->config->item('admin_wa') ?>?text=Halo+MariMacha,+saya+ingin+tanya+produk"
              target="_blank" rel="noopener noreferrer" class="btn-hero-wa">
              <i class="fa-brands fa-whatsapp" style="font-size:1.2rem"></i> Tanya via WA
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
              <span class="stat-num">4.9<span style="color:var(--accent); font-size:1.5rem">★</span></span>
              <span class="stat-label">Rating Kami</span>
            </div>
          </div>
        </div>
        <div class="col-lg-6 hero-img-col">
          <div class="hero-img-wrap">
            <div class="hero-img-bg"></div>
            <img src="<?= base_url('assets/img/KONTEN02.jpeg'); ?>" alt="Matcha Segar MariMacha" loading="eager">
            <div class="hero-badge-float b1">
              <div class="float-icon"><i class="fa-solid fa-star"></i></div>
              <div>
                <div class="float-label">Kualitas Terjamin</div>
                <div class="float-val">100% Premium</div>
              </div>
            </div>
            <div class="hero-badge-float b2">
              <div class="float-icon"><i class="fa-solid fa-truck-fast"></i></div>
              <div>
                <div class="float-label">Pengiriman Aman</div>
                <div class="float-val">Ke Seluruh Indonesia</div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
            <div class="row align-items-center">
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
            <div class="row align-items-center">
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
              <a href="https://wa.me/<?= $this->config->item('admin_wa') ?>?text=Halo+MariMacha,+saya+ingin+tanya+produk"
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
                <div class="prod-img-wrap">
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
                    <a href="<?= base_url('shop/add_to_cart/' . $prod['id']) ?>" class="btn-add-cart shimmer-btn">
                      <i class="fa-solid fa-cart-shopping me-1"></i> Tambah Keranjang
                    </a>
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
        <h2 class="section-h2">Cara Pesan di MariMacha</h2>
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
              <img src="<?= base_url('uploads/' . $shop_logo) ?>" alt="MariMacha Store"
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
          <h2 class="section-h2">Kenapa Pilih <br>MariMacha?</h2>
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
  <section class="testi-section" id="testi-kami">
    <div class="container">
      <div class="text-center mb-5 reveal-up invisible-init">
        <div class="section-label"><i class="fa-solid fa-star"></i> Ulasan Pelanggan</div>
        <h2 class="section-h2">Kata Mereka Tentang Kami</h2>
        <p class="section-sub mx-auto">Lebih dari ratusan pelanggan puas setiap bulannya. Ini yang mereka katakan.</p>
      </div>
      <div class="testi-slider-container reveal-up invisible-init">
        <div class="testi-slider" id="testiSlider">
          <?php if(!empty($testimonials)): foreach ($testimonials as $t): ?>
            <div class="testi-item">
              <div class="testi-card">
                <div class="testi-stars"><?= str_repeat('<i class="fa-solid fa-star"></i>', $t['stars']) ?></div>
                <p class="testi-quote" style="min-height: 100px;">"<?= htmlspecialchars($t['quote']) ?>"</p>
                <div class="testi-user mt-4">
                  <div class="testi-avatar" style="background-color: var(--tertiary-light); color: var(--green-dark); font-weight: bold;">
                    <?= strtoupper(substr($t['name'] ?? 'M', 0, 1)) ?>
                  </div>
                  <div>
                    <div class="testi-name"><?= htmlspecialchars($t['name'] ?? 'Pelanggan') ?></div>
                    <div class="testi-loc" style="font-size: 0.8rem;"><i class="fa-solid fa-location-dot me-1"></i><?= htmlspecialchars($t['location'] ?? 'Indonesia') ?></div>
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
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="name" class="form-control" id="revName" placeholder="Nama Lengkap" 
                      value="<?= htmlspecialchars($my_review['name'] ?? $this->session->userdata('fullname') ?? '') ?>" required>
                    <label for="revName">Nama Lengkap</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="location" class="form-control" id="revLoc" placeholder="Lokasi (Contoh: Bekasi)"
                      value="<?= htmlspecialchars($my_review['location'] ?? '') ?>">
                    <label for="revLoc">Lokasi</label>
                  </div>
                </div>
                <div class="col-12">
                   <div class="star-rating-input d-flex justify-content-center gap-3 mb-3">
                      <?php $currStars = $my_review['stars'] ?? 5; ?>
                      <input type="radio" name="stars" value="5" id="s5" <?= ($currStars == 5) ? 'checked' : '' ?>><label for="s5">⭐⭐⭐⭐⭐</label>
                      <input type="radio" name="stars" value="4" id="s4" <?= ($currStars == 4) ? 'checked' : '' ?>><label for="s4">⭐⭐⭐⭐</label>
                      <input type="radio" name="stars" value="3" id="s3" <?= ($currStars == 3) ? 'checked' : '' ?>><label for="s3">⭐⭐⭐</label>
                   </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea name="quote" class="form-control" id="revQuote" placeholder="Ceritakan pengalamanmu..." style="height: 120px" required><?= htmlspecialchars($my_review['quote'] ?? '') ?></textarea>
                    <label for="revQuote">Ulasan / Pesan Kamu</label>
                  </div>
                </div>
                <div class="col-12 text-center mt-4">
                  <button type="submit" class="btn-hero-primary" style="padding: 14px 40px; border-radius: 50px; font-size: 1rem;">
                    <?= !empty($my_review) ? 'Update Ulasan' : 'Kirim Ulasan' ?> <i class="fa-solid fa-paper-plane ms-2"></i>
                  </button>
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
        <a href="https://wa.me/<?= $this->config->item('admin_wa') ?>?text=Halo+MariMacha,+saya+mau+tanya+pesanan"
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
          Tangerang, kami memastikan setiap produk MariMacha sampai di tangan Anda dalam kondisi segar dan sempurna.</p>
      </div>

      <div class="premium-map-container">
        <!-- Elegant Minimalist Map of Indonesia SVG -->
        <svg class="id-map-organic-svg" viewBox="0 0 1000 400" xmlns="http://www.w3.org/2000/svg"
          preserveAspectRatio="xMidYMid meet">
          <!-- Flowing elegant paths instead of rigid polygons -->
          <path class="map-curve" d="M120,80 Q180,120 220,180 Q180,240 100,200 Q80,140 120,80 Z" />
          <!-- Sumatra (organic) -->
          <path class="map-curve" d="M230,280 Q350,320 500,340 Q580,350 450,360 Q300,340 230,280 Z" />
          <!-- Jawa (organic) -->
          <path class="map-curve" d="M380,80 Q450,50 500,120 Q550,220 450,240 Q350,220 380,80 Z" />
          <!-- Kalimantan (organic) -->
          <path class="map-curve" d="M580,100 Q630,80 650,150 Q600,200 560,240 Q520,200 560,150 Z" />
          <!-- Sulawesi (organic) -->
          <path class="map-curve" d="M780,150 Q900,160 960,240 Q900,320 820,300 Q760,240 780,150 Z" />
          <!-- Papua (organic) -->

          <!-- Smaller Islands as elegant curves -->
          <circle cx="500" cy="360" r="4" class="map-curve-dot" />
          <circle cx="530" cy="365" r="5" class="map-curve-dot" />
          <circle cx="560" cy="368" r="4" class="map-curve-dot" />
          <circle cx="600" cy="370" r="6" class="map-curve-dot" />
          <path class="map-curve" d="M650,370 Q700,380 750,360 Q700,365 650,370 Z" /> <!-- Maluku / Nusa Tenggara -->

          <!-- Connection Lines radiating from Tangerang -->
          <path class="map-connection c1" d="M260,290 Q180,220 150,150" /> <!-- To Sumatra -->
          <path class="map-connection c2" d="M260,290 Q350,200 420,160" /> <!-- To Kalimantan -->
          <path class="map-connection c3" d="M260,290 Q400,240 580,180" /> <!-- To Sulawesi -->
          <path class="map-connection c4" d="M260,290 Q500,310 820,240" /> <!-- To Papua -->
        </svg>

        <!-- Elegant Location Marker (Tangerang) -->
        <div class="premium-marker" style="top: 72%; left: 26%;">
          <div class="marker-pulse"></div>
          <div class="marker-core"></div>
        </div>

        <!-- Hover Location Card -->
        <div class="location-card" style="top: 55%; left: 23%;">
          <div class="loc-title">MariMacha</div>
          <div class="loc-desc"><i class="fa-solid fa-location-dot me-1"></i> Tangerang, Banten</div>
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
      opacity: 0.04;
      overflow: hidden;
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
      display: flex;
      width: 300%;
      /* For 3 horizontal panels */
      height: 100%;
      position: relative;
      z-index: 2;
    }

    .story-slide {
      width: 100vw;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 5%;
    }

    .glass-content-wrap {
      background: rgba(255, 255, 255, 0.03);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 40px;
      padding: 60px;
      box-shadow: 0 40px 100px rgba(0, 0, 0, 0.3);
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
      font-size: 4.5rem;
      font-weight: 900;
      color: #fff;
      margin-bottom: 24px;
      line-height: 1.1;
    }

    .story-h2.lg {
      font-size: 6rem;
      text-align: center;
    }

    .story-h2 .highlight {
      display: block;
      color: var(--green-light);
    }

    .story-p {
      color: rgba(255, 255, 255, 0.7);
      font-size: 1.25rem;
      line-height: 1.7;
      max-width: 500px;
      margin-bottom: 30px;
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
      transform: rotate(-3deg);
      box-shadow: 0 50px 80px rgba(0, 0, 0, 0.5);
    }

    .floating-img-frame.s2 img {
      transform: rotate(3deg);
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
            MariMacha
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
          <p class="footer-copy mb-0">© <?= date('Y') ?> <strong style="color:#fff">MariMacha Premium</strong> ·
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

    <!-- IOS FLOATING NAVBAR (GUEST) -->
    <nav class="ios-navbar-guest">
        <a href="<?= base_url() ?>" class="ios-nav-item active">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="<?= base_url('shop') ?>" class="ios-nav-item">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>Menu</span>
        </a>
        <a href="#cara-pesan" class="ios-nav-item">
            <i class="fa-solid fa-circle-question"></i>
            <span>Bantuan</span>
        </a>
        <a href="<?= base_url('shop/cart') ?>" class="ios-nav-item position-relative">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
            <?php if($cart_count > 0): ?>
                <span class="position-absolute translate-middle badge rounded-pill bg-danger" style="top: 5px; right: -5px; font-size: 0.6rem;">
                    <?= $cart_count ?>
                </span>
            <?php endif; ?>
        </a>
    </nav>

  <!-- ══════════ FLOATING CART ══════════ -->
  <?php if ($cart_count > 0): ?>
    <a href="<?= base_url('shop/cart') ?>" class="floating-cart" title="Lihat Keranjang (<?= $cart_count ?> item)">
      <i class="fa-solid fa-cart-shopping"></i>
      <span class="fc-badge"><?= $cart_count ?></span>
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
      // 1. LENIS SMOOTH SCROLL (REFINED)
      const lenis = new Lenis({
        duration: 1.4,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
        smoothTouch: false
      });

      function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
      }
      requestAnimationFrame(raf);

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

      // 3. CURSOR REFINED FOLLOW
      const cursor = document.getElementById('cursor');
      const follower = document.getElementById('follower');
      const followerText = follower.querySelector('.follower-text');

      window.addEventListener('mousemove', (e) => {
        gsap.to(cursor, { x: e.clientX, y: e.clientY, duration: 0.1 });
        gsap.to(follower, { x: e.clientX - 20, y: e.clientY - 20, duration: 0.4, ease: "power3.out" });
      });

      document.querySelectorAll('a, button, .perspective-card').forEach(el => {
        el.addEventListener('mouseenter', () => {
          follower.classList.add('active');
          if (el.classList.contains('perspective-card') || el.closest('.prod-card')) {
            follower.classList.add('view-more');
            if (followerText) followerText.style.transform = "translate(-50%, -50%) scale(1)";
          }
        });
        el.addEventListener('mouseleave', () => {
          follower.classList.remove('active');
          follower.classList.remove('view-more');
          if (followerText) followerText.style.transform = "translate(-50%, -50%) scale(0)";
        });
      });

      // 4. PRELOADER & HERO ENTRANCE (PRO)
      let progress = 0;
      const progressInterval = setInterval(() => {
        progress += Math.floor(Math.random() * 15) + 1;
        if (progress >= 100) {
          progress = 100;
          clearInterval(progressInterval);
          revealSite();
        }
        document.getElementById('preloaderNum').innerText = progress + "%";
        gsap.to('#preloaderBar', { width: progress + "%", duration: 0.2 });
      }, 60);

      function revealSite() {
        const tl = gsap.timeline();
        tl.to('#preloader', { yPercent: -100, duration: 1.2, ease: "expo.inOut", delay: 0.4 })
          .fromTo('.navbar-macha', { y: -80, opacity: 0 }, { y: 0, opacity: 1, duration: 1, ease: "expo.out" }, "-=0.6")
          .fromTo('footer', { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 1 }, "-=1");

        setTimeout(() => {
          document.getElementById('preloader').style.display = 'none';
          document.body.classList.add('site-ready');
          ScrollTrigger.refresh();
        }, 2200);
      }

      // 5. SCROLL PROGRESS & RESPONSIVE MENU
      // Testimonial Slider Navigation
      function slideTesti(dir) {
        const slider = document.getElementById('testiSlider');
        const scrollAmount = slider.offsetWidth > 768 ? 400 : slider.offsetWidth;
        if (dir === 'left') {
          slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
          slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
      }

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
            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse) || new bootstrap.Collapse(navbarCollapse, {toggle: false});
            bsCollapse.hide();
          }
        });
      });

      // 6. SCROLL TRIGGER ANIMATIONS & UTILS
      gsap.registerPlugin(ScrollTrigger);

      const commonTrigger = (el) => ({ trigger: el, start: "top 85%", toggleActions: "play none none reverse" });

      // Horizontal Story Track Refined
      const storyTrack = document.querySelector('.story-track');
      if (storyTrack) {
        gsap.to(storyTrack, {
          xPercent: -66.66,
          ease: "none",
          scrollTrigger: {
            trigger: "#storySection",
            pin: true,
            scrub: 1.2,
            start: "top top",
            end: () => "+=" + (window.innerWidth > 768 ? storyTrack.offsetWidth : storyTrack.offsetWidth * 2),
            invalidateOnRefresh: true
          }
        });

        // Parallax background text
        gsap.to(".story-bg-text", {
          x: '15%',
          scrollTrigger: { trigger: "#storySection", start: "top bottom", end: "bottom top", scrub: 1 }
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

      ScrollTrigger.refresh();
    });
  </script>
  <!-- ══════════ IOS FLOATING BAR (GUEST) ══════════ -->
  <nav class="ios-navbar-guest" id="iosNavGuest">
    <a href="<?= base_url(); ?>" class="ios-nav-item <?= (current_url() == base_url()) ? 'active' : '' ?>">
      <i class="fa-solid fa-house"></i>
      <span>Home</span>
    </a>
    <a href="<?= base_url('shop'); ?>" class="ios-nav-item <?= (strpos(current_url(), 'shop') !== false && strpos(current_url(), 'cart') === false) ? 'active' : '' ?>">
      <i class="fa-solid fa-mug-hot"></i>
      <span>Menu</span>
    </a>
    <a href="<?= base_url('shop/cart'); ?>" class="ios-nav-item <?= (strpos(current_url(), 'cart') !== false) ? 'active' : '' ?>">
      <i class="fa-solid fa-cart-shopping"></i>
      <span>Cart</span>
    </a>
    <?php if ($this->session->userdata('userid')): ?>
      <a href="<?= ($this->session->userdata('role') == 'admin') ? base_url('dashboard') : base_url('user'); ?>" class="ios-nav-item">
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
    // Auto-hide Guest Pill Bar on Scroll
    let lastScrollYGuest = window.scrollY;
    window.addEventListener('scroll', () => {
        const iosNav = document.getElementById('iosNavGuest');
        if(!iosNav) return;

        if (window.scrollY > lastScrollYGuest && window.scrollY > 100) {
            gsap.to(iosNav, { y: 100, opacity: 0, duration: 0.3 });
        } else {
            gsap.to(iosNav, { y: 0, opacity: 1, duration: 0.3 });
        }
        lastScrollYGuest = window.scrollY;
    });
  </script>
</body>

</html>