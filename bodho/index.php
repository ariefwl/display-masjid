<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Panitia Idul Adha 1446 H</title>
	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/bodho/style.css">
</head>

<body>

	<div id="particles-js"></div>

	<!-- <div class="clock">
		<div class="bar-seconds"></div>
		<div class="number-hours"></div>
		<div class="hands-box">
			<div class="hand hours"><i></i></div>
			<div class="hand minutes"><i></i></div>
			<div class="hand seconds"><i></i></div>
		</div>
	</div> -->
	
	<div id="clock"></div>

	<!-- <div class="ornamen"></div> -->
	<div class="carousel-container">
		<div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="10000">
			<div class="carousel-inner">
				<!-- <div class="carousel-item active">
					<img src="/bodho/image/selamat.jpg" class="d-block w-100" alt="Selamat Idul Adha">
				</div> -->
				<div class="carousel-item active">
					<img src="/bodho/image/ramadhan1.jpg" class="d-block w-100" alt="ramadhan 1">
				</div>
				<div class="carousel-item">
					<img src="/bodho/image/ramadhan2.jpg" class="d-block w-100" alt="ramadhan 2">
				</div>
				<div class="carousel-item">
					<img src="/bodho/image/ramadhan3.jpg" class="d-block w-100" alt="ramadhan 3">
				</div>
				<div class="carousel-item">
					<img src="/bodho/image/ramadhan4.jpg" class="d-block w-100" alt="ramadhan 4">
				</div>
				<div class="carousel-item">
					<img src="/bodho/image/ramadhan5.jpg" class="d-block w-100" alt="ramadhan 5">
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap 5 JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="/bodho/particles.js"></script>
	<script src="/bodho/app.js"></script>

	<script>
		// Daftar jam pindah halaman (sesuaikan dengan kebutuhan)
		const schedule = {
			"11:30": "/display/index.php",
			"14:30": "/display/index.php",
			"17:30": "/display/index.php",
			"19:00": "/display/index.php",
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



		// Fungsi Jam
		const numberHours = document.querySelector('.number-hours');
		const barSeconds = document.querySelector('.bar-seconds');

		const numberElement = [];
		const barElement = [];

		console.log("Show Clock");
		// -- angka jam --
		// for (let i = 1; i <= 12; i++) {
		// 	numberElement.push(
		// 		`<span style="--index: ${i};"><p>${i}</p></span>`
		// 	);
		// }	
		
		// numberHours.insertAdjacentHTML('afterbegin', numberElement.join(''));
		// console.log(numberElement);

		// garis detik
		for (let i = 1; i <= 60; i++) {
			barElement.push(
				`<span style="--index: ${i};"><p></p></span>`
			);
		}	
		
		// barSeconds.insertAdjacentHTML('afterbegin', barElement.join(''));

		const handHours = document.querySelector('.hand.hours');
		const handMinutes = document.querySelector('.hand.minutes');
		const handSeconds = document.querySelector('.hand.seconds');

		function getCurrentTime(){
			let date = new Date();
			let hours = date.getHours();
			let minutes = date.getMinutes();
			let seconds = date.getSeconds();

			let jam = date.getHours().toString().padStart(2, '0');
			let menit = date.getMinutes().toString().padStart(2, '0');
			let detik = date.getSeconds().toString().padStart(2, '0');

    		let jamSekarang = jam + ":" + menit;

			// handHours.style.transform = `rotate(${hours * 30 + minutes * 0.5}deg)`;
			// handMinutes.style.transform = `rotate(${minutes * 6}deg)`;
			// handSeconds.style.transform = `rotate(${seconds * 6}deg)`;

			console.log('Jam Sekarang : ' + jamSekarang);
			// $('#clock').html(jamSekarang);
			document.getElementById('clock').innerHTML = '<i class="fa-regular fa-clock"></i> ' + jamSekarang;
		}
		
		getCurrentTime();
		setInterval(getCurrentTime, 1000);
		

	</script>

</body>

</html>