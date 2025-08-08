document.addEventListener('DOMContentLoaded', function () {
  const provinsiSelect = document.getElementById('provinsi');
  const kotaSelect = document.getElementById('kota');
  const kecamatanSelect = document.getElementById('kecamatan');

  provinsiSelect.addEventListener('change', function () {
    const provinsi = this.value;
    kotaSelect.innerHTML = '<option value="">Memuat Kota...</option>';
    kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

    if (provinsi !== '') {
      fetch('/mitra/getKota/' + encodeURIComponent(provinsi))
        .then(res => res.json())
        .then(data => {
          kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';
          data.forEach(item => {
            kotaSelect.innerHTML += `<option value="${item.nama}">${item.nama}</option>`;
          });
        })
        .catch(() => {
          kotaSelect.innerHTML = '<option value="">Gagal memuat kota</option>';
        });
    } else {
      kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';
    }
  });

  kotaSelect.addEventListener('change', function () {
    const kota = this.value;
    kecamatanSelect.innerHTML = '<option value="">Memuat Kecamatan...</option>';

    if (kota !== '') {
      fetch('/mitra/getKecamatan/' + encodeURIComponent(kota))
        .then(res => res.json())
        .then(data => {
          kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
          data.forEach(item => {
            kecamatanSelect.innerHTML += `<option value="${item.nama}">${item.nama}</option>`;
          });
        })
        .catch(() => {
          kecamatanSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
        });
    } else {
      kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
    }
  });
});
