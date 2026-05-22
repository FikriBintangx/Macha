# 🍃 Macha UMKM - UI/UX Design System Documentation

Welcome to the UI/UX design system guide for **Macha UMKM**. This document maps out the comprehensive visual and interactive architecture of the platform, outlining color tokens, typography, layout systems, component guides, responsive design paradigms, and premium micro-interactions.

---

## 🧭 1. Design Principles

1. **Fast Operational Access**
   Semua aksi utama maksimal 2 tap/click. Kecepatan adalah prioritas untuk operasional UMKM.
2. **Calm Visual Hierarchy**
   Interface tidak boleh terasa ramai meski data padat. Penggunaan whitespace dan warna solid sangat diperhatikan.
3. **Mobile-first Productivity**
   Semua fitur utama harus nyaman dioperasikan dengan satu tangan (mobile bottom navigation).
4. **Emotional Warmth**
   Visual harus terasa human dan tidak terlalu corporate, memberikan kesan organik yang relevan dengan produk teh.

---

## 🎨 2. Core Visual Concept & Theme

The Macha system is built upon a **"Cozy & Premium Organic"** design philosophy. Drawing inspiration from modern Japanese aesthetic principles, it merges high-end organic tones with clean, minimalist interface elements to evoke a sense of quality, trust, and natural purity.

### Key Visual Pillars:
- **Natural Depth**: Background surfaces employ a highly subtle organic paper grain texture to avoid the typical clinical feel of digital platforms.
- **Selective Glassmorphism**: Elegant transparent surfaces with high blur values (`backdrop-filter`) are used sparingly (auth, modals, popovers, floating panels). 
  > **⚠️ Glassmorphism Balance Rule**: Do not overuse blur. Dashboard utama didominasi oleh *solid surfaces* agar keterbacaan (*readability*) tetap tinggi dan performa mobile tidak drop. Glass hanya untuk *accent* dan overlay.
- **Warm & Soft Contrast**: Deep forest green accents contrast gracefully with a soft, easy-to-read warm cream workspace.

---

## 🎨 3. Color Palette & Token System

