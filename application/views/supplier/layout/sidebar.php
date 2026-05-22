    <!-- Sidebar -->
    <aside class="w-64 glass flex-shrink-0 hidden md:flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-gray-700">
            <h1 class="text-2xl font-bold text-matcha-light neon-text">Supplier<span class="text-white">Panel</span></h1>
        </div>
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-2 px-4">
                <li>
                    <a href="<?= base_url('supplier/dashboard') ?>" class="flex items-center space-x-3 text-gray-300 p-3 rounded-lg hover:bg-gray-800 hover:text-matcha-light transition-colors <?= (isset($title) && $title == 'Supplier Dashboard') ? 'bg-gray-800 text-matcha-light border-l-4 border-matcha-light' : '' ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('supplier/products') ?>" class="flex items-center space-x-3 text-gray-300 p-3 rounded-lg hover:bg-gray-800 hover:text-matcha-light transition-colors <?= (isset($title) && strpos($title, 'Product') !== false) ? 'bg-gray-800 text-matcha-light border-l-4 border-matcha-light' : '' ?>">
                        <i class="fas fa-box"></i>
                        <span>My Products</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('supplier/requests') ?>" class="flex items-center space-x-3 text-gray-300 p-3 rounded-lg hover:bg-gray-800 hover:text-matcha-light transition-colors <?= (isset($title) && strpos($title, 'Request') !== false) ? 'bg-gray-800 text-matcha-light border-l-4 border-matcha-light' : '' ?>">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Requests</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('supplier/shipments') ?>" class="flex items-center space-x-3 text-gray-300 p-3 rounded-lg hover:bg-gray-800 hover:text-matcha-light transition-colors <?= (isset($title) && strpos($title, 'Shipment') !== false) ? 'bg-gray-800 text-matcha-light border-l-4 border-matcha-light' : '' ?>">
                        <i class="fas fa-truck"></i>
                        <span>Shipments</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('supplier/analytics') ?>" class="flex items-center space-x-3 text-gray-300 p-3 rounded-lg hover:bg-gray-800 hover:text-matcha-light transition-colors <?= (isset($title) && $title == 'Analytics') ? 'bg-gray-800 text-matcha-light border-l-4 border-matcha-light' : '' ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('supplier/profile') ?>" class="flex items-center space-x-3 text-gray-300 p-3 rounded-lg hover:bg-gray-800 hover:text-matcha-light transition-colors <?= (isset($title) && $title == 'Profile') ? 'bg-gray-800 text-matcha-light border-l-4 border-matcha-light' : '' ?>">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="<?= base_url('supplier/auth/logout') ?>" class="flex items-center space-x-3 text-gray-300 p-3 rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Top Navbar -->
        <header class="h-16 glass flex items-center justify-between px-6 z-10">
            <div class="md:hidden">
                <h1 class="text-xl font-bold text-matcha-light">Supplier</h1>
            </div>
            <div class="hidden md:block text-xl font-semibold"><?= isset($title) ? $title : 'Dashboard' ?></div>
            <div class="flex items-center space-x-4">
                <!-- Simple Notification -->
                <button class="text-gray-300 hover:text-white relative">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-0 right-0 -mt-1 -mr-1 px-1.5 py-0.5 text-xs bg-matcha DEFAULT text-white rounded-full">3</span>
                </button>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="text-sm font-medium"><?= $this->session->userdata('supplier_name') ?></span>
                </div>
            </div>
        </header>
        
        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-matcha-dark text-white p-4 rounded-lg mb-6 shadow-lg border-l-4 border-matcha-light">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-600 text-white p-4 rounded-lg mb-6 shadow-lg border-l-4 border-red-300">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>
