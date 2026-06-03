<div class="mb-6">
    <h1 class="text-2xl font-bold text-white"><?= $title ?></h1>
    <p class="text-gray-400 mt-1">Manage purchase requests from Macha Admin.</p>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="bg-green-500/20 border border-green-500/50 text-green-500 p-4 rounded-lg mb-6">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="bg-red-500/20 border border-red-500/50 text-red-500 p-4 rounded-lg mb-6">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>

<div class="glass rounded-xl border border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-800/50 text-gray-400 text-sm border-b border-gray-700">
                    <th class="p-4">Request ID</th>
                    <th class="p-4">Product Name</th>
                    <th class="p-4">Quantity</th>
                    <th class="p-4">Note</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($requests)): ?>
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                        <p>No requests found.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($requests as $req): ?>
                    <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/30 transition-colors">
                        <td class="p-4 text-gray-400 font-mono text-sm">#REQ-<?= str_pad($req['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td class="p-4 font-medium text-white"><?= htmlspecialchars($req['product_name']) ?></td>
                        <td class="p-4 text-white font-bold"><?= $req['quantity'] ?></td>
                        <td class="p-4 text-gray-400 text-sm max-w-xs truncate" title="<?= htmlspecialchars($req['note']) ?>">
                            <?= !empty($req['note']) ? htmlspecialchars($req['note']) : '-' ?>
                        </td>
                        <td class="p-4 text-sm text-gray-400"><?= date('d M Y, H:i', strtotime($req['created_at'])) ?></td>
                        <td class="p-4">
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
                        <td class="p-4 text-right">
                            <?php if ($req['status'] == 'pending'): ?>
                                <div class="flex justify-end gap-2">
                                    <a href="<?= base_url('supplier/requests/update_status/'.$req['id'].'/approved') ?>" onclick="return confirm('Approve this request?');" class="bg-matcha-dark/20 hover:bg-matcha-dark text-matcha-light hover:text-white px-3 py-1 rounded transition-colors text-sm border border-matcha-dark/50">Approve</a>
                                    <a href="<?= base_url('supplier/requests/update_status/'.$req['id'].'/rejected') ?>" onclick="return confirm('Reject this request?');" class="bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white px-3 py-1 rounded transition-colors text-sm border border-red-500/50">Reject</a>
                                </div>
                            <?php elseif ($req['status'] == 'approved'): ?>
                                <a href="<?= base_url('supplier/requests/update_status/'.$req['id'].'/processing') ?>" class="bg-blue-500/20 hover:bg-blue-500 text-blue-400 hover:text-white px-3 py-1 rounded transition-colors text-sm border border-blue-500/50 inline-block">Start Processing</a>
                            <?php elseif ($req['status'] == 'processing'): ?>
                                <a href="<?= base_url('supplier/shipments') ?>" class="bg-indigo-500/20 hover:bg-indigo-500 text-indigo-400 hover:text-white px-3 py-1 rounded transition-colors text-sm border border-indigo-500/50 inline-block">Create Shipment</a>
                            <?php else: ?>
                                <span class="text-gray-500 text-sm">No actions</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
