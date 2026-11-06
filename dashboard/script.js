

document.addEventListener('click', function (e) {
  var tombol = e.target.closest('[data-confirm]');
  if (tombol && !confirm(tombol.dataset.confirm)) e.preventDefault();
});

var cari = document.getElementById('cari');
if (cari) {
  cari.addEventListener('input', function () {
    var kata = cari.value.toLowerCase();
    document.querySelectorAll('table.data tbody tr').forEach(function (tr) {
      tr.style.display = tr.textContent.toLowerCase().includes(kata) ? '' : 'none';
    });
  });
}
var tglPinjam = document.getElementById('tgl_peminjaman');
var batas = document.getElementById('batas_pengembalian');
if (tglPinjam && batas) {
  tglPinjam.addEventListener('change', function () {
    var d = new Date(tglPinjam.value);
    d.setDate(d.getDate() + parseInt(tglPinjam.dataset.lama || 7));
    batas.value = d.toISOString().slice(0, 10);
  });
}

var form = document.getElementById('form-kembali');
if (form) {
  var pilihPinjam = form.querySelector('[name=no_peminjaman]');
  var tglKembali = form.querySelector('[name=tgl_pengembalian]');
  var kondisi = form.querySelector('[name=kondisi_buku]');
  var hasil = document.getElementById('preview');

  function hitungDenda() {
    var opsi = pilihPinjam.selectedOptions[0];
    if (!opsi || !opsi.dataset.batas) { hasil.textContent = 'Rp 0'; return; }
    var hari = Math.max(0, Math.floor((new Date(tglKembali.value) - new Date(opsi.dataset.batas)) / 86400000));
    var dendaKondisi = JSON.parse(form.dataset.kondisi)[kondisi.value] || 0;
    var total = hari * parseInt(form.dataset.perhari) + dendaKondisi;
    hasil.textContent = 'Rp ' + total.toLocaleString('id-ID') + ' (' + hari + ' hari terlambat)';
  }
  [pilihPinjam, tglKembali, kondisi].forEach(function (el) { el.addEventListener('change', hitungDenda); });
  hitungDenda();
}