The color system is derived directly from the lifecycle of premium matcha tea leaves—starting from deep forest shadows to vibrant organic greens and warm harvested cream.

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                            BRAND COLOR PALETTE                              │
├───────────────────┬───────────────────┬───────────────────┬─────────────────┤
│    GREEN ULTRA    │    GREEN MAIN     │    LIGHT GREEN    │  MATCHA ACCENT  │
│      #102416      │      #1B3B25      │      #53725D      │     #8BAA7C     │
├───────────────────┼───────────────────┼───────────────────┼─────────────────┤
│   ORGANIC CREAM   │    SOFT CHERRY    │    WARM AMBER     │  PURE WHITE     │
│      #F5F5F0      │      #E63946      │      #FBBF24      │     #FFFFFF     │
└───────────────────┴───────────────────┴───────────────────┴─────────────────┘
```

### Color Variables Reference (`CSS Variables`):
```css
:root {
    /* Brand Greens */
    --green-ultra: #102416;   /* Deep charcoal-green shadow, login base */
    --green-dark: #102416;    /* Dark mode background base */
    --green-main: #1B3B25;    /* Primary forest green, brand headers, sidebar */
    --green-light: #53725D;   /* Organic sage, muted text, border lines */
    --tertiary: #8BAA7C;      /* Vibrant matcha leaf green, primary actions */
    
    /* Layout Warmth */
    --cream: #F5F5F0;          /* Premium warm cream canvas background */
    --white: #FFFFFF;          /* Pure card surface base */
    
    /* Semantic & Highlights */
    --accent: #FBBF24;         /* Rich organic gold/amber for high value items */
    --cherry-red: #E63946;     /* Crimson warning, dangerous actions, alerts */
    --success: #10B981;        /* Emerald green, positive stats, open hours */
}
```

---

## 📏 4. Spacing System

Konsistensi jarak sangat penting agar frontend developer dapat bekerja dengan panduan yang jelas.

### Spacing Scale:
```css
--space-micro: 4px;   /* Gap antar icon dan label */
--space-sm: 8px;      /* Padding item list */
--space-md: 16px;     /* Standard gap, padding card standard */
--space-lg: 24px;     /* Section spacing, margin antar elemen besar */
--space-xl: 32px;     /* Large layout gap, jarak antar container besar */
--space-hero: 48px;   /* Hero spacing, margin untuk area landing page */
```

---

## 🔲 5. Border Radius Rules

Radius digunakan untuk memberikan kesan bersahabat dan modern. Hindari radius yang tidak terdaftar dalam token.

### Radius Tokens:
```css
--radius-sm: 10px;  /* Inputs, small badges, tooltips */
--radius-md: 18px;  /* Standard cards, dropdowns, buttons */
--radius-lg: 28px;  /* Large hero cards, modals */
--radius-xl: 35px;  /* Auth container, floating dynamic island */
```

---

## 🔠 6. Typography Scale & Hierarchy

The system exclusively utilizes **Outfit** (from Google Fonts)—a highly modern, geometric sans-serif typeface dengan kurva mulus yang memadukan kesan terstruktur dan organik/ramah.

### Exact Token System:
```css
--text-xs: 0.75rem;   /* 12px - Meta text, small badges */
--text-sm: 0.875rem;  /* 14px - Secondary text, captions */
--text-md: 1rem;      /* 16px - Base body text */
--text-lg: 1.25rem;   /* 20px - Section headers, important values */
--text-xl: 2rem;      /* 32px - Page titles, auth headers */
--text-xxl: 3.5rem;   /* 56px - Hero display titles */
```

### Usage Application:
- **Display Titles (`auth-brand-lg`, `auth-title`)**
  - **Weight**: `900` or `950` | **Letter-spacing**: `-2px`
- **Dashboard Metric Values (`metric-value`)**
  - **Weight**: `800` | **Purpose**: High-scannability focal points.
- **Page Titles & Section Headers (`page-title`)**
  - **Weight**: `700` or `800` | **Purpose**: Clean, bold section headers.
- **Navigation Links & Form Labels (`nav-link`)**
  - **Weight**: `600` or `800` | **Letter-spacing**: `1.5px` (all-caps uppercase tracking).

---

## 🖥️ 7. Screen Layout & Architecture

Macha operates on a dual-layout structural system tailored perfectly for high-productivity desktops and quick-action mobile operations.

### A. Auth Layout (Desktop Split-Screen)
- **Visual Branding Panel (Left, Flex Ratio 1.2)**: Featuring a sliding grid of custom brand-silhouette animations and organic leaf particles.
- **Glassmorphic Form Panel (Right, Flex Ratio 1.0)**: Form items are housed inside a blur-heavy glass container.

### B. Core Application Dashboard Layout
- **Persistent Sidebar (Desktop, Fixed Width: `260px`)**:
  - Housed in a solid `--green-main` sidebar container.
  - Active states use a soft, elegant glow (refined to be more organic and less "flashy SaaS"):
    ```css
    .nav-link.active {
        background: rgba(255, 255, 255, 0.08); /* Soft flat warm highlight */
        border-left: 4px solid var(--tertiary); /* Subtle border accent */
        box-shadow: inset 2px 0 10px rgba(139, 170, 124, 0.1); /* Soft glow */
    }
    ```
- **Blurred Fluid Topbar**: Blurs behind elements as the user scrolls to establish layered hierarchy.
- **Mobile Bottom Navigation (iOS Style bottom-dock)**: When screen sizes fall below `768px`, the sidebar collapses off-screen, and an elegant fixed bottom tab bar slides up automatically.

---

## 📦 8. Component Inventory

Daftar komponen standar yang harus dibangun secara modular untuk *scalability*:
- **Button**: Primary, Outline, Floating Action, Text
- **Input**: Text Field, Textarea, Search Bar
- **Select / Dropdown**: Native select & custom dropdown menu
- **Modal**: Standard alert, Form modal
- **Card**: Metric Card, Product Card, Testimonial Card
- **Table**: Data Grid (Responsive mobile stacked)
- **Toast**: Success, Error, Info alerts
- **Navigation**: Sidebar (Desktop), Dynamic Island (Guest), Bottom Sheet (Mobile)
- **Tabs**: Segmented controls

---

## 💡 9. Feedback & Empty States

UMKM dashboard sering menghadapi kondisi tidak ada data atau koneksi lambat.

### Feedback States Rules:
- **Loading Skeleton**: Gunakan animasi *shimmering* dengan warna solid cerah (`--cream-2`) sebelum data termuat, jangan hanya bergantung pada spinner kecil.
- **Empty Product List**: Tampilkan ilustrasi/ikon organik yang ramah dengan CTA jelas (contoh: "Belum ada pesanan hari ini. Waktunya istirahat sejenak 🍵").
- **Failed/Error State**: Hindari bahasa error teknis. Gunakan bahasa kasual dengan tombol *Retry*.
- **Offline Detection**: Banner halus di bagian atas layar menginformasikan bahwa koneksi terputus.

---

## ♿ 10. Accessibility

Aksesibilitas adalah prioritas untuk platform profesional (B2B SaaS Level):
- **Minimum Contrast Ratio**: Pastikan rasio warna teks vs background minimal 4.5:1 (terutama untuk teks body).
- **Touch Targets**: Area klik minimal berukuran `48px` x `48px` untuk kemudahan operasional UMKM menggunakan jempol di mobile.
- **Keyboard Navigable**: Semua komponen interaktif harus mendukung tombol `Tab` dengan *focus ring* yang jelas.
- **Reduced Motion Support**: Animasi transisi harus dimatikan atau dikurangi secara otomatis jika `prefers-reduced-motion` aktif pada sistem OS pengguna.

---

## 🔄 11. Animations & Motion Design

We utilize **GSAP** (GreenSock Animation Platform) and subtle CSS keyframe sets to breathe life into the UI.

### Motion Principles
- **Duration**: Animation duration max `300ms` for general UI interactions (hover, toggle).
- **Large Transitions**: Only trigger large scaling/fading during initial load or auth onboarding.
- **Avoid Overload**: Avoid simultaneous motion overload; pastikan animasi hanya mengaksen elemen yang sedang berinteraksi.
- **Respect Settings**: Implement CSS `@media (prefers-reduced-motion: reduce)` rules for heavy elements.

### Key Interactive Components
- **Floating POS Action Button**: Smoothly expands from a clean `65px` circle to a `150px` rounded capsule with a cubic-bezier transition.
- **Organic Particle Float**: Leaves float smoothly using sinusoidal easing:
  ```javascript
  gsap.to(leaf, { y: "random(-50, 50)", ease: "sine.inOut" ... });
  ```

---

## 📱 12. Responsive Adaptability

The system features robust fluid scaling down to `320px` viewports:
- **Card-Stacking Mobile Tables**: Wide tabular sales databases collapse automatically into visually stacked vertical cards.
- **Touch-safe Targets**: Interactive options are mapped to mobile ergonomic zones (bottom screen).
