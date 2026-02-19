<?php
	// var_dump(PHP_OS);
	// die;
	$file	= '../db/database.json';
	if (!file_exists($file)){
		echo "<h1>Jalankan admin terlebih dahulu</h1>";
		die;
	}
	$json 	= file_get_contents($file);
	$db		= json_decode($json, true);
	$showDb	= $db;
	unset($showDb['akses']);
	
	$info_timer			= $db['timer']['info'] 		* 1000;	//detik
	$wallpaper_timer	= $db['timer']['wallpaper'] * 1000;	
	$adzan_timer		= $db['timer']['adzan'] 	* 1000 * 60; //menit
	// $iqomah_timer		= $db['timer']['iqomah'] 	* 1000 * 60;
	$sholat_timer		= $db['timer']['sholat'] 	* 1000 * 60;
	
	//optional
	$khutbah_jumat		= $db['jumat']['duration'] 	* 1000 * 60;
	$sholat_tarawih		= $db['tarawih']['duration'] 	* 1000 * 60;
	
	//Logo
	// nge trik ==> kalo replace file, di display logo yang lama masih kesimpen di cache ==> solusi ganti logo ganti nama file 
	$dirLogo	= 'logo/';
	$filesLogo	= array_diff(scandir($dirLogo),array('.','..','Thumbs.db'));
	$filesLogo	= array_values($filesLogo);//re index
	$logo		= $filesLogo[0];
	
	
	$dir	= 'wallpaper/';
	$files	= array_diff(scandir($dir),array('.','..','Thumbs.db'));
	$wallpaper	= '';
	$i	= 0;
	foreach($files as $v){
		$active	= $i==0?'active':'';
		$wallpaper	.= '<div class="item slides '.$active.'"><div style="background-image: url(wallpaper/'.$v.');"></div></div>';
		$i++;
	}
	// print_r($files);die;
