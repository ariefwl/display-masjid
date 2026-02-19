document.addEventListener('DOMContentLoaded', async function () {
    try {
        // Ambil data dari database.json
        const response = await fetch('database.json');

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const database = await response.json();

        // console.log(database);

        // inisialisasi waktu sholat
        const prayTimesTune = database.prayTimesTune;

        const jamSholat = new PrayTimes('NWL');
        jamSholat.tune(prayTimesTune);
        const coords = [database.masjid.latitude, database.masjid.longitude];
        const timezone = database.masjid.timeZone;
        const waktuSholat = jamSholat.getTimes(new Date(), coords, timezone);


        // Render Nama Sholat
        await renderNamaSholat();

        async function renderNamaSholat(){
            const prayerOrder = database.prayerOrder;
            const container = document.querySelector('.prayer-names');
            container.innerHTML = '';

            // cek apakah hari ini hari jumat
            const hariIni = new Date().getDay();
            const isJumat = hariIni === 5;

            console.log(prayerOrder);
            prayerOrder.forEach(prayerKey => {
                if (database.prayName[prayerKey]) {
                    const prayerElement = document.createElement('div');
                    prayerElement.className = 'prayer-name';

                    // jika hari ini hari jumat
                    if (isJumat && prayerKey === 'dhuhr') {
                        prayerElement.textContent = "Jumat";
                    } else {
                        prayerElement.textContent = database.prayName[prayerKey];
                    }
                    prayerElement.dataset.prayer = prayerKey; // Tambahkan ini
                    container.appendChild(prayerElement);
                }
            });
        }

        // Render Waktu Sholat
        await renderWaktuSholat(waktuSholat);

        async function renderWaktuSholat(waktuSholat) {
            const prayerTimesContainer = document.querySelector('.prayer-times');
            prayerTimesContainer.innerHTML = '';
            
            // Mapping antara key database dan key PrayTimes
            const prayerTimeMapping = {
                'imsak': 'imsak',
                'fajr': 'fajr',
                'sunrise': 'sunrise',
                'dhuhr': 'dhuhr',
                'asr': 'asr',
                'maghrib': 'maghrib',
                'isha': 'isha'
            };
    
            document.querySelectorAll('.prayer-name').forEach(nameElement => {
                const prayerKey = nameElement.dataset.prayer;
                const prayTimesKey = prayerTimeMapping[prayerKey];
                // console.log(prayerKey);
                if (waktuSholat[prayTimesKey]) {
                    const timeElement = document.createElement('div');
                    timeElement.className = 'prayer-time';
                    timeElement.textContent = formatTime(waktuSholat[prayTimesKey]);
                    prayerTimesContainer.appendChild(timeElement);
                } else {
                    console.warn(`Waktu sholat untuk ${prayerKey} tidak ditemukan`);
                }
            });
        }

        // Format tanggal Hijriyah
        // const hijriDate = new Intl.DateTimeFormat('id-u-ca-islamic', {
        //     day: 'numeric',
        //     month: 'long',
        //     year: 'numeric'
        // }).format(new Date());
        function getHijriDate(){
            const { lat, lng, timeZone, dst, format } = database.masjid;
			const tglHariIni = new Date();
			const adjustDate = new Date(tglHariIni);
			adjustDate.setDate(adjustDate.getDate() - 1); // kurangi 1 hari

			const waktuSholat = prayTimes.getTimes(tglHariIni, [lat, lng], timeZone, dst, format);
			const maghribTime = waktuSholat.maghrib;

			const hijriDate = new Intl.DateTimeFormat('id-u-ca-islamic', {
				day: 'numeric',
				month: 'long',
				year: 'numeric'
			});

			// Buat objek Date untuk waktu Maghrib
			const [maghribHours, maghribMinutes] = maghribTime.split(':');
			const maghribDate = new Date(tglHariIni);
			maghribDate.setHours(parseInt(maghribHours), parseInt(maghribMinutes));

			// Bandingkan waktu sekarang dengan Maghrib
			if (tglHariIni >= maghribDate) {
				adjustDate.setDate(adjustDate.getDate());
			}

			return hijriDate.format(adjustDate);
		}

        // Set tanggal Hijriyah
        document.querySelector('.tanggal-hijriyah').textContent = getHijriDate();

        // update waktu realtime
        updateWaktu();
 
        function updateWaktu() {
            const hariSekarang = new Date();
            const jam = hariSekarang.getHours().toString().padStart(2, '0');
            const menit = hariSekarang.getMinutes().toString().padStart(2, '0');
            const detik = hariSekarang.getSeconds().toString().padStart(2, '0');
    
            // Dapatkan nama hari dalam bahasa Inggris
            const englishDay = hariSekarang.toLocaleDateString('en-US', { weekday: 'long' });
            
            // Ambil nama hari dari database
            const namaHari = database.dayName?.[englishDay];
            // console.log("hari ini : "+ namaHari);

            // Update DOM
            document.querySelector('.hari').textContent = namaHari;
            
            // Format tanggal Masehi
            const optionsMasehi = { day: 'numeric', month: 'long', year: 'numeric' };
            document.querySelector('.tanggal-masehi').textContent = hariSekarang.toLocaleDateString('id-ID', optionsMasehi);
            // Ambil waktu dari database
            document.querySelector('.jam-hour').textContent = hariSekarang.getHours().toString().padStart(2, '0');
            document.querySelector('.jam-minute').textContent = hariSekarang.getMinutes().toString().padStart(2, '0');
            // document.querySelector('.jam').textContent = `${jam}:${menit}:${detik}`;

            
            // Update setiap detik
            setTimeout(updateWaktu, 1000);
        }

        // tampilkan slide text
        slideText();

        async function slideText() {
            const slideText = database.running_text;

            const fullText = slideText.join('  •  ');
            const textElement = document.querySelector('.announcement-text');
            
            // Duplikasi teks untuk efek kontinu
            textElement.textContent = fullText;
            // textElement.dataset.text = fullText; // Untuk pseudo-element
            
            // Hitung durasi animasi berdasarkan panjang teks
            const textWidth = fullText.length * 8; // Estimasi lebar
            const duration = Math.max(30, textWidth / 20); // Minimal 30 detik
            
            textElement.style.animationDuration = `${duration}s`;
        }

        const countDown = {
			hariBesar: {
				'Isra` & Mi`raj': 'Jan 16, 2026',
				'1 Ramadhan 1447 H.': 'Feb 19, 2026',
				'1 Syawal 1447 H.': 'Mar 20, 2026',
				'Idul Adha': 'May 27, 2026',
				'1 Muharam 1448 H.': 'Jun 17, 2026',
                'Maulid Nabi Muhammad SAW.': 'Aug 27, 2026'
			},
			index: 0,
			keys: [],
			start: function () {
				const now = new Date();

				// Filter hanya event yang tanggalnya masih di masa depan
				for (const [key, dateStr] of Object.entries(this.hariBesar)) {
					const date = new Date(dateStr);
					if (date <= now) {
						delete this.hariBesar[key];
					}
				}

				this.keys = Object.keys(this.hariBesar);

				if (this.keys.length === 0) {
					document.getElementById('countDown').innerHTML = 'Tidak ada acara mendatang.';
					return;
				}

				this.showSlide(); // tampil pertama kali
				setInterval(() => this.showSlide(), 10000); // update tiap 10 detik
			},
			showSlide: function () {
				const key = this.keys[this.index];
				const targetDate = new Date(this.hariBesar[key]);
				const now = new Date();
				const distance = targetDate - now;

				let output = `<strong>${key}</strong>   `;
				if (distance > 0) {
					const days = Math.floor(distance / (1000 * 60 * 60 * 24));
					// const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					// const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					// const seconds = Math.floor((distance % (1000 * 60)) / 1000);
					// output += `${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik`;
					output += `${days} hari lagi`;
				} else {
					output += 'Selesai';
				}

				console.log(output);
				document.getElementById('countDown').innerHTML = output;
				this.index = (this.index + 1) % this.keys.length;
			}
		};

		countDown.start();

        let prayerCountdownInterval;

        PrayerCountdown();


        function PrayerCountdown() {
            const prayerOrder = database.prayerOrder;
            // Hentikan interval sebelumnya jika ada
            if (prayerCountdownInterval) {
                clearInterval(prayerCountdownInterval);
            }
            
            function updateNextPrayer() {
                const now = new Date();
                const currentTime = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();
                
                // Cari sholat berikutnya
                let nextPrayer = null;
                let nextPrayerTime = null;
                
                for (const prayer of prayerOrder) {
                    const [hours, minutes] = waktuSholat[prayer].split(':').map(Number);
                    const prayerSeconds = hours * 3600 + minutes * 60;
                    
                    if (prayerSeconds > currentTime) {
                        nextPrayer = prayer;
                        nextPrayerTime = prayerSeconds;
                        break;
                    }
                }
                
                // Jika tidak ada (sudah lewat Isya), gunakan Fajr besok
                if (!nextPrayer) {
                    nextPrayer = 'fajr';
                    const [hours, minutes] = waktuSholat.fajr.split(':').map(Number);
                    nextPrayerTime = hours * 3600 + minutes * 60 + 86400; // +24 jam
                }
                
                return { nextPrayer, nextPrayerTime };
            }

            function updateDisplay() {
                const namaSholat = database.prayName;
                const { nextPrayer, nextPrayerTime } = updateNextPrayer();
                
                const now = new Date();
                const currentTime = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();
                const isJumat = now.getDay() === 5;

                let diff = nextPrayerTime - currentTime;
                
                if (diff < 0) diff += 86400; // Handle midnight
                
                const hours = Math.floor(diff / 3600);
                const minutes = Math.floor((diff % 3600) / 60);
                const seconds = diff % 60;

                // Update tampilan
                if (isJumat && nextPrayer === 'dhuhr') {
                    document.querySelector('.prayerName').textContent = 'Jumat';
                } else {
                    document.querySelector('.prayerName').textContent = namaSholat[nextPrayer]
                }
                
                document.querySelector('.countdown-timer').textContent = 
                    `-${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            // Jalankan segera
            updateDisplay();
            
            // Update setiap detik
            prayerCountdownInterval = setInterval(updateDisplay, 1000);
        }
        
    } catch (error) {
        console.error('Gagal memuat database :',error);
        
    }
});

function formatTime(timeStr) {
    return timeStr.replace(':', ' : ');
}