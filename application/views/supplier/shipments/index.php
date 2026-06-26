<style>
.dt-card { background:#fff; border:1px solid #e2e8f0; border-radius:18px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.07); overflow:hidden; }
.dt-head  { padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; }
.dt-title { font-weight:700; color:#1e293b; font-size:0.95rem; margin:0; }
.form-card { background:#fff; border:1px solid #e2e8f0; border-radius:18px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.07); padding:1.5rem; }
.form-card h5 { font-weight:700; color:#1a2e25; margin-bottom:1.2rem; font-size:1rem; }
.form-label-s { font-size:0.8rem; font-weight:700; color:#64748b; display:block; margin-bottom:0.4rem; }
.form-input-s { width:100%; border:1px solid #e2e8f0; border-radius:12px; padding:9px 14px; font-size:0.875rem; color:#1a2e25; font-family:'Outfit',sans-serif; outline:none; transition:border-color 0.2s; }
.form-input-s:focus { border-color:#8BAA7C; box-shadow:0 0 0 3px rgba(139,170,124,0.12); }
.btn-submit { width:100%; background:#1B3B25; color:#fff; border:none; border-radius:12px; padding:11px; font-size:0.9rem; font-weight:700; cursor:pointer; font-family:'Outfit',sans-serif; transition:all 0.2s; margin-top:1rem; }
.btn-submit:hover { background:#53725D; }
table.dataTable thead th { font-size:0.7rem; text-transform:uppercase; letter-spacing:0.07em; color:#94a3b8; font-weight:700; padding:0.75rem 1rem; border-bottom:1px solid #f1f5f9 !important; background:#fff; }
table.dataTable tbody td { padding:0.85rem 1rem; font-size:0.875rem; color:#1e293b; border-bottom:1px solid #f8fafc !important; vertical-align:middle; }
table.dataTable tbody tr:hover td { background:#f8faf8; }
table.dataTable tbody tr:last-child td { border-bottom:none !important; }
.dataTables_wrapper .dataTables_filter input { border:1px solid #e2e8f0; border-radius:10px; padding:6px 12px; font-size:0.85rem; outline:none; font-family:'Outfit',sans-serif; }
.dataTables_wrapper .dataTables_filter input:focus { border-color:#8BAA7C; box-shadow:0 0 0 3px rgba(139,170,124,0.15); }
.dataTables_wrapper .dataTables_length select { border:1px solid #e2e8f0; border-radius:10px; padding:5px 10px; font-size:0.85rem; font-family:'Outfit',sans-serif; }
.dataTables_wrapper .dataTables_paginate .paginate_button { border-radius:8px !important; border:none !important; font-size:0.82rem; padding:5px 11px !important; }
.dataTables_wrapper .dataTables_paginate .paginate_button.current { background:#1B3B25 !important; color:#fff !important; }
.dataTables_wrapper .dataTables_paginate .paginate_button:hover { background:#f1f5f9 !important; color:#1B3B25 !important; }
.dataTables_wrapper .dataTables_info { font-size:0.8rem; color:#94a3b8; }
</style>

<!-- Page Header -->
<div style="margin-bottom:1.5rem;">
    <h4 style="font-weight:800; color:#1a2e25; margin-bottom:0.2rem;">Shipments</h4>
    <p style="color:#64748b; font-size:0.875rem; margin:0;">Manage outbound shipments to Macha UMKM.</p>
</div>

<div class="row g-4">
    <!-- New Shipment Form -->
    <div class="col-lg-4">
        <div class="form-card">
            <h5><i class="fas fa-paper-plane" style="color:#8BAA7C; margin-right:8px;"></i> New Shipment</h5>

            <?php if (empty($approved_requests)): ?>
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:1.5rem; text-align:center;">
                    <i class="fas fa-box-open" style="font-size:1.8rem; color:#cbd5e1; display:block; margin-bottom:0.75rem;"></i>
                    <p style="color:#94a3b8; font-size:0.875rem; margin:0;">No approved requests available to ship.</p>
                </div>
            <?php else: ?>
                <?= form_open_multipart('supplier/shipments/create') ?>
                    <div style="margin-bottom:1rem;">
                        <label class="form-label-s">Select Request</label>
                        <select name="request_id" required class="form-input-s">
                            <option value="">-- Choose Request --</option>
                            <?php foreach ($approved_requests as $req): ?>
                                <option value="<?= $req['id'] ?>">
                                    #REQ-<?= str_pad($req['id'], 4, '0', STR_PAD_LEFT) ?> - <?= htmlspecialchars($req['product_name']) ?> (<?= $req['quantity'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label class="form-label-s">Tracking Number / Resi</label>
                        <input type="text" name="tracking_number" required class="form-input-s" placeholder="e.g. JNE123456789">
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label class="form-label-s">Shipping Proof (Receipt/Photo)</label>
                        <input type="file" name="shipping_proof" accept="image/*,.pdf" required class="form-input-s" style="padding:6px 12px;">
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane" style="margin-right:6px;"></i> Submit Shipment
                    </button>
                <?= form_close() ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Shipment History Table -->
    <div class="col-lg-8">
        <div class="dt-card">
            <div class="dt-head">
                <h6 class="dt-title"><i class="fas fa-history" style="color:#8BAA7C; margin-right:6px;"></i> Shipment History</h6>
            </div>
            <div style="padding:1rem;">
                <table id="tblShipments" class="w-100" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Tracking No.</th>
                            <th>Request Ref</th>
                            <th>Shipped At</th>
                            <th>Status</th>
                            <th>Proof</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function(){
    $('#tblShipments').DataTable({
        ajax: { url: '<?= base_url('supplier/shipments/dt_json') ?>', dataSrc: 'data' },
        columns: [
            { title:'Tracking No.' },
            { title:'Request Ref' },
            { title:'Shipped At' },
            { title:'Status' },
            { title:'Proof', orderable:false },
        ],
        pageLength: 10,
        language: { search:'', searchPlaceholder:'Cari pengiriman...', emptyTable:'Belum ada pengiriman.', zeroRecords:'Tidak ditemukan.' },
        order: [[2,'desc']],
    });
});
</script>