?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masjid Al - Istiqomah</title>
    <link rel="icon" type="image/png" href="../icon.png"/>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div id="preloader">
      <div id="status">&nbsp;</div>
    </div> 
	
	
	<div id="full-screen-clock" style="display:none"></div>
	<div id="count-down" class="full-screen" style="display:none">
		<div class="counter">
			<h1>COUNTER</h1>
			<div class="hh">00<span>JAM</span></div>
			<div class="ii">00<span>MENIT</span></div>
			<div class="ss">00<span>DETIK</span></div>
		</div>
	</div>
	<div id="display-adzan" class="full-screen" style="display:none"><div></div></div>
	<div id="display-sholat" class="full-screen" style="display:none"></div>
	<div id="display-khutbah" class="full-screen" style="display:none"><div></div></div>
	
	
	<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="<?=$wallpaper_timer?>">
	  <!-- Overlay -->
	  <div class="overlay"></div>
	  <!-- Wrapper for slides -->
	  <div class="carousel-inner"><?=$wallpaper?></div> 
	</div>
	
	
	<div id="left-container">
		<div id="jam"></div>
		<div id="tgl"></div>
		<div id="hij"></div>
		<div id="jadwal"></div>
	</div>
	
	<div id="right-counter" style="display:none">
		<div class="counter">
			<h1>COUNTER</h1>
			<div class="hh">19<span>JAM</span></div>
			<div class="ii">25<span>MENIT</span></div>
			<div class="ss">45<span>DETIK</span></div>
		</div>
	</div>
	<div id="right-container">
		<a href="../Makkah/index.php">
			 <div id="logo"></div>
		</a>
		<div id="countSyawal"></div>
		<!-- <div style="color: yellow; font-size: 5vh; font-weight: bold;" id="hijriyah"></div> -->
		<div id="quote">
			<div class="carousel quote-carousel slide" data-ride="carousel" data-interval="<?=$info_timer?>" data-pause="null">
				<div class="carousel-inner">
					<?php 
					$i=0;
					foreach($db['info'] as $k => $v){
						if($v[3]){
							echo '
							<div class="item slides '.($i==0?'active':'').'">
							<div class="hero">        
								<hgroup>
									<div class="text1">'.htmlentities($v[0]).'</div>        
									<div class="text2">'.nl2br(htmlentities($v[1])).'</div>        
									<div class="text3">'.htmlentities($v[2]).'</div>
								</hgroup>
							</div>
							</div>
							';
							$i++;
						}
					}
					?>
				</div> 
			</div>
		</div>
		
		<div id="countDown"></div>
		<div id="running-text">
			<div class="item">
				<!-- <div class="text"> -->
				<marquee>
					<?php 
						foreach($db['running_text'] as $k => $v){
							echo '<i class="fa fa-square-o" aria-hidden="true"></i> '.htmlentities($v);
						}
						// $ip 	= gethostbyname(php_uname('n'));	// PHP < 5.3.0
						// $ip 	= gethostbyname(gethostname());		// PHP >= 5.3.0 ==> di linux keluar 127.0.0.1
						// if(PHP_OS=='Linux'){
						// 	//raspi 3
						// 	// $command="/sbin/ifconfig wlan0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";//raspi pake wlan0 jadi hotspot
						// 	// $ip = exec ($command);
							
						// 	//raspi 4
						// 	$command="/sbin/ifconfig wlan0 | grep 'inet '| cut -d 't' -f2 | cut -d 'n' -f1 | awk '{ print $1}'";//raspi pake wlan0 jadi hotspot
						// 	$ip = trim(exec ($command));
						// }
						// if($db['akses']['pass']=='admin'){
						// 	echo '<i class="fa fa-square-o" aria-hidden="true"></i> Konek ke wifi (SSID: DisplayMasjid, password: 12345678)';
						// 	echo '<i class="fa fa-square-o" aria-hidden="true"></i> Alamat admin http://'.$ip.'/';
						// 	echo '<i class="fa fa-square-o" aria-hidden="true"></i> Default akses user : admin, password : admin';
						// 	echo '<i class="fa fa-square-o" aria-hidden="true"></i> Silakan mengganti password admin untuk menghilangkan tulisan ini';
						// }
					?>
				</marquee>
				<!-- </div> -->
			</div>
		</div>
	</div>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/PrayTimes.js"></script>
    <script src="js/jquery.marquee.js"></script>
    <script>
		//PrayTimes initialize
		var format 			= '24h';
		<?php
			echo "var lat 		= ".$db['setting']['latitude'].";\n";
			echo "var lng 		= ".$db['setting']['longitude'].";\n";
			echo "var timeZone 	= ".$db['setting']['timeZone'].";\n";
			echo "var dst 		= ".$db['setting']['dst'].";\n";
			
			
			$prayTimesAdjust	= [];
			if($db['prayTimesMethod']=='0'){
				foreach($db['prayTimesAdjust'] as $k => $v){
					if($v!='') $prayTimesAdjust[$k]=$v;
				}
				echo "var prayTimesAdjust =	$.parseJSON('".stripslashes(str_replace("`","\\`",json_encode($prayTimesAdjust)))."');\n";
				// echo "console.log(prayTimesAdjust);\n";
				echo "prayTimes.adjust(prayTimesAdjust);\n"; 
			}
			else {
				echo "prayTimes.setMethod('".$db['prayTimesMethod']."');\n";
			}
			
			$prayTimesTune	= [];
			foreach($db['prayTimesTune'] as $k => $v){
				if($v!='0') $prayTimesTune[$k]=$v;
			}
			if(count($prayTimesTune)>0){
				echo "var prayTimesTune =	$.parseJSON('".stripslashes(str_replace("`","\\`",json_encode($prayTimesTune)))."');\n";
				// echo "console.log(prayTimesTune);\n";
				echo "prayTimes.tune(prayTimesTune);\n"; 
			}
		?>
		
		
		
		//Baris ini ke bawah jika inget nanti pindah ke file terpisah biar rapi......
		
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

		var app	={
			db	: $.parseJSON(`<?=stripslashes(str_replace("`","\\`",json_encode($showDb)))?>`),
			cekDb	: false,
			tglHariIni		: '',
			tglBesok		: '',
			jadwalHariIni	: {},
			jadwalBesok		: {},
			timer			: false,
			// waitAdzanTimer	: false,	// Display countdown sebelum adzan
			adzanTimer		: false,	// Display adzan
			countDownTimer	: false,	// Display countdown iqomah
			sholatTimer		: false,	// Display sholat
			khutbahTimer	: false,	// Display khutbah
			nextPrayCount	: 0,		// start next pray count-down
			// nextPrayTimer	: false,	// Display countdown ke sholat selanjutnya
			fajr	: '',
			sunrise	: '',
			dhuhr	: '',
			asr		: '',
			maghrib	: '',
			isha	: '',
			imsak	: '',
			dhuha	: '',
			sholawat : new Audio('audio/tarhim.mp3'),
			audio	: new Audio('img/beep.mp3'),
			schedule: 	{
							"05:00": "/Makkah/index.php",
							"12:20": "/Makkah/index.php",
							"15:35": "/Makkah/index.php",
							"18:30": "/Makkah/index.php",
							"19:35": "/Makkah/index.php",
						},
			
			initialize	: function(){
				app.timer	= setInterval(function(){app.cekPerDetik()},1000);
				// Jalankan setiap 1 menit
				// app.timer 	= setInterval(showRekap, 60000);
				$('#preloader').delay(350).fadeOut('slow');
				
				app.setSholawatSebelumSholat();
				// app.showRekap();
				app.scheduleNextCheck();
				// app.playSholawat();
				// let testTime	= moment().add(8,'seconds');
				// app.runRightCountDown(testTime,'Menuju dzuhur');
				// app.runFullCountDown(testTime,'iqomah',true);
				// app.runFullCountDown(testTime,'TEST COUNTER',false);
				// app.showDisplayAdzan('Dzuhur');
				// app.showDisplayKhutbah();
				// app.countDownSyawal();
				// app.refresPage();
			},
			cekPerDetik	: function(){
				if(!app.tglHariIni || moment().format('YYYY-MM-DD') != moment(app.tglHariIni).format('YYYY-MM-DD')){
					app.tglHariIni	= moment();
					app.tglBesok 	= moment().add(1,'days');
					// console.log(app.tglHariIni);
					// console.log(app.tglBesok);
					app.jadwalHariIni	= app.getJadwal(moment(app.tglHariIni).toDate());
					app.jadwalBesok		= app.getJadwal(moment(app.tglBesok).toDate());
					// console.log(app.jadwalHariIni.asr);
					// console.log(app.jadwalBesok);
					app.fajr	= moment(app.jadwalHariIni.fajr,'HH:mm:ss');
					app.sunrise	= moment(app.jadwalHariIni.sunrise,'HH:mm');
					// app.dhuha	= moment(app.sunrise).add(20, 'minutes');
					app.dhuhr	= moment(app.jadwalHariIni.dhuhr,'HH:mm');
					app.asr		= moment(app.jadwalHariIni.asr,'HH:mm');
					app.maghrib	= moment(app.jadwalHariIni.maghrib,'HH:mm');
					app.isha	= moment(app.jadwalHariIni.isha,'HH:mm');
					// console.log('fajr : '+app.fajr.format('YYYY-MM-DD HH:mm:ss'));
					// console.log('syuruq : '+app.sunrise.format('YYYY-MM-DD HH:mm:ss'));
					// console.log('dhuhr : '+app.dhuhr.format('YYYY-MM-DD HH:mm:ss'));
					// console.log('asr : '+app.asr.format('YYYY-MM-DD HH:mm:ss'));
					// console.log('maghrib : '+app.maghrib.format('YYYY-MM-DD HH:mm:ss'));
					// console.log('isha : '+app.isha.format('YYYY-MM-DD HH:mm:ss'));
					// console.log('Subuh : '+app.fajr);
					// console.log('Dhuha : '+app.dhuha);
				}
				app.showJadwal();
				app.displaySchedule();
				app.showRekap();
				// app.showCountDownNextPray();
				// app.runRightCountDown(app.dhuhr,'Dzuhur');
				
				$.ajax({  
					type    : "POST",  
					url     : "../proses.php",
					dataType: "json",
					data    : {id:'changeDbCheck'}
				}).done(function(dt){
					// console.log(dt.data);
					if(app.cekDb==false) app.cekDb = dt.data;
					else if(app.cekDb !== dt.data) location.reload();
				}).fail(function(msg){
					console.log(msg);
				});
				// console.log('interval-1000');
			},
			playSholawat(){
				// const durasiSholawat = 365400;
				app.sholawat.play().then(() => {
					console.log('Memainkan audio sholawat pertama...');
					// setTimeout(() => {
					// 	app.sholawat.currentTime = 0;
					// 	app.sholawat.play().then(() => {
					// 		console.log('Memainkan audio sholawat kedua...');
					// 	}).catch(error => {
					// 		console.log('Gagal memutar sholawat kedua....', error);
					// 	});
					// }, durasiSholawat);
				}).catch(error => {
					console.error('Gagal memutar audio:', error);
				});
				
				// Pastikan audio sudah dimuat sebelum diputar
				app.sholawat.addEventListener('canplaythrough', function() {
					console.log('Audio siap diputar.');
				});
			},
			// Fungsi untuk mengatur timer sholawat sebelum setiap waktu sholat
			setSholawatSebelumSholat: function() {
				const tglHariIni = new Date();
				const waktuSholat = prayTimes.getTimes(tglHariIni, [lat, lng], timeZone, dst, format);
				// console.log(waktuSholat);

				// Daftar waktu sholat yang akan diproses
				const sholatTimes = {
					"Subuh": waktuSholat.fajr,
					"Dzuhur": waktuSholat.dhuhr,
					"Ashar": waktuSholat.asr,
					"Maghrib": waktuSholat.maghrib,
					"Isya": waktuSholat.isha,
				};

				let semuaSholatLewat = true; // Flag untuk menandai apakah semua sholat sudah lewat

				// Loop melalui setiap waktu sholat
				for (const [sholatName, sholatTime] of Object.entries(sholatTimes)) {
					// Konversi waktu sholat ke objek Date
					const sholatDate = new Date(tglHariIni.toDateString() + ' ' + sholatTime);

					// Hitung waktu 15 menit sebelum sholat
					const sholawatTime = new Date(sholatDate.getTime() - 15 * 60000);

					const now = new Date();
					const delay = sholawatTime.getTime() - now.getTime();

					if (delay > 0) {
						console.log(`Audio sholawat akan dimainkan 15 menit sebelum ${sholatName} pada:`, sholawatTime);
						setTimeout(app.playSholawat, delay);
						semuaSholatLewat = false; // Masih ada sholat yang belum lewat
					} else {
						console.log(`Waktu sholawat sebelum ${sholatName} sudah lewat hari ini.`);
					}
				}

				// Jika semua sholat sudah lewat, jadwalkan ulang untuk hari berikutnya
				if (semuaSholatLewat) {
					console.log('Semua waktu sholat sudah lewat. Menjadwalkan ulang untuk hari berikutnya...');
					scheduleNextDay();
				}
			},
			jadwalSholawatBesok: function(){
				const now = new Date();
				const tengahMalam = new Date(now);
				tengahMalam.setHours(24, 0, 0, 0); // Set ke tengah malam

				const delay = tengahMalam.getTime() - now.getTime(); // Hitung selisih waktu sampai tengah malam

				console.log(`Menjadwalkan ulang pada tengah malam: ${tengahMalam}`);
				setTimeout(() => {
					setSholawatBeforeSholat(); // Jalankan fungsi setelah tengah malam
				}, delay);
			},
			getJadwal	: function(jadwalDate){
				let times = prayTimes.getTimes(jadwalDate, [lat, lng], timeZone, dst, format);
				// console.log(times);

				// Konversi waktu sunrise ke dalam format Date
				let sunriseTime = moment(times.sunrise, "HH:mm"); 

				// Tambahkan 20 menit untuk waktu Dhuha
				let dhuhaTime = sunriseTime.add(15, "minutes").format("HH:mm"); 

				// Tambahkan waktu Dhuha ke dalam objek times
				times.dhuha = dhuhaTime;

				return times;
			},
			refresPage : function(){
				const oneMinutes = 60000;
				function refresh(){
					location.reload();
				}
				setInterval(refresh, oneMinutes);
			},
			showJadwal	: function(){
				// console.log(app.db.prayName)
				// let jamSekarang	= moment().add(9,'months');
				let jamSekarang	= moment();
				//+5 menit baru berubah yang aktif (misal sekarang jam dzuhur, di jadwal setelah 5 menit baru berubah yang ashar yang aktif)
				let jamDelay	= moment().subtract(5,'minutes');
				let jadwal	= '';
				let hari	= app.db.dayName[jamSekarang.format("dddd")];	//pastikan moment js pake standart inggris (default) ==> jangan pindah locale
				let bulan	= app.db.monthName[jamSekarang.format("MMMM")];
				// console.log(jamDelay.format('YYYY-MM-DD HH:mm:ss'));
				
				// $('#tgl').html(moment().format("dddd, DD MMMM YYYY"));
				$('#jam').html(jamSekarang.format("HH.mm[<div>]ss[</div>]"));
				$('#tgl').html(jamSekarang.format("["+hari+"], DD ["+bulan+"] YYYY"));
				
				if($('.full-screen').is(":visible")){
					$('#full-screen-clock').html(jamSekarang.format("[<i class='fa fa-clock-o''></i>&nbsp;&nbsp;]HH:mm"));
					$('#full-screen-clock').slideDown();
					console.log('show');
				}
				else $('#full-screen-clock').slideUp();
				
				let jadwalDipake = app.jadwalHariIni;
				let jadwalPlusIcon	= '';
				//jika diatasa isya' pake jadwal besok
				
				// console.log(jamSekarang.format('YYYY-MM-DD HH:mm:ss'));
				if(jamDelay > app.isha){
					jadwalDipakeapp	= app.jadwalBesok;
					jadwalPlusIcon	= '<span><i class="fa fa-plus" aria-hidden="true"></i></span>';
					// console.log('besok');
				}
				$.each(app.db.prayName, function(k,v) {
					// console.log(jamDelay.format('YYYY-MM-DD HH:mm:ss'));
					// console.log('Waktu dhuha : ' + app.dhuha);
					let css= '';
					if		(k == 'isha' 	&& jamDelay < app.isha		&& jamDelay > app.maghrib) 	css= 'active';
					else if	(k == 'maghrib' && jamDelay < app.maghrib	&& jamDelay > app.asr) 		css= 'active';
					else if	(k == 'asr' 	&& jamDelay < app.asr		&& jamDelay > app.dhuhr) 	css= 'active';
					else if	(k == 'dhuhr' 	&& jamDelay < app.dhuhr		&& jamDelay > app.fajr) 	css= 'active';
					else if	(k == 'dhuha'	&& jamDelay < app.dhuha		&& jamDelay > app.sunrise)	css= 'active';
					// else if	(k == 'sunrise'	&& jamDelay < app.sunrise	&& jamDelay > app.fajr)	css= 'active';
					else if	(k == 'fajr'	&& (jamDelay < app.fajr		|| jamDelay > app.isha))	css= 'active';//diatas isha dan sebelum subuh (beda hari)
					jadwal += '<div class="row '+css+'"><div class="col-xs-5">'+v+'</div><div class="col-xs-7">'+jadwalDipake[k] + jadwalPlusIcon + '</div></div>';
				});
				$('#jadwal').html(jadwal);
			},
			countDownSyawal : function(){
				var countDownDate = new Date("Jun 05, 2025 17:31:00").getTime();
				let syawal = '';

				var x = setInterval(function () {
					var now = new Date().getTime();

					var distance = countDownDate - now;

					var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					var hours = Math.floor(
					(distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
					);
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);

					var textDays = document.getElementById("days");
					var textHours = document.getElementById("hours");
					var textMinutes = document.getElementById("minutes");
					var textSeconds = document.getElementById("seconds");

					textDays.innerHTML = days < 10 ? "0" + days : days;
					textHours.innerHTML = hours < 10 ? "0" + hours : hours;
					textMinutes.innerHTML = minutes < 10 ? "0" + minutes : minutes;
					textSeconds.innerHTML = seconds < 10 ? "0" + seconds : seconds;

					if (distance < 0) {
						clearInterval(x);
						$('#syawal').fadeOut();
						// $('#countRamadhan').html('<div id="ramadhan">Marhaban Ya Ramadhan 1446 H.</div>');
						return;
					}
				}, 1000);
				syawal += '<div class="countdown">' +
				            '<div class="time"><span id="days">00</span><span>hari</span></div>' +
							'<div class="semicolon">:</div>' +
				            '<div class="time"><span id="hours">00</span><span>jam</span></div>' +
							'<div class="semicolon">:</div>' +
				            '<div class="time"><span id="minutes">00</span><span>menit</span></div>' +
							'<div class="semicolon">:</div>' +
				            '<div class="time"><span id="seconds">00</span><span>detik</span></div>' +
				            '</div>' +
							'<div id="syawal">Menuju 10 Dzulhijjah 1446 H.</div>';
				$('#countSyawal').html(syawal);
			},
			displaySchedule: function(){
				// console.log(app.getNextPray());
				let waitAdzan		= moment().add(app.db.timer.wait_adzan,'minutes').format('YYYY-MM-DD HH:mm:ss');
				let jamSekarang		= moment().format('YYYY-MM-DD HH:mm:ss');
				
				// console.log(moment().add(5,'days').format('dddd'));
				// console.log(waitAdzan);
				// console.log(app.dhuhr.format('YYYY-MM-DD HH:mm:ss'));
				
				$.each(app.db.prayName, function(k,v) {
					//Normal 	: waitAdzanCountDown-adzan-iqomah-sholat-nextPrayCountDown
					//jumat 	: waitAdzanCountDown-adzan-khutbah-sholat-nextPrayCountDown
					//tarawih 	: waitAdzanCountDown-adzan-iqomah-sholat-isya-Tarawih(hanya durasi tarawih)-nextPrayCountDown
					
					let t			= moment(app[k]);//bikin variable baru t ==> jika ditulis let t	= app[k]; ==> jika di tambah / kurang, variable app[k] ikut berubah
					let jadwal		= t.format('YYYY-MM-DD HH:mm:ss');
					let stIqomah	= t.add(app.db.timer.adzan,'minutes').format('YYYY-MM-DD HH:mm:ss');
					let enIqomah	= moment(stIqomah,'YYYY-MM-DD HH:mm:ss').add(app.db.iqomah[k],'minutes')
					
					
					
					
					// console.log('Now-------------- '+jamSekarang);
					// console.log('time '+v+' : '+jadwal);
					// console.log('waitAdzan '+v+' : '+waitAdzan);
					// console.log('st iqomah '+v+' : '+stIqomah);
					// console.log('en iqomah '+v+' : '+enIqomah.format('YYYY-MM-DD HH:mm:ss'));
					if(waitAdzan == jadwal)				app.runRightCountDown(app[k],'Menuju '+v);	// CountDown sebelum adzan
					else if(jadwal == jamSekarang)		app.showDisplayAdzan(v);		// Display adzan
					else if(stIqomah == jamSekarang){
						if(moment().format('dddd')=='Friday' && app.db.jumat.active && k=='dhuhr'){
							//jumatan aktif skip iqomah --> waitAdzanCountDown-adzan-khutbah-sholat-nextPrayCountDown
							app.showDisplayKhutbah();
						}
						else
							app.runFullCountDown(enIqomah,'IQOMAH',true);	// CountDown iqomah
					}
				});
				
		
				// let jamSekarang	= moment().add(5,'minutes');
				// if (!app.countDownTimer) {
					// app.runFullCountDown(ja"dhuha":"Dhuha",mSekarang,'IQOMAH');
				// }
			},
			getNextPray	: function(){
				let jamSekarang		= moment();
				let nextPray		= 'fajr';
				let jadwalDipake 	= false;
				if(jamSekarang > app.isha){
					jadwalDipake	= moment(app.jadwalBesok[nextPray],'HH:mm').add(1,'Day');
					console.log('jadwal besok');
				}
				else{
					$.each(app.db.prayName, function(k,v){
						if(jamSekarang < app[k]){
							nextPray	= k;
							return false;
						}
					});
					jadwalDipake	= moment(app.jadwalHariIni[nextPray],'HH:mm');
				}
				// console.log(jadwalDipake);
				return {
					'pray'	: nextPray,
					'date'	: jadwalDipake
				};
			},
			
			showCountDownNextPray	: function(){
				// $('#right-counter').html();
				let nextPray		= app.getNextPray();
				if (app.countDownTimer) return;//timer masih jalan
				app.nextPrayCount	= 0;
				console.log(moment(nextPray['date']).format('YYYY-MM-DD HH:mm:ss'));
				app.countDownTimer	= setInterval(function(){
					let t	= app.countDownCalculate(nextPray.date);
					
					$('#right-counter .counter>h1').html('Menuju '+app.db.prayName[nextPray.pray]);
					$('#right-counter .counter>.hh').html(t.hours+'<span>'+app.db.timeName.Hours+'</span>');
					$('#right-counter .counter>.ii').html(t.minutes+'<span>'+app.db.timeName.Minutes+'</span>');
					$('#right-counter .counter>.ss').html(t.seconds+'<span>'+app.db.timeName.Seconds+'</span>');
					
					$('#right-counter').slideDown();
					$('#quote').hide();
					
					app.nextPrayCount++;
					if (app.nextPrayCount >= 30) { // 30 detik show counter
						clearInterval(app.countDownTimer);
						app.countDownTimer	= false;
						$('#right-counter').fadeOut();
						$('#quote').fadeIn();
						// document.getElementById("demo").innerHTML = "EXPIRED";
					}
				},1000);
			},
			showDisplayAdzan	: function(prayName){
				if (!app.adzanTimer){
					$('#display-adzan>div').text(prayName);
					$('#display-adzan').show();
					app.adzanTimer	= setTimeout(function(){
						$('#display-adzan').fadeOut();
						app.adzanTimer	= false;
					},(app.db.timer.adzan * 60 * 1000)+1500);// to menit + 1.5 detik (remove jeda dengan iqomah)
				}
			},
			showDisplayKhutbah	: function(){
				if (!app.khutbahTimer){
					$('#display-khutbah>div').text(app.db.jumat.text);
					$('#display-khutbah').show();
					app.khutbahTimer	= setTimeout(function(){
						app.khutbahTimer	= false;
						app.showDisplaySholat();
						$('#display-khutbah').fadeOut();
					},app.db.jumat.duration * 60 * 1000);// to menit
				}
			},
			showDisplaySholat	: function(){
				if (!app.khutbahTimer){
					//cek tarawih
					let jamSekarang		= moment();
					let duration		= (jamSekarang > app.isha && app.db.tarawih.active)?app.db.tarawih.duration:app.db.timer.sholat;
					$('#display-sholat').show();
					app.khutbahTimer	= setTimeout(function(){
						//console.log("Timer selesai, menghilangkan #display-sholat");
						$('#display-sholat').fadeOut();
						app.khutbahTimer	= false;
						app.showCountDownNextPray();
					},duration * 60 * 1000);// to menit
				}
			},
			runFullCountDown: function(jam,title,runDisplaySholat){
				// clearInterval(app.countDownTimer);
				if (app.countDownTimer) return;//timer masih jalan
				app.countDownTimer	= setInterval(function(){
					let t	= app.countDownCalculate(jam);
					
					$('#count-down .counter>h1').html(title);
					$('#count-down .counter>.hh').html(t.hours+'<span>'+app.db.timeName.Hours+'</span>');
					$('#count-down .counter>.ii').html(t.minutes+'<span>'+app.db.timeName.Minutes+'</span>');
					$('#count-down .counter>.ss').html(t.seconds+'<span>'+app.db.timeName.Seconds+'</span>');
					
					$('#count-down').fadeIn();
					if(t.distance==5){
						app.audio.play().then( () => {
						  // already allowed
						}).catch( () => {
							console.log('Agar beep bunyi ==> permission chrome : sound harus enable');
						});
						// audio.play();
					}
					if (t.distance < 1) {
						clearInterval(app.countDownTimer);
						app.countDownTimer	= false;
						$('#count-down').fadeOut();
						if(runDisplaySholat){
							app.showDisplaySholat();
						}
						// document.getElementById("demo").innerHTML = "EXPIRED";
					}
				},1000);
			},
			runRightCountDown	: function(jam,title){
				// $('#right-counter').html();
				if (app.countDownTimer) return;//timer masih jalan
				app.countDownTimer	= setInterval(function(){
					let t	= app.countDownCalculate(jam);
					
					$('#right-counter .counter>h1').html(title);
					$('#right-counter .counter>.hh').html(t.hours+'<span>'+app.db.timeName.Hours+'</span>');
					$('#right-counter .counter>.ii').html(t.minutes+'<span>'+app.db.timeName.Minutes+'</span>');
					$('#right-counter .counter>.ss').html(t.seconds+'<span>'+app.db.timeName.Seconds+'</span>');
					
					$('#right-counter').slideDown();
					$('#quote').hide();
					
					if (t.distance < 1) {
						clearInterval(app.countDownTimer);
						app.countDownTimer	= false;
						$('#right-counter').fadeOut();
						$('#quote').fadeIn();
						// document.getElementById("demo").innerHTML = "EXPIRED";
					}
				},1000);
			},
			countDownCalculate(jam){
				let jamSekarang	= moment();//.subtract(2,'seconds');
				// console.log(jam.format('YYYY-MM-DD HH:mm:ss SSS'));
				// console.log(jamSekarang.format('YYYY-MM-DD HH:mm:ss SSS'));
				// --> jam.diff(jamSekarang, 'seconds') --> convert integer tanpa pembulatan (pembulatan ke bawah)
				let distance	= Math.round(jam.diff(jamSekarang, 'seconds', true)) ;
				// console.log(distance);
				let hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
				let minutes = Math.floor((distance % (60 * 60)) / 60);
				let seconds = Math.floor((distance % 60));
				hours	= (hours>=0		&& hours<10)	?'0'+hours:hours;
				minutes	= (minutes>=0	&& minutes<10)	?'0'+minutes:minutes;
				seconds	= (seconds>=0	&& seconds<10)	?'0'+seconds:seconds;
				// console.log(hours);
				return	{
					'distance'	: distance,
					'hours'		: hours,
					'minutes'	: minutes,
					'seconds'	: seconds
				};
			},			
			showRekap : function(){
				const now = new Date();
				const hours = now.getHours().toString().padStart(2, '0');
				const minutes = now.getMinutes().toString().padStart(2, '0');
				const currentTime = `${hours}:${minutes}`;

				// Jika waktu saat ini cocok dengan jadwal, lakukan redirect
				if (this.schedule[currentTime]) {
					console.log(`Redirecting to ${this.schedule[currentTime]} at ${currentTime}`);
					window.location.href = this.schedule[currentTime]; // Redirect ke halaman tujuan
					return; // Berhenti setelah redirect
				}

				// Jika tidak, jadwalkan pemeriksaan berikutnya
				this.scheduleNextCheck();
			},
			// Fungsi untuk menjadwalkan pemeriksaan berikutnya
			scheduleNextCheck: function() {
				const now = new Date();
				const currentTime = now.getHours() * 60 + now.getMinutes(); // Waktu saat ini dalam menit

				// Cari jadwal berikutnya
				let nextScheduleTime = null;
				let smallestDiff = Infinity;

				for (const time in this.schedule) {
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
					setTimeout(() => this.showRekap(), delay);
				}
			}
		}
		app.initialize();

		function getHijriDate(){
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
				adjustDate.setDate(adjustDate.getDate() + 1);
			}

			return hijriDate.format(adjustDate);
		}

		document.addEventListener('DOMContentLoaded', function() {
			document.getElementById('hij').textContent = getHijriDate();
		});
	</script>
</body>
</html>
