<?php

    // URL api 
    $api_url = 'http://103.255.240.205:84/api/infaq';

    // fungsi untuk mengambil data dari api
    function getSaldoInfaq($url){
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      if (curl_errno($ch)) {
        return ['error' => 'Gagal mengambil data :' . curl_err($ch)];
      }
      curl_close($ch);
      return json_decode($response, true);
    }

    // ambil data 
    $infaq = getSaldoInfaq($api_url);

    // echo '<pre>';
    // print_r($infaq);
    // echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Al - Istiqomah</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="toggle-sidebar">

  <!-- ======= Header ======= -->
  <header id="header" class="align-items-center" style="height: 10vw;">
    <div class="d-flex align-items-center justify-content-between">
      <a href="../display/index.php">
        <img src="../dist/img/1738810061.png" alt="" style="height: 12vw; width: 20vw;">
      </a>
    </div><!-- End Logo -->
  </header><!-- End Header -->

  
  <main id="main" class="main mt-2">

    <div class="pagetitle">
      <h1>Rekapitulasi Infaq dan Zakat Ramadhan 1446 H.</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Infaq Card -->
            <div class="col-xxl-4 col-lg-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <?php if (isset($infaq['infaq_terakhir'])) : ?>
                <div class="card-body">
                  <h2 class="card-title"><?php echo $infaq['infaq_terakhir']['keterangan']?> :</h2>
                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div> -->
                      
                      <div class="ps-3">
                        <h6 style="font-size: 5vw;">Rp. <?php echo number_format($infaq['infaq_terakhir']['jumlah'], 0, ',', '.'); ?></h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                        
                      </div>
                  </div>
                </div>
                <?php endif; ?>

              </div>
            </div><!-- End Infaq Card -->

            <!-- Infaq Card -->
            <div class="col-xxl-4 col-lg-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Total Infaq Tarawih :</h5>

                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div> -->
                    <?php if (isset($infaq['saldo_infaq'])) :?>
                    <div class="ps-3">
                      <h6 style="font-size: 5vw;">Rp. <?php echo number_format($infaq['saldo_infaq'],0,',','.'); ?> </h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div><!-- End Infaq Card -->  

          </div>
        </div><!-- End Left side columns -->
      </div>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="row">

          <!-- Fitrah Uang -->
            <div class="col-lg-3">
              <div class="card info-card sales-card">
  
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
  
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>
  
                <div class="card-body">
                  <h5 class="card-title">Zakat Fitrah Uang </h5>
  
                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div> -->
                    <div class="ps-3">
                      <h6 style="font-size: 3vw;">Rp. -</h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
  
                    </div>
                  </div>
                </div>
  
              </div>
            </div>


            <!-- Fitrah Beras -->
            <div class="col-lg-3">
              <div class="card info-card sales-card">
  
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
  
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>
  
                <div class="card-body">
                  <h5 class="card-title">Zakat Fitrah Beras </h5>
  
                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div> -->
                    <div class="ps-3">
                      <h6 style="font-size: 3vw;">- .Kg</h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
  
                    </div>
                  </div>
                </div>
  
              </div>
            </div>

            <!-- Mal -->
            <div class="col-lg-3">
              <div class="card info-card sales-card">
  
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
  
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>
  
                <div class="card-body">
                  <h5 class="card-title">Zakat Mal </h5>
  
                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div> -->
                    <div class="ps-3">
                      <h6 style="font-size: 3vw;">Rp. -</h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
  
                    </div>
                  </div>
                </div>
  
              </div>
            </div> 
            
            <div class="col-lg-3">
              <div class="card info-card sales-card">
  
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
  
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>
  
                <div class="card-body">
                  <h5 class="card-title">Infaq </h5>
  
                  <div class="d-flex align-items-center">
                    <!-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div> -->
                    <div class="ps-3">
                      <h6 style="font-size: 3vw;">Rp. -</h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
  
                    </div>
                  </div>
                </div>
  
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Al - Istiqomah</span></strong> <?php echo date('Y')?>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- <script>
    setInterval(function() {
        let now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();

        // Daftar jam pindah halaman (sesuaikan dengan kebutuhan)
        let schedule = {
            "05:30": "/display/index.php",
            "14:00": "/display/index.php",
            "21:00": "/display/index.php",
        };

        let currentTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

        if (schedule[currentTime]) {
            window.location.href = schedule[currentTime]; // Redirect ke halaman tujuan
        }
    }, 60000); // Cek setiap 1 menit

  </script> -->

  <script>
    // Daftar jam pindah halaman (sesuaikan dengan kebutuhan)
    const schedule = {
        "05:30": "/display/index.php",
        "14:00": "/display/index.php",
        "21:00": "/display/index.php",
    };

    // Fungsi untuk memeriksa jadwal dan redirect
    function checkSchedule() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const currentTime = `${hours}:${minutes}`;

        // Jika waktu saat ini cocok dengan jadwal, lakukan redirect
        if (schedule[currentTime]) {
            console.log(`Redirecting to ${schedule[currentTime]} at ${currentTime}`);
            window.location.href = schedule[currentTime]; // Redirect ke halaman tujuan
            return; // Berhenti setelah redirect
        }

        // Jika tidak, jadwalkan pemeriksaan berikutnya
        scheduleNextCheck();
    }

    // Fungsi untuk menjadwalkan pemeriksaan berikutnya
    function scheduleNextCheck() {
        const now = new Date();
        const currentTime = now.getHours() * 60 + now.getMinutes(); // Waktu saat ini dalam menit

        // Cari jadwal berikutnya
        let nextScheduleTime = null;
        let smallestDiff = Infinity;

        for (const time in schedule) {
            const [scheduleHours, scheduleMinutes] = time.split(':');
            const scheduleTime = parseInt(scheduleHours) * 60 + parseInt(scheduleMinutes); // Jadwal dalam menit

            // Hitung selisih waktu
            let diff = scheduleTime - currentTime;
            if (diff < 0) {
                diff += 24 * 60; // Jika jadwal sudah lewat, tambahkan 24 jam
            }

            // Cari jadwal dengan selisih terkecil
            if (diff < smallestDiff) {
                smallestDiff = diff;
                nextScheduleTime = scheduleTime;
            }
        }

        // Jika ditemukan jadwal berikutnya, jadwalkan pemeriksaan
        if (nextScheduleTime !== null) {
            const delay = smallestDiff * 60 * 1000; // Konversi menit ke milidetik
            console.log(`Next check scheduled in ${smallestDiff} minutes.`);
            setTimeout(checkSchedule, delay);
        }
    }

    // Mulai penjadwalan
    scheduleNextCheck();
</script>

</body>

</html>