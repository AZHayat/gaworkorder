<!-- Modal Export Filter -->
<div class="modal fade" id="exportFilterModal" tabindex="-1" aria-labelledby="exportFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportFilterModalLabel">Filter Export Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="exportFilterForm">
                  <!-- Status -->
                  <div class="form-group">
                      <label for="status">Status</label>
                      <select class="form-control" id="status" name="status">
                          <option value="">Semua</option>
                          <option value="Open">🟢 Open</option>
                          <option value="Proses">🔵 Proses</option>
                          <option value="Pending">🟡 Pending</option>
                          <option value="Close">🔴 Close</option>
                      </select>
                  </div>

                  <!-- Tanggal Order -->
                  <div class="form-group">
                      <label>Tanggal Order</label>
                      <div class="d-flex">
                          <input type="date" class="form-control" id="orderStartDate" name="orderStartDate">
                          <span class="mx-2 align-self-center">sampai dengan</span>
                          <input type="date" class="form-control" id="orderEndDate" name="orderEndDate">
                      </div>
                  </div>

                  <!-- Tanggal Selesai -->
                  <div class="form-group">
                      <label>Tanggal Selesai</label>
                      <div class="d-flex">
                          <input type="date" class="form-control" id="doneStartDate" name="doneStartDate">
                          <span class="mx-2 align-self-center">sampai dengan</span>
                          <input type="date" class="form-control" id="doneEndDate" name="doneEndDate">
                      </div>
                  </div>

                  <!-- Departemen -->
                  <div class="form-group">
                      <label for="departemen">Departemen Pemohon</label>
                      <select class="form-control" id="departemen" name="departemen">
                          <option value="">Semua</option>
                          <option value="Engineering">Engineering</option>
                          <option value="CPP">CPP</option>
                          <option value="Metalize">Metalize</option>
                          <option value="Slitting">Slitting</option>
                          <option value="Warehouse & PPIC">Warehouse & PPIC</option>
                          <option value="Laboratorium">Laboratorium</option>
                          <option value="Direksi">Direksi</option>
                          <option value="Others">Others</option>
                      </select>
                      <input type="text" class="form-control mt-2 d-none" id="departemen_lainnya" name="departemen_lainnya" placeholder="Isi Departemen Lainnya" maxlength="20">
                  </div>

                  <!-- Tombol Export -->
                  <button type="submit" class="btn btn-success">Export Excel</button>
              </form>

            </div>
        </div>
    </div>
</div>
