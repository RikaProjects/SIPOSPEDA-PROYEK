<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sukahati - Rumah Potong Ayam dan supllier ayam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    h2.section-title {
      margin-bottom: 2rem;
      font-weight: bold;
    }
    .filter-btn.active {
      background-color: #dc3545;
      color: #fff;
    }
    .card {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.card-img-top {
  height: 200px;
  object-fit: cover;
}

.card-body {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}  
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('/') ?>">
  <img src="<?= base_url('assets/img/logo/logo-sukahati.png') ?>" alt="Sukahati Logo" height="40">
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="<?= base_url('/') ?>">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="#mitra-kami">Mitra Kami</a></li>
        <li class="nav-item"><a class="nav-link" href="#alamat">Alamat</a></li>
        <li class="nav-item"><a class="nav-link" href="#tentang-kami">Tentang Kami</a></li>
        <li class="nav-item">
          <a class="btn btn-outline-danger ms-2" href="<?= base_url('/login') ?>">Login/register</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="d-flex align-items-center text-center text-white" style="background: url('<?= base_url('assets/img/bg-login.jpg') ?>') 
center center / cover no-repeat; height: 50vh; position: relative;">
  <div style="background-color: rgba(0, 0, 0, 0.5); position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
  <div class="container position-relative z-1">
    <h1 class="display-4 fw-bold text-danger mb-2">SUKAHATI</h1>
    <p class="lead mb-1 text-white">100% HALAL • SEGAR • HIGIENIS • GRATIS PENGIRIMAN</p>
    <p class="fw-semibold fs-5 text-white">Supplier Ayam Potong Terlengkap</p>
  </div>
</section>

<!-- Keunggulan -->
<section class="py-5" id="keunggulan">
  <div class="container">
    <h2 class="section-title text-center text-danger">Keunggulan Kami</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <img src="<?= base_url('assets/img/jaminan-kualitas.png') ?>" class="card-img-top keunggulan-img" alt="Produk Fresh">
          <div class="card-body">
            <p class="card-text">Produk Selalu Fresh & Berkualitas</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <img src="<?= base_url('assets/img/sertifikat-halal.png') ?>" class="card-img-top keunggulan-img" alt="Sertifikasi Halal">
          <div class="card-body">
            <p class="card-text">Sertifikasi Halal & NKV (A.S.U.H)</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <img src="<?= base_url('assets/img/minimal order.png') ?>" class="card-img-top keunggulan-img" alt="Minimal Order">
          <div class="card-body">
            <p class="card-text">Minimal Order 50 Kg (10 Kg untuk Bandung/Tasik)</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- produk -->
<section class="py-5 bg-light" id="produk">
  <div class="container">
    <h2 class="section-title text-center text-danger">Produk yang kami jual</h2>
    <p class="text-center">100% HALAL / FRESH / HIGIENIS</p>

    <div class="row mb-4">
      <div class="col text-center">
        <div class="btn-group flex-wrap">
          <button class="btn btn-outline-danger btn-sm filter-btn active" data-filter="all">All Products</button>
          <button class="btn btn-outline-danger btn-sm filter-btn" data-filter="karkas">Karkas</button>
          <button class="btn btn-outline-danger btn-sm filter-btn" data-filter="ayam parting">Ayam Parting</button>
          <button class="btn btn-outline-danger btn-sm filter-btn" data-filter="boneless">Boneless</button>
          <button class="btn btn-outline-danger btn-sm filter-btn" data-filter="jeroan">Jeroan</button>
          <button class="btn btn-outline-danger btn-sm filter-btn" data-filter="ekses">Ekses</button>
        </div>
      </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      function slugify($string) {
        return strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9 ]/', '', $string)));
      }

      $products = [
        "ATPS Potong 6" => "Ayam Parting",
        "ATPS Potong 5" => "Ayam Parting",
        "Ayam Potong 12" => "Ayam Parting",
        "Ayam Potong 14" => "Ayam Parting",
        "Ayam Potong 10" => "Ayam Parting",
        "Ayam Potong 9" => "Ayam Parting",
        "Ayam Potong 8" => "Ayam Parting",
        "Ayam Potong 6" => "Ayam Parting",
        "Ayam Potong 4" => "Ayam Parting",
        "Usus" => "Jeroan",
        "Tulang Rawan Ayam" => "Ekses",
        "Tulang Ayam" => "Ekses",
        "Sayap Ayam" => "Ayam Parting",
        "Paha Ayam Utuh" => "Ayam Parting",
        "Paha Ayam Bawah" => "Ayam Parting",
        "Paha Ayam Atas" => "Ayam Parting",
        "Kulit Ayam" => "Ekses",
        "Lemak Ayam" => "Ekses",
        "Kerongkong" => "Jeroan",
        "Kepala Ayam" => "Ayam Parting",
        "Karkas" => "Karkas",
        "Jantung Ayam" => "Jeroan",
        "Dada Ayam Utuh" => "Ayam Parting",
        "Ceker Ayam" => "Ekses",
        "Brutu Ayam" => "Ekses",
        "Boneless Paha Ayam" => "Boneless",
        "Boneless Paha Kulit Ayam" => "Boneless",
        "Boneless Dada Kulit Ayam" => "Boneless",
        "Boneless Dada Ayam" => "Boneless",
        "Tembolok" => "Jeroan",
      ];

      foreach ($products as $name => $category):
        $slug = slugify($name);
        $imagePath = base_url("assets/img/produk/$slug.png");
      ?>
        <div class="col product-card" data-category="<?= strtolower($category) ?>">
          <div class="card h-100 border border-danger">
            <img 
              src="<?= $imagePath ?>" 
              class="card-img-top" 
              alt="<?= $name ?>"
              onerror="this.onerror=null;this.src='<?= base_url('assets/img/produk/default.jpg') ?>';"
            >
            <div class="card-body">
              <h5 class="card-title"><?= $name ?></h5>
              <p class="card-text"><span class="badge bg-danger"><?= $category ?></span></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Mitra Kami -->
