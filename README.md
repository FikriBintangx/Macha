# 🌿 MariMacha - Premium Matcha Experience

<div align="center">
  <img src="u-back/assets/img/productORI.png" width="600" alt="MariMacha Hero">
  <p align="center">
    <strong>Experience the ritual of peace in every sip.</strong>
  </p>
  <p align="center">
    <img src="https://img.shields.io/badge/CI-3.x-E34F26?style=flat-square&logo=codeigniter&logoColor=white" alt="CodeIgniter">
    <img src="https://img.shields.io/badge/Animation-GSAP-88CE02?style=flat-square&logo=greensock&logoColor=white" alt="GSAP">
    <img src="https://img.shields.io/badge/CSS-Premium-38B2AC?style=flat-square&logo=bootstrap&logoColor=white" alt="Bootstrap">
  </p>
</div>

---

## 🍵 About MariMacha

**MariMacha** is a high-end, cinematic e-commerce landing page specifically designed for premium Matcha products. It's not just a shop; it's a digital experience that guides the user through the journey of matcha—from its origin in high-altitude tea gardens to the slow-grinding process and finally into your cup.

## ✨ Premium Features

- **🚀 Cinematic Preloader**: An elegant full-screen loading sequence with progress bar.
- **📜 Horizontal Scroll-Telling**: A pinned horizontal section that tells the brand's story as you scroll.
- **🧲 Magnetic Button Interactions**: Modern UI effects that pull your cursor toward CTA buttons.
- **🍃 Floating Matcha Particles**: Subtle, physics-based leaf animations for a dynamic atmosphere.
- **🧊 3D Perspective Cards**: Interactive product cards that tilt and react to your mouse movement.
- **🌊 Liquid Background**: Smooth body background color transitions between sections.
- **✨ GSAP ScrollTrigger**: Highly optimized entrance reveals with staggered timing for a professional feel.

---

## 🛠️ Technology Stack

| Tech | Description |
| :--- | :--- |
| **CodeIgniter 3** | Robust PHP framework for the backend. |
| **GSAP 3** | Industry-standard animation platform. |
| **ScrollTrigger** | Advanced scroll-based animation engine. |
| **Lenis** | Ultra-smooth scrolling experience. |
| **Bootstrap 5** | Responsive layout foundation. |
| **FontAwesome** | Premium vector icons. |

---

## 🚀 Getting Started

Follow these steps to set up the project on your local machine:

### 1. Prerequisites
- **Web Server**: Laragon (Recommended), XAMPP, or MAMP.
- **PHP**: Version 7.2 or higher.
- **Database**: MySQL.

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/FikriBintangx/Macha.git

# Move to your server root (e.g., C:/laragon/www/macha)
```

### 3. Database Setup
1. Create a new database named `db_macha_umkm`.
2. Import the `db_macha_umkm.sql` file (found in the root directory).
3. Update your database configuration in:
   `application/config/database.php`

### 4. Configure Base URL
Open `application/config/config.php` and set the following:
```php
$config['base_url'] = 'http://localhost/macha/';
```

---

## 📁 Project Structure

```text
macha/
├── application/         # CodeIgniter Application files
├── assets/              # Premium images, CSS, and JS
├── db_macha_umkm.sql    # Database export
├── README.md            # You are here!
└── .gitignore           # Git ignore rules
```

---

<p align="center">
  Made with 💚 by MariMacha Developer
</p>