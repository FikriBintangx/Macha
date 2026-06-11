<div class="p-6 h-screen overflow-y-auto w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Supplier <span class="text-matcha-light">Profile</span></h1>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-500/20 border border-green-500/50 text-green-400 p-4 rounded-lg mb-6">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="bg-dark-200 border border-gray-700 rounded-lg p-6 max-w-2xl">
        <form action="<?= base_url('supplier/profile/update') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
            
            <div class="flex items-center gap-4 mb-6">
                <?php if(!empty($supplier['logo'])): ?>
                    <img src="<?= base_url('uploads/'.$supplier['logo']) ?>" class="w-20 h-20 rounded-full object-cover border-2 border-matcha-dark">
                <?php else: ?>
                    <div class="w-20 h-20 rounded-full bg-gray-700 flex items-center justify-center border-2 border-matcha-dark">
                        <i class="bi bi-shop text-3xl text-gray-400"></i>
                    </div>
                <?php endif; ?>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Upload Logo</label>
                    <input type="file" name="logo" class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-matcha-dark/20 file:text-matcha-light hover:file:bg-matcha-dark/30">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Company Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($supplier['name'] ?? '') ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-matcha-light" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Email Address (Cannot be changed)</label>
                <input type="email" value="<?= htmlspecialchars($supplier['email'] ?? '') ?>" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-400 cursor-not-allowed" disabled>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Phone Number</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($supplier['phone'] ?? '') ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-matcha-light">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Address</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-matcha-light"><?= htmlspecialchars($supplier['address'] ?? '') ?></textarea>
            </div>

            <hr class="border-gray-700">

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Change Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep current password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-matcha-light">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-matcha-dark hover:bg-matcha-light text-white hover:text-dark-200 px-6 py-2 rounded-lg transition-colors font-medium">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