<section class="py-5 bg-light" id="mitra-kami">
  <div class="container text-center">
    <h2 class="section-title text-danger">Mitra Kami</h2>
    <p>Dipercaya oleh berbagai rumah makan, katering, reseller, hingga hotel dan restoran di seluruh Indonesia.</p>
    <div class="row justify-content-center">
      <?php
      $logos = [
        'yogya.png', 'superindo.png', 'asia-toserba.png', 'dresto.png', 'carrefour.png',
        'dechick.png', 'transmart.png', 'ramayana.png', 'dbesto.png', 'emados.png',
        'dkiuk.png', 'kartika.png', 'yummie.png', 'urban-chicken.png', 'crisbar.png',
        'segari.png', 'newhope.png', 'hypermart.png',
      ];
      foreach ($logos as $logo): ?>
        <div class="col-4 col-sm-3 col-md-2 mb-4">
          <img src="<?= base_url('assets/img/mitra/' . $logo) ?>" class="img-fluid" alt="Mitra">
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Alamat -->
<section class="py-5" id="alamat">
  <div class="container">
    <h2 class="section-title text-danger mb-4 text-center">Alamat</h2>

    <div class="row align-items-start">
      <div class="col-md-6 mb-4">
        <div class="mb-4">
          <h5 class="fw-bold">Factory</h5>
          <p>Jl. Sambong Jaya, Kec. Mangkubumi, Kota Tasikmalaya, 46181</p>
        </div>

        <div class="mb-4">
          <h5 class="fw-bold">Branch Office</h5>
          <p>Komplek Ujungberung Indah No. 21-14, Kota Bandung 40611</p>
        </div>

        <div class="mb-4">
          <h5 class="fw-bold">Kontak</h5>
          <p>Phone 1: <a href="https://wa.me/6281388714281" target="_blank">+62 813-8871-4281</a><br>
             Phone 2: <a href="https://wa.me/6281316362286" target="_blank">+62 813-1636-2286</a></p>
          <p>Email: <a href="mailto:info@sukahati.co.id">info@sukahati.co.id</a></p>
        </div>
      </div>

      <!-- Google Maps -->
      <div class="col-md-6">
        <div class="ratio ratio-16x9 border rounded shadow">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63353.870003685585!2d108.18181226953124!3d-7.340091000000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f56bd9fd6322f%3A0x28e4be0ab2897c65!2sSambongpari%2C%20Kec.%20Mangkubumi%2C%20Kabupaten%20Tasikmalaya%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1718359999999!5m2!1sid!2sid" 
            width="100%" height="100%" style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Tentang Kami -->
<section class="py-5 bg-light" id="tentang-kami">
  <div class="container text-center">
    <h2 class="section-title text-danger mb-4">Tentang Kami</h2>
    <p class="mx-auto" style="max-width: 800px; text-align: justify;">
      Rumah Potong Ayam (RPA) Sukahati Chicken Processing berdiri pada tahun 2001 dengan 
      lokasi factory berada di Kota Tasikmalaya dan kantor cabang di Kota Bandung. 
      Kami merupakan perusahaan yang bergerak di bidang pemotongan ayam berbahan baku ayam hidup
      hasil seleksi dengan standar tinggi, sehingga kualitas ayam potong dapat terkontrol secara teliti.
    </p>
    <p class="mx-auto mb-4" style="max-width: 800px; text-align: justify;">
      Proses produksi kami didukung dengan teknologi pemotongan otomatis, dengan kapasitas potong mencapai kurang lebih 2000 ekor per jam atau sekitar 16.000 kg per hari.
    </p>

    <!-- Embed Video YouTube Tanpa Logo/Kontrol -->
    <div class="ratio ratio-16x9" style="max-width: 800px; margin: 0 auto; border-radius: 12px; overflow: hidden;">
      <iframe 
        src="https://www.youtube.com/embed/2hNx_8Qp5Wk?controls=0&showinfo=0&rel=0&modestbranding=1" 
        title="Tentang Sukahati" 
        frameborder="0" 
        allow="autoplay; encrypted-media" 
        allowfullscreen
        style="border: none;">
      </iframe>
    </div>
  </div>
</section>


<!-- Footer -->
<footer class="bg-danger text-white text-center py-4 mt-5">
  <div class="container">
    &copy; <?= date('Y') ?> Rika Rostika Afipah || Proyek 2
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const filterButtons = document.querySelectorAll('.filter-btn');
  const productCards = document.querySelectorAll('.product-card');

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.getAttribute('data-filter');

      filterButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');

      productCards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
</script>
</body>
</html>