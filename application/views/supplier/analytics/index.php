<div class="p-6 h-screen overflow-y-auto w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Supplier <span class="text-matcha-light">Analytics</span></h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Analytics Content -->
        <div class="bg-dark-200 border border-gray-700 rounded-lg p-6">
            <h3 class="text-xl font-bold text-white mb-4">Monthly Requests</h3>
            <div class="flex items-end gap-2 h-48 mt-4">
                <?php foreach($monthly_requests as $val): ?>
                    <div class="bg-matcha-dark hover:bg-matcha-light transition-all w-full relative group rounded-t" style="height: <?= min(100, max(5, ($val/100)*100)) ?>%">
                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            <?= $val ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-dark-200 border border-gray-700 rounded-lg p-6">
            <h3 class="text-xl font-bold text-white mb-4">Monthly Supply</h3>
            <div class="flex items-end gap-2 h-48 mt-4">
                <?php foreach($monthly_supply as $val): ?>
                    <div class="bg-blue-500 hover:bg-blue-400 transition-all w-full relative group rounded-t" style="height: <?= min(100, max(5, ($val/100)*100)) ?>%">
                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            <?= $val ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
