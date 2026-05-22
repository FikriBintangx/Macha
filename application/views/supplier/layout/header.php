<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - Supplier Panel' : 'Supplier Panel' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            100: '#1e293b',
                            200: '#111827',
                            300: '#0f172a',
                        },
                        matcha: {
                            light: '#98FF98',
                            DEFAULT: '#22c55e',
                            dark: '#16a34a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0f172a; color: white; }
        .glass {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .neon-text {
            text-shadow: 0 0 5px rgba(152, 255, 152, 0.5);
        }
        .neon-border {
            box-shadow: 0 0 10px rgba(152, 255, 152, 0.2);
        }
    </style>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex h-screen overflow-hidden">
