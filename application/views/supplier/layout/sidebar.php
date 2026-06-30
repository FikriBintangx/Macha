    <!-- Sidebar -->
    <aside id="supplierSidebar" style="
        width: 260px;
        background: #1B3B25;
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 20px;
        bottom: 20px;
        left: 20px;
        border-radius: 28px;
        z-index: 1000;
        box-shadow: 0 10px 30px rgba(16,36,22,0.15);
        transition: transform 0.3s cubic-bezier(0.25,0.8,0.25,1), opacity 0.3s;
        overflow: hidden;
    ">
        <!-- Brand -->
        <div style="padding: 22px 20px 18px; border-bottom: 1px solid rgba(255,255,255,0.08); display:flex; align-items:center; gap:12px;">
            <div style="width:42px; height:42px; background:#fff; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-leaf" style="color:#1B3B25; font-size:1.1rem;"></i>
            </div>
            <div>
                <div style="font-weight:800; font-size:1rem; color:#fff;">Supplier Panel</div>
                <div style="font-size:0.72rem; color:rgba(255,255,255,0.5);">Macha UMKM</div>
            </div>
        </div>

        <!-- Nav -->
        <nav style="flex:1; overflow-y:auto; padding:14px 12px; scrollbar-width:none;">
            <!-- Utama -->
            <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#8BAA7C; margin:16px 0 8px 10px; display:flex; align-items:center; gap:8px;">
                <span style="width:16px; height:1.5px; background:rgba(139,170,124,0.4); border-radius:2px; flex-shrink:0;"></span>
                Utama
                <span style="flex:1; height:1.5px; background:rgba(139,170,124,0.2); border-radius:2px;"></span>
            </div>
            <a href="<?= base_url('supplier/dashboard') ?>" style="
                display:flex; align-items:center; gap:12px;
                padding:11px 16px; border-radius:14px; margin-bottom:4px;
                text-decoration:none; font-size:0.88rem; font-weight:500;
                transition: all 0.2s;
                color: <?= (isset($title) && $title == 'Supplier Dashboard') ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>;
                background: <?= (isset($title) && $title == 'Supplier Dashboard') ? 'rgba(139,170,124,0.15)' : 'transparent' ?>;
            " onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#fff'; this.style.transform='translateX(4px)';"
               onmouseout="this.style.background='<?= (isset($title) && $title == 'Supplier Dashboard') ? 'rgba(139,170,124,0.15)' : 'transparent' ?>'; this.style.color='<?= (isset($title) && $title == 'Supplier Dashboard') ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>'; this.style.transform='translateX(0)';">
                <i class="fas fa-home" style="width:18px; text-align:center;"></i>
                Dashboard
            </a>

            <!-- Katalog -->
            <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#8BAA7C; margin:16px 0 8px 10px; display:flex; align-items:center; gap:8px;">
                <span style="width:16px; height:1.5px; background:rgba(139,170,124,0.4); border-radius:2px; flex-shrink:0;"></span>
                Katalog
                <span style="flex:1; height:1.5px; background:rgba(139,170,124,0.2); border-radius:2px;"></span>
            </div>
            <a href="<?= base_url('supplier/products') ?>" style="
                display:flex; align-items:center; gap:12px;
                padding:11px 16px; border-radius:14px; margin-bottom:4px;
                text-decoration:none; font-size:0.88rem; font-weight:500; transition:all 0.2s;
                color: <?= (isset($title) && strpos($title, 'Product') !== false) ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>;
                background: <?= (isset($title) && strpos($title, 'Product') !== false) ? 'rgba(139,170,124,0.15)' : 'transparent' ?>;
            " onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#fff'; this.style.transform='translateX(4px)';"
               onmouseout="this.style.background='<?= (isset($title) && strpos($title, 'Product') !== false) ? 'rgba(139,170,124,0.15)' : 'transparent' ?>'; this.style.color='<?= (isset($title) && strpos($title, 'Product') !== false) ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>'; this.style.transform='translateX(0)';">
                <i class="fas fa-box" style="width:18px; text-align:center;"></i>
                Produk Saya
            </a>

            <!-- Transaksi -->
            <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#8BAA7C; margin:16px 0 8px 10px; display:flex; align-items:center; gap:8px;">
                <span style="width:16px; height:1.5px; background:rgba(139,170,124,0.4); border-radius:2px; flex-shrink:0;"></span>
                Transaksi
                <span style="flex:1; height:1.5px; background:rgba(139,170,124,0.2); border-radius:2px;"></span>
            </div>
            <a href="<?= base_url('supplier/requests') ?>" style="
                display:flex; align-items:center; gap:12px;
                padding:11px 16px; border-radius:14px; margin-bottom:4px;
                text-decoration:none; font-size:0.88rem; font-weight:500; transition:all 0.2s;
                color: <?= (isset($title) && strpos($title, 'Request') !== false) ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>;
                background: <?= (isset($title) && strpos($title, 'Request') !== false) ? 'rgba(139,170,124,0.15)' : 'transparent' ?>;
            " onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#fff'; this.style.transform='translateX(4px)';"
               onmouseout="this.style.background='<?= (isset($title) && strpos($title, 'Request') !== false) ? 'rgba(139,170,124,0.15)' : 'transparent' ?>'; this.style.color='<?= (isset($title) && strpos($title, 'Request') !== false) ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>'; this.style.transform='translateX(0)';">
                <i class="fas fa-clipboard-list" style="width:18px; text-align:center;"></i>
                Permintaan
            </a>
            <a href="<?= base_url('supplier/shipments') ?>" style="
                display:flex; align-items:center; gap:12px;
                padding:11px 16px; border-radius:14px; margin-bottom:4px;
                text-decoration:none; font-size:0.88rem; font-weight:500; transition:all 0.2s;
                color: <?= (isset($title) && strpos($title, 'Shipment') !== false) ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>;
                background: <?= (isset($title) && strpos($title, 'Shipment') !== false) ? 'rgba(139,170,124,0.15)' : 'transparent' ?>;
            " onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#fff'; this.style.transform='translateX(4px)';"
               onmouseout="this.style.background='<?= (isset($title) && strpos($title, 'Shipment') !== false) ? 'rgba(139,170,124,0.15)' : 'transparent' ?>'; this.style.color='<?= (isset($title) && strpos($title, 'Shipment') !== false) ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>'; this.style.transform='translateX(0)';">
                <i class="fas fa-truck" style="width:18px; text-align:center;"></i>
                Pengiriman
            </a>

            <!-- Laporan -->
            <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#8BAA7C; margin:16px 0 8px 10px; display:flex; align-items:center; gap:8px;">
                <span style="width:16px; height:1.5px; background:rgba(139,170,124,0.4); border-radius:2px; flex-shrink:0;"></span>
                Laporan
                <span style="flex:1; height:1.5px; background:rgba(139,170,124,0.2); border-radius:2px;"></span>
            </div>
            <a href="<?= base_url('supplier/analytics') ?>" style="
                display:flex; align-items:center; gap:12px;
                padding:11px 16px; border-radius:14px; margin-bottom:4px;
                text-decoration:none; font-size:0.88rem; font-weight:500; transition:all 0.2s;
                color: <?= (isset($title) && $title == 'Analytics') ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>;
                background: <?= (isset($title) && $title == 'Analytics') ? 'rgba(139,170,124,0.15)' : 'transparent' ?>;
            " onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#fff'; this.style.transform='translateX(4px)';"
               onmouseout="this.style.background='<?= (isset($title) && $title == 'Analytics') ? 'rgba(139,170,124,0.15)' : 'transparent' ?>'; this.style.color='<?= (isset($title) && $title == 'Analytics') ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>'; this.style.transform='translateX(0)';">
                <i class="fas fa-chart-line" style="width:18px; text-align:center;"></i>
                Analitik
            </a>

            <!-- Pengaturan -->
            <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#8BAA7C; margin:16px 0 8px 10px; display:flex; align-items:center; gap:8px;">
                <span style="width:16px; height:1.5px; background:rgba(139,170,124,0.4); border-radius:2px; flex-shrink:0;"></span>
                Pengaturan
                <span style="flex:1; height:1.5px; background:rgba(139,170,124,0.2); border-radius:2px;"></span>
            </div>
            <a href="<?= base_url('supplier/profile') ?>" style="
                display:flex; align-items:center; gap:12px;
                padding:11px 16px; border-radius:14px; margin-bottom:4px;
                text-decoration:none; font-size:0.88rem; font-weight:500; transition:all 0.2s;
                color: <?= (isset($title) && $title == 'Profile') ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>;
                background: <?= (isset($title) && $title == 'Profile') ? 'rgba(139,170,124,0.15)' : 'transparent' ?>;
            " onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#fff'; this.style.transform='translateX(4px)';"
               onmouseout="this.style.background='<?= (isset($title) && $title == 'Profile') ? 'rgba(139,170,124,0.15)' : 'transparent' ?>'; this.style.color='<?= (isset($title) && $title == 'Profile') ? '#8BAA7C' : 'rgba(255,255,255,0.65)' ?>'; this.style.transform='translateX(0)';">
                <i class="fas fa-user" style="width:18px; text-align:center;"></i>
                Profil
            </a>
        </nav>

        <!-- Profile Card -->
        <div style="padding:14px 12px; border-top:1px solid rgba(255,255,255,0.08);">
            <div style="display:flex; align-items:center; gap:12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.07); border-radius:18px; padding:13px;">
                <div style="width:38px; height:38px; border-radius:50%; background:#8BAA7C; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:15px; color:#1B3B25; flex-shrink:0;">
                    <?= strtoupper(substr($this->session->userdata('supplier_name') ?? 'S', 0, 1)) ?>
                </div>
                <div style="flex:1; overflow:hidden;">
                    <div style="font-weight:600; font-size:13px; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <?= htmlspecialchars($this->session->userdata('supplier_name') ?? 'Supplier') ?>
                    </div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.5);">Supplier Partner</div>
                </div>
            </div>
            <a href="<?= base_url('supplier/auth/logout') ?>" style="
                display:flex; align-items:center; justify-content:center; gap:8px;
                margin-top:10px; padding:10px; border-radius:14px;
                text-decoration:none; font-size:0.85rem; font-weight:600;
                color:rgba(255,255,255,0.55); border:1px solid rgba(255,255,255,0.1);
                transition:all 0.2s;
            " onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#fff';"
               onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.55)';">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="supplierOverlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); backdrop-filter:blur(4px); z-index:999;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('supplierSidebar');
            const toggleBtn = document.getElementById('supplierToggle');
            const overlay = document.getElementById('supplierOverlay');

            if (toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        sidebar.style.transform = 'translateX(0)';
                        overlay.style.display = 'block';
                    } else {
                        document.documentElement.classList.remove('supplier-sidebar-collapsed-init');
                        document.body.classList.toggle('sidebar-collapsed');
                        localStorage.setItem('supplier-sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
                    }
                });
                overlay.addEventListener('click', () => {
                    sidebar.style.transform = 'translateX(-340px)';
                    overlay.style.display = 'none';
                });
            }
        });
    </script>

    <!-- Main Content -->
    <main id="supplierMainContent" style="
        flex: 1;
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
        margin-left: 300px;
        transition: margin-left 0.3s cubic-bezier(0.25,0.8,0.25,1), width 0.3s;
    ">
        <!-- Topbar -->
        <header style="
            height: 68px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(233,237,233,0.5);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            flex-shrink: 0;
            margin: 20px 20px 0 0;
            border-radius: 18px 18px 0 0;
        ">
            <div style="display:flex; align-items:center; gap:12px;">
                <button id="supplierToggle" style="
                    width:42px; height:42px; border-radius:12px;
                    border:1px solid #e5ebe5; background:#fff;
                    display:flex; align-items:center; justify-content:center;
                    color:#1a2e25; cursor:pointer; transition:all 0.2s;
                    box-shadow:0 2px 8px rgba(0,0,0,0.03);
                " onmouseover="this.style.background='#e8f4ee'; this.style.color='#1B3B25';" onmouseout="this.style.background='#fff'; this.style.color='#1a2e25';">
                    <i class="fas fa-bars"></i>
                </button>
                <span style="font-weight:800; font-size:1.15rem; color:#1a2e25; letter-spacing:-0.3px;" class="d-none d-lg-block">
                    <?= isset($title) ? $title : 'Dashboard' ?>
                </span>
            </div>
            <div style="display:flex; align-items:center; gap:12px;">
                <!-- Bell -->
                <button style="
                    width:42px; height:42px; border-radius:12px;
                    border:1px solid #e5ebe5; background:#fff;
                    display:flex; align-items:center; justify-content:center;
                    color:#1a2e25; cursor:pointer; position:relative;
                    transition:all 0.2s; box-shadow:0 2px 8px rgba(0,0,0,0.03);
                " onmouseover="this.style.background='#e8f4ee';" onmouseout="this.style.background='#fff';">
                    <i class="fas fa-bell"></i>
                    <span style="position:absolute; top:7px; right:7px; width:8px; height:8px; background:#e63946; border-radius:50%; border:2px solid #fff;"></span>
                </button>
                <!-- User info -->
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="text-align:right;" class="d-none d-md-block">
                        <div style="font-weight:700; font-size:0.88rem; color:#1a2e25;"><?= htmlspecialchars($this->session->userdata('supplier_name') ?? 'Supplier') ?></div>
                        <div style="font-size:0.73rem; color:#8aa898;">Supplier</div>
                    </div>
                    <div style="
                        width:38px; height:38px; border-radius:50%;
                        background:linear-gradient(135deg, #1B3B25, #53725D);
                        display:flex; align-items:center; justify-content:center;
                        color:#fff; font-weight:700; font-size:0.9rem;
                        box-shadow:0 4px 10px rgba(0,0,0,0.1);
                    ">
                        <?= strtoupper(substr($this->session->userdata('supplier_name') ?? 'S', 0, 1)) ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div style="flex:1; overflow-y:auto; padding:24px 24px 24px 0; margin-right:20px;">
            <?php if ($this->session->flashdata('success')): ?>
                <div style="background:rgba(139,170,124,0.15); color:#1B3B25; border:1px solid rgba(139,170,124,0.3); padding:1rem 1.25rem; border-radius:14px; margin-bottom:1.25rem; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-circle-check" style="color:#8BAA7C;"></i>
                    <span style="font-size:0.875rem; font-weight:500;"><?= $this->session->flashdata('success') ?></span>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div style="background:rgba(220,38,38,0.08); color:#991b1b; border:1px solid rgba(220,38,38,0.2); padding:1rem 1.25rem; border-radius:14px; margin-bottom:1.25rem; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-circle-xmark" style="color:#dc2626;"></i>
                    <span style="font-size:0.875rem; font-weight:500;"><?= $this->session->flashdata('error') ?></span>
                </div>
            <?php endif; ?>

