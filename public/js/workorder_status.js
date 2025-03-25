$(document).ready(function () {
    var table = $("#woTable").DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        scrollX: true,
        columnDefs: [
            { orderable: false, targets: 7 }, // Nonaktifkan sorting di kolom Download
        ],
    });

    // Tambahkan dropdown sejajar dengan search bar
    $("#woTable_filter").append(`
            <label style="margin-left: 10px;">
                <select id="columnFilter" class="form-select form-select-sm">
                    <option value="">Semua Kolom</option>
                    <option value="0">Nomor WO</option>
                    <option value="1">Status</option>
                    <option value="2">Tanggal Order</option>
                    <option value="3">Tanggal Selesai</option>
                    <option value="4">Nama Pemohon</option>
                    <option value="5">Departemen</option>
                    <option value="6">Jenis Pekerjaan</option>
                </select>
            </label>
            
        `);

    // Filter berdasarkan kolom tertentu
    $("#columnFilter").on("change", function () {
        var columnIndex = $(this).val();
        table.search("").draw(); // Reset pencarian saat ganti kolom

        if (columnIndex !== "") {
            table.columns().search(""); // Reset semua kolom
            $("#woTable_filter input")
                .off()
                .on("keyup", function () {
                    table.column(columnIndex).search(this.value).draw();
                });
        } else {
            $("#woTable_filter input")
                .off()
                .on("keyup", function () {
                    table.search(this.value).draw();
                });
        }
    });

    // Tampilkan modal saat tombol export diklik
    $("#openExportModal").on("click", function (e) {
        e.preventDefault();
        $("#exportFilterModal").modal("show");
    });

    // Form submit untuk export data
    $("#exportFilterForm").on("submit", function (e) {
        e.preventDefault();

        let startDate = $("#startDate").val();
        let endDate = $("#endDate").val();
        let status = $("#status").val();
        let departemen = $("#departemen").val();

        // Ambil semua jenis pekerjaan yang dicentang
        let jenisPekerjaan = [];
        $("input[name='jenis_pekerjaan[]']:checked").each(function () {
            jenisPekerjaan.push($(this).val());
        });

        // Ambil URL dari tombol export
        let exportUrl = $("#openExportModal").data("url");

        // Buat URL dengan parameter yang sesuai
        let url =
            exportUrl +
            "?startDate=" +
            encodeURIComponent(startDate) +
            "&endDate=" +
            encodeURIComponent(endDate) +
            "&status=" +
            encodeURIComponent(status) +
            "&departemen=" +
            encodeURIComponent(departemen) +
            "&jenisPekerjaan=" +
            encodeURIComponent(jenisPekerjaan.join(",")); // Gabungkan array menjadi string

        // Arahkan ke URL untuk mengunduh file Excel
        window.location.href = url;

        // Sembunyikan modal setelah submit
        $("#exportFilterModal").modal("hide");
    });
});
