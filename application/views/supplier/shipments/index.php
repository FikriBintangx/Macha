<div class="mb-6">
    <h1 class="text-2xl font-bold text-white"><?= $title ?></h1>
    <p class="text-gray-400 mt-1">Manage outbound shipments to Macha UMKM.</p>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="bg-green-500/20 border border-green-500/50 text-green-500 p-4 rounded-lg mb-6">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Create Shipment Form -->
    <div class="lg:col-span-1">
        <div class="glass rounded-xl border border-gray-700 p-6">
            <h2 class="text-xl font-bold text-white mb-4">New Shipment</h2>
            
            <?php if (empty($approved_requests)): ?>
                <div class="bg-gray-800/50 border border-gray-700 p-4 rounded-lg text-center">
                    <i class="fas fa-box-open text-gray-500 fa-2x mb-2"></i>
                    <p class="text-gray-400 text-sm">No approved or processing requests available to ship.</p>
                </div>
            <?php else: ?>
                <?= form_open_multipart('supplier/shipments/create', ['class' => 'space-y-4']) ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Select Request</label>
                        <select name="request_id" required class="w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light">
                            <option value="">-- Choose Request --</option>
                            <?php foreach ($approved_requests as $req): ?>
                                <option value="<?= $req['id'] ?>">
                                    #REQ-<?= str_pad($req['id'], 4, '0', STR_PAD_LEFT) ?> - <?= htmlspecialchars($req['product_name']) ?> (<?= $req['quantity'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Tracking Number / Resi</label>
                        <input type="text" name="tracking_number" required class="w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light" placeholder="e.g. JNE123456789">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Shipping Proof (Receipt/Photo)</label>
                        <input type="file" name="shipping_proof" accept="image/*,.pdf" required class="w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-2 text-gray-400 focus:outline-none focus:border-matcha-light file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-matcha-dark/20 file:text-matcha-light hover:file:bg-matcha-dark/30">
                    </div>
                    
                    <button type="submit" class="w-full bg-matcha-dark hover:bg-matcha-light text-white hover:text-dark-200 py-2 rounded-lg font-medium transition-colors mt-4">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Shipment
                    </button>
                <?= form_close() ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Shipments History -->
    <div class="lg:col-span-2">
        <div class="glass rounded-xl border border-gray-700 overflow-hidden h-full">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold text-white">Shipment History</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-800/50 text-gray-400 text-sm border-b border-gray-700">
                            <th class="p-4">Tracking Number</th>
                            <th class="p-4">Request Ref</th>
                            <th class="p-4">Shipped At</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($shipments)): ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <i class="fas fa-truck fa-3x mb-3 opacity-50"></i>
                                <p>No shipments recorded yet.</p>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($shipments as $ship): ?>
                            <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/30 transition-colors">
                                <td class="p-4 font-mono text-white font-bold"><?= htmlspecialchars($ship['tracking_number']) ?></td>
                                <td class="p-4 text-sm text-gray-400">#REQ-<?= str_pad($ship['request_id'], 4, '0', STR_PAD_LEFT) ?></td>
                                <td class="p-4 text-sm text-gray-400"><?= date('d M Y', strtotime($ship['shipped_at'])) ?></td>
                                <td class="p-4">
                                    <?php if ($ship['status'] == 'shipped'): ?>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full border bg-indigo-500/20 text-indigo-500 border-indigo-500/50">Shipped</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full border bg-green-500/20 text-green-500 border-green-500/50">Delivered</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4">
                                    <?php if (!empty($ship['shipping_proof'])): ?>
                                        <a href="<?= base_url('uploads/'.$ship['shipping_proof']) ?>" target="_blank" class="text-matcha-light hover:underline text-sm flex items-center gap-1">
                                            <i class="fas fa-external-link-alt"></i> View
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-sm">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
