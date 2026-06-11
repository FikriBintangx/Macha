<div class="glass rounded-xl border border-gray-700 p-6 max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-white">Add New Product</h2>
        <a href="<?= base_url('supplier/products') ?>" class="text-gray-400 hover:text-white">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <form action="<?= base_url('supplier/products/store') ?>" method="post" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Product Name</label>
                <input type="text" name="product_name" required class="w-full bg-dark-200 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Category</label>
                <input type="text" name="category" class="w-full bg-dark-200 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Stock</label>
                <input type="number" name="stock" value="0" class="w-full bg-dark-200 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Unit (e.g. kg, pcs)</label>
                <input type="text" name="unit" class="w-full bg-dark-200 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Price</label>
                <input type="number" step="0.01" name="price" required class="w-full bg-dark-200 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                <select name="status" class="w-full bg-dark-200 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light">
                    <option value="active">Available</option>
                    <option value="inactive">Out of Stock</option>
                </select>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full bg-dark-200 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light"></textarea>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-1">Product Image</label>
            <input type="file" name="image" class="w-full bg-dark-200 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-matcha-light file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-matcha-dark file:text-white hover:file:bg-matcha">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-matcha hover:bg-matcha-dark text-white font-bold py-2 px-6 rounded-lg transition-colors">
                Save Product
            </button>
        </div>
    </form>
</div>
