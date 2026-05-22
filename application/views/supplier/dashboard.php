<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Products -->
    <div class="glass rounded-xl p-6 border border-gray-700 hover:border-matcha-light transition-colors relative overflow-hidden group">
        <div class="absolute right-0 top-0 mt-4 mr-4 text-matcha-light opacity-50 group-hover:opacity-100 transition-opacity">
            <i class="fas fa-box fa-2x"></i>
        </div>
        <h3 class="text-gray-400 text-sm font-medium mb-1">Total Products</h3>
        <p class="text-3xl font-bold text-white"><?= $stats['total_products'] ?></p>
    </div>

    <!-- Pending Requests -->
    <div class="glass rounded-xl p-6 border border-gray-700 hover:border-yellow-400 transition-colors relative overflow-hidden group">
        <div class="absolute right-0 top-0 mt-4 mr-4 text-yellow-400 opacity-50 group-hover:opacity-100 transition-opacity">
            <i class="fas fa-clock fa-2x"></i>
        </div>
        <h3 class="text-gray-400 text-sm font-medium mb-1">Pending Requests</h3>
        <p class="text-3xl font-bold text-white"><?= $stats['pending_requests'] ?></p>
    </div>

    <!-- Approved Requests -->
    <div class="glass rounded-xl p-6 border border-gray-700 hover:border-matcha-light transition-colors relative overflow-hidden group">
        <div class="absolute right-0 top-0 mt-4 mr-4 text-matcha-light opacity-50 group-hover:opacity-100 transition-opacity">
            <i class="fas fa-check-circle fa-2x"></i>
        </div>
        <h3 class="text-gray-400 text-sm font-medium mb-1">Approved Requests</h3>
        <p class="text-3xl font-bold text-white"><?= $stats['approved_requests'] ?></p>
    </div>

    <!-- Total Shipments -->
    <div class="glass rounded-xl p-6 border border-gray-700 hover:border-blue-400 transition-colors relative overflow-hidden group">
        <div class="absolute right-0 top-0 mt-4 mr-4 text-blue-400 opacity-50 group-hover:opacity-100 transition-opacity">
            <i class="fas fa-truck fa-2x"></i>
        </div>
        <h3 class="text-gray-400 text-sm font-medium mb-1">Total Shipments</h3>
        <p class="text-3xl font-bold text-white"><?= $stats['total_shipments'] ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Requests -->
    <div class="lg:col-span-2 glass rounded-xl border border-gray-700 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-white">Recent Requests</h2>
            <a href="<?= base_url('supplier/requests') ?>" class="text-sm text-matcha-light hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 text-sm border-b border-gray-700">
                        <th class="pb-3">Product</th>
                        <th class="pb-3">Qty</th>
                        <th class="pb-3">Date</th>
                        <th class="pb-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_requests)): ?>
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">No recent requests</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($recent_requests as $req): ?>
                    <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/50 transition-colors">
                        <td class="py-3 font-medium"><?= htmlspecialchars($req['product_name']) ?></td>
                        <td class="py-3"><?= $req['quantity'] ?></td>
                        <td class="py-3 text-sm text-gray-400"><?= date('M d, Y', strtotime($req['created_at'])) ?></td>
                        <td class="py-3">
                            <?php
                            $colors = [
                                'pending' => 'bg-yellow-500/20 text-yellow-500 border-yellow-500/50',
                                'approved' => 'bg-matcha-dark/20 text-matcha-light border-matcha-dark/50',
                                'rejected' => 'bg-red-500/20 text-red-500 border-red-500/50',
                                'processing' => 'bg-blue-500/20 text-blue-500 border-blue-500/50',
                                'shipped' => 'bg-indigo-500/20 text-indigo-500 border-indigo-500/50',
                                'completed' => 'bg-green-500/20 text-green-500 border-green-500/50'
                            ];
                            $badge = isset($colors[$req['status']]) ? $colors[$req['status']] : 'bg-gray-500/20 text-gray-400 border-gray-500/50';
                            ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full border <?= $badge ?>">
                                <?= ucfirst($req['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stock Warning -->
    <div class="glass rounded-xl border border-gray-700 p-6">
        <h2 class="text-xl font-bold text-white mb-4">Stock Warning</h2>
        <ul class="space-y-4">
            <?php 
            $low_stock = array_filter($products, function($p) { return $p['stock'] < 10; });
            if (empty($low_stock)): ?>
            <li class="text-gray-500 text-center py-4">All stocks are sufficient</li>
            <?php else: ?>
            <?php foreach (array_slice($low_stock, 0, 5) as $p): ?>
            <li class="flex justify-between items-center bg-gray-800/50 p-3 rounded-lg border border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 rounded-full <?= $p['stock'] == 0 ? 'bg-red-500' : 'bg-yellow-500' ?>"></div>
                    <span class="font-medium text-sm"><?= htmlspecialchars($p['product_name']) ?></span>
                </div>
                <span class="text-sm <?= $p['stock'] == 0 ? 'text-red-500' : 'text-yellow-500' ?> font-bold">
                    <?= $p['stock'] ?> left
                </span>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
