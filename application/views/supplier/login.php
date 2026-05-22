<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Login</title>
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
        .neon-border {
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.3);
            border: 1px solid rgba(34, 197, 94, 0.5);
        }
        .neon-text {
            text-shadow: 0 0 10px rgba(152, 255, 152, 0.5);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-matcha-dark blur-[120px] opacity-20"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-matcha-light blur-[120px] opacity-10"></div>
    </div>

    <div class="glass neon-border rounded-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white neon-text mb-2">Supplier<span class="text-matcha-light">Portal</span></h1>
            <p class="text-gray-400">Sign in to manage your supply</p>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded mb-4">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="bg-matcha-dark/20 border border-matcha-dark text-matcha-light px-4 py-3 rounded mb-4">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('supplier/auth/login') ?>" method="post">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                <input type="email" id="email" name="email" required class="w-full px-4 py-2 bg-dark-200 border border-gray-600 rounded-lg focus:outline-none focus:border-matcha-light text-white" placeholder="admin@supplier.com">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 bg-dark-200 border border-gray-600 rounded-lg focus:outline-none focus:border-matcha-light text-white" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full bg-matcha hover:bg-matcha-dark text-white font-bold py-2 px-4 rounded-lg transition-colors">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
