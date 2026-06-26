<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - Supplier Panel' : 'Supplier Panel' ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        if (localStorage.getItem('supplier-sidebar-collapsed') === 'true' && window.innerWidth >= 1024) {
            document.documentElement.classList.add('supplier-sidebar-collapsed-init');
        }
    </script>

    <style>
        :root {
            --green-ultra: #102416;
            --green-dark:  #102416;
            --green-main:  #1B3B25;
            --green-light: #53725D;
            --tertiary:    #8BAA7C;
            --cream:       #F5F5F0;
            --sidebar-w:   260px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--cream);
            background-image: url("https://www.transparenttextures.com/patterns/p6.png");
            color: #1a2e25;
            height: 100%;
            overflow: hidden;
        }

        body {
            display: flex;
        }

        /* Responsive Sidebar Collapsible Styles */
        @media (min-width: 1024px) {
            #supplierSidebar {
                transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), opacity 0.3s !important;
            }
            #supplierMainContent {
                transition: margin-left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), width 0.3s !important;
            }

            body.sidebar-collapsed #supplierSidebar,
            html.supplier-sidebar-collapsed-init body #supplierSidebar {
                transform: translateX(-340px) !important;
                opacity: 0;
                pointer-events: none;
            }
            body.sidebar-collapsed #supplierMainContent,
            html.supplier-sidebar-collapsed-init body #supplierMainContent {
                margin-left: 20px !important;
                width: calc(100% - 40px) !important;
            }
        }

        /* ── Custom Scrollbars ── */

        /* Hide sidebar nav scrollbar completely */
        #supplierSidebar nav {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        #supplierSidebar nav::-webkit-scrollbar {
            display: none;
        }

        /* Thin green scrollbar for main content */
        #supplierMainContent > div:last-child {
            scrollbar-width: thin;
            scrollbar-color: rgba(139,170,124,0.4) transparent;
        }
        #supplierMainContent > div:last-child::-webkit-scrollbar {
            width: 5px;
        }
        #supplierMainContent > div:last-child::-webkit-scrollbar-track {
            background: transparent;
        }
        #supplierMainContent > div:last-child::-webkit-scrollbar-thumb {
            background: rgba(139,170,124,0.45);
            border-radius: 99px;
        }
        #supplierMainContent > div:last-child::-webkit-scrollbar-thumb:hover {
            background: rgba(83,114,93,0.7);
        }
    </style>
</head>
<body>
