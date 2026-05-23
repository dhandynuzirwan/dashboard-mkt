<div class="modal fade" id="modalDetailStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content card-modern shadow-lg">
            <div class="modal-header bg-primary-subtle text-primary border-bottom-0">
                <h5 class="modal-title fw-bolder" id="modalDetailTitle">
                    <i class="fas fa-list me-2"></i> Detail Prospek
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover mb-0 align-middle">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th class="text-center" width="120">Tanggal</th>
                                <th>Perusahaan</th>
                                <th>PIC & Jabatan</th>
                                <th class="text-center" width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody id="modalDetailBody">
                            <!-- Data dari AJAX akan masuk ke sini -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0 pt-2 pb-2">
                <button type="button" class="btn btn-white border fw-bold btn-round btn-sm text-dark" data-bs-dismiss="modal">Tutup Layar</button>
            </div>
        </div>
    </div>
</div>