document.getElementById('nama_pelanggan_lama').addEventListener('change', function () {
    const nama = this.value;

    if (nama.trim() === "") return;

    fetch(`kasir/cek_deposito.php?nama=${encodeURIComponent(nama)}`)
        .then(response => response.json())
        .then(data => {
            if (data.deposit > 0) {
                document.getElementById('deposito-container').style.display = 'block';
                document.getElementById('deposito').value = data.deposit;
            } else {
                document.getElementById('deposito-container').style.display = 'none';
                document.getElementById('deposito').value = '';
            }
        })
        .catch(error => {
            console.error("Gagal mengecek deposito:", error);
        });
});
