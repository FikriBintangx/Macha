<style>
.dt-card { background:#fff; border:1px solid #e2e8f0; border-radius:18px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.07); overflow:hidden; }
.dt-head  { padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; }
.dt-title { font-weight:700; color:#1e293b; font-size:0.95rem; margin:0; }
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
    <h4 style="font-weight:800; color:#1a2e25; margin-bottom:0.2rem;">Requests</h4>
    <p style="color:#64748b; font-size:0.875rem; margin:0;">Kelola permintaan pembelian dari Macha Admin.</p>
</div>

<div class="dt-card">
    <div class="dt-head">
        <h6 class="dt-title"><i class="fas fa-clipboard-list" style="color:#8BAA7C; margin-right:6px;"></i> Purchase Requests</h6>
    </div>
    <div style="padding:1rem;">
        <table id="tblRequests" class="w-100" style="width:100%;">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Note</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function(){
    $('#tblRequests').DataTable({
        ajax: { url: '<?= base_url('supplier/requests/dt_json') ?>', dataSrc: 'data' },
        columns: [
            { title:'Request ID' },
            { title:'Product' },
            { title:'Qty' },
            { title:'Note' },
            { title:'Date' },
            { title:'Status' },
            { title:'Actions', orderable:false },
        ],
        pageLength: 10,
        language: { search:'', searchPlaceholder:'Cari request...', emptyTable:'Belum ada request.', zeroRecords:'Request tidak ditemukan.' },
        order: [[4,'desc']],
    });
});
</script>
