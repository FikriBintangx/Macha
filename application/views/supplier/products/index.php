<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white"><?= $title ?></h1>
    <a href="<?= base_url('supplier/products/create') ?>" class="bg-matcha-dark hover:bg-matcha-light text-white hover:text-dark-200 px-4 py-2 rounded-lg transition-colors font-medium flex items-center gap-2">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="bg-green-500/20 border border-green-500/50 text-green-500 p-4 rounded-lg mb-6">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<div class="glass rounded-xl border border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-800/50 text-gray-400 text-sm border-b border-gray-700">
                    <th class="p-4">Image</th>
                    <th class="p-4">Product Name</th>
                    <th class="p-4">Category</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Stock</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                        <p>No products found in your catalog.</p>
                        <p class="text-sm mt-1">Click "Add Product" to start adding items.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                    <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/30 transition-colors">
                        <td class="p-4">
                            <?php if (!empty($p['image'])): ?>
                                <img src="<?= base_url('uploads/' . $p['image']) ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" class="w-12 h-12 object-cover rounded-lg border border-gray-700">
                            <?php else: ?>
                                <div class="w-12 h-12 bg-gray-800 rounded-lg border border-gray-700 flex items-center justify-center text-gray-500">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 font-medium text-white"><?= htmlspecialchars($p['product_name']) ?></td>
                        <td class="p-4 text-gray-400"><?= htmlspecialchars($p['category']) ?></td>
                        <td class="p-4 text-white">Rp <?= number_format($p['price'], 0, ',', '.') ?> <span class="text-xs text-gray-500">/ <?= htmlspecialchars($p['unit']) ?></span></td>
                        <td class="p-4">
                            <span class="<?= $p['stock'] < 10 ? 'text-yellow-500 font-bold' : 'text-gray-300' ?>">
                                <?= $p['stock'] ?>
                            </span>
                        </td>
                        <td class="p-4">
                            <?php if ($p['status'] == 'available'): ?>
                                <span class="px-2 py-1 text-xs font-medium rounded-full border bg-matcha-dark/20 text-matcha-light border-matcha-dark/50">Available</span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs font-medium rounded-full border bg-red-500/20 text-red-500 border-red-500/50">Out of Stock</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="<?= base_url('supplier/products/edit/'.$p['id']) ?>" class="w-8 h-8 rounded bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white flex items-center justify-center transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('supplier/products/delete/'.$p['id']) ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="w-8 h-8 rounded bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
