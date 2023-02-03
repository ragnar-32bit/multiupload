<?php 
		function multiUpload($dosyalar,$limit = 1,$izinler=null){
			$durum = [];
			// hata var mı yok mu onu teğit ettik
			foreach ($dosyalar["error"] as $key => $error) {
				if($error == 4){
					 $durum["hata"] = "Lütfen bir dosya yükleyiniz";
				}elseif ($error != 0) {
					$durum["hata"][] = $dosyalar["name"][$key]." dosya yüklenirken bir hata oluştu";
				}
			}
			if(!isset($durum["hata"])){
				$izin = $izinler ? $izinler : [
					"image/jpeg",
					"image/png",
					"image/jpg",
					"image/gif"
				];
				//dosyanın uzantısını kontrol ettik
				foreach($dosyalar["type"] as $key => $type){
					if(!in_array($type,$izin)){
						$durum["hata"][] = $dosyalar["name"][$key]. " bu dosyanın formatı uygun değildir.";
					}
				}
				// dosyanın büyüklüğünü kontrol ettik
				if(!isset($durum["hata"])){
					$maxboyut = (1024*1024)*$limit;
					foreach ($dosyalar["size"] as $key => $size) {
						if($size > $maxboyut){
							$durum["hata"][] = $dosyalar["name"][$key]. " bu dosya en fazla $limit mb olabilir.";
						}
					}
				// dosyanın ismini ve yükleneceği yeri seçtik
				if(!isset($durum["hata"])){
					foreach ($dosyalar["tmp_name"] as $key => $tmp_name) {
						$dosyaadi = $dosyalar["name"][$key];
						$upl = move_uploaded_file($tmp_name, "upload/".$dosyaadi);	
						if($upl){
							$durum["dosya"][] = "upload/".$dosyaadi;
						}else{
							$durum["hata"][] = $dosyalar["name"][$key]. " dosyası yüklenemedi";
						}
					}
				}
				}
			}

			return $durum;
		}


	if(isset($_POST["dosyayukle"])){
		$islem = multiUpload($_FILES['dosya']);
		if(isset($islem["dosya"])){
			foreach ($islem["dosya"] as $value) {
				echo "<img style='height:100px' src='$value'/>";
			}
		}
			if(isset($islem["hata"])){
				foreach ($islem["hata"] as $value) {
					echo "<br> $value";
				}
			}elseif(isset($islem["hata"])){
				if(is_array($islem["hata"])){
					foreach ($islem["hata"] as $value) {
					echo "<br> $value";
				}}else{
					echo "<br>".$islem["hata"];
				}
		}
	}
 ?>