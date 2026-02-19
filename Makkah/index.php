<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makkah live</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="video-container">
        <iframe id="youtube-video"
        src="https://www.youtube.com/embed/bNY8a2BB5Gc?enablejsapi=1&autoplay=1&mute=1&controls=0" 
        allow="autoplay; fullscreen"
        allowfullscreen>
        </iframe>
    </div>

    <div id="up-container">
        <div class="up-left">
            <div class="hari"></div>
            <div class="tanggal-masehi"></div>
            <div class="tanggal-hijriyah"></div>
        </div>
        
        <div class="up-right">
            <div id="logo"></div>
        </div>
    </div>

	<div id="prayer-countdown-banner">
        <div class="countdown-content">
            <span class="prayerName"></span>
            <span class="countdown-separator"></span>
            <span class="countdown-timer"></span>
        </div>
    </div>

    <div id="countDown"></div>

    <div id="down-container">
        <div class="prayer-schedule">
            <!-- Nama Sholat -->
            <div class="prayer-names"></div>

            <!-- Waktu Sholat -->
            <div class="prayer-times"></div>
        </div>
    </div>

    <div id="announcement-container">
        <!-- Jam di bagian kiri -->
        <div class="announcement-clock">
            <span class="jam-hour"></span>:<span class="jam-minute"></span>
        </div>

        <!-- Running text di bagian kanan -->
        <div class="announcement-text-wrapper">
            <div class="announcement-text"></div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="PrayTimes.js"></script>
    <script>
        // Daftar jam pindah halaman (sesuaikan dengan kebutuhan)
		const schedule = {
			"11:00": "/display/index.php",
			"14:00": "/display/index.php",
			"17:00": "/display/index.php",
			"18:50": "/display/index.php",
			"03:00": "/display/index.php",
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