<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Depo Stok Takip Sistemi</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Depo Stok Takip Sistemi</h1>

	<div id="body">
		<p>Depo takip sistemi API si ile ilgili aşağıda yapabileceğiniz işlemlerin listesi verilmiştir.</p>

		<h4>Kullanıcı işlemleri ile ilgili bilgiler:</h4>
		<p>Kullanıcı listesini almak istiyorsanız url adresi:</p>
		<code><?php echo base_url(); ?>kullanicilar</code>

		<p>Sisteme yeni kullanıcı eklemek için  adres:</p>
		<code><?php echo base_url(); ?>kullaniciekle</code>
		
		<p>Aşağıdaki json tipindeki verinin ilgili alanlarını doldurarak sunucuya postlamaniz yeterlidir.</p>
		<code>{"user_name":"Eklenecek Kullanici","groups_id":"kullanıcı grubu idsi","created_id":"0"}</code>
		<small>Dikkat: yeni kullanıcı eklerken created_id alanını temsili olarak doldurabilirsiniz.</small>
		
		<p>Kullanıcı verisi güncellemek için url adres:</p>
		<code><?php echo base_url(); ?>kullaniciduzenle</code>
		
		<p>Aşağıdaki json tipindeki verinin ilgili alanlarını doldurarak sunucuya postlamaniz yeterlidir.</p>
		<code>{"users_id":"duzenlenecek_user_id","user_name":"yeni veya eski kullanıcı adı","groups_id":"eklenecek grup id","modified_id":"güncelleyen_kullanıcı_id"}</code>

		<p>Kullanıcı verisi silmek için url adres:</p>
		<code><?php echo base_url(); ?>kullanicisil</code>
		
		<p>Aşağıdaki json tipindeki verinin ilgili alanlarını doldurarak sunucuya postlamaniz yeterlidir.</p>
		<code>{"users_id":"silinecek_userid","deleted_id":"silecek_userid"}</code>
		
		<h4>Kullanıcı Grubu işlemleri ile ilgili bilgiler:</h4>
		<p>Kullanıcı Grupları listesini almak istiyorsanız url adresi:</p>
		<code><?php echo base_url(); ?>kullanicigruplari</code>

		<p>Kullanıcı Grubu eklemek için adres :</p>
		<code><?php echo base_url(); ?>kullanicigruplari/ekle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"usergroup_name":"Eklenecek_Grup_Adi","created_userid":"ekleyecek_user_id"}</code>

		<p>Kullanıcı grubu düzenlemek için Adres :</p>
		<code><?php echo base_url(); ?>kullanicigruplari/guncelle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"groups_id":"duzenlenecek_id","usergroup_name":"yeni_grub_ismi","modifield_userid":"duzenleyecek_user_id"}</code>
		
		<p>Kullanıcı grubu silmek için adres :</p>
		<code><?php echo base_url(); ?>kullanicigruplari/sil</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"groups_id":"silinecek_id","deleted_userid":"silen_user_id"}</code>

		<h4>Depo işlemleri ile ilgili bilgiler:</h4>
		<p>Depo listesini görmek için url adresi :</p>
		<code><?php echo base_url(); ?>depolar</code>
		
		<p>Yeni depo eklemek için url adresi :</p>
		<code><?php echo base_url(); ?>depolar/ekle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"stores_name":"Eklenecek Depo","created_id":"olusturan_user_id"}</code>

		<p>Depo düzenlemek için url adresi :</p>
		<code><?php echo base_url(); ?>depolar/guncelle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"stores_id":"duzenlenecek_id","stores_name":"Yeni_depo_ismi","modified_id":"duzenleyen_user_id"}</code>

		<p>Depo silmek için url adresi :</p>
		<code><?php echo base_url(); ?>depolar/sil</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"stores_id":"silinecek_id","deleted_id":"silen_user_id"}</code>

		<h4>Raf işlemleri ile ilgili bilgiler:</h4>
		<p>Raf listesini görmek için url adresi :</p>
		<code><?php echo base_url(); ?>raflar</code>

		<p>Yeni raf eklemek için url adresi :</p>
		<code><?php echo base_url(); ?>raflar/ekle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"shelve_name":"Eklenecek_raf_adi","stores_id":"Depo_id","created_id":"ekleyen_user_id"}</code>

		<p>Raf düzenlemek için url adresi :</p>
		<code><?php echo base_url(); ?>raflar/guncelle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"shelve_id":"duzenlenecek_id","shelve_name":"raf_Adi","stores_id":"Depo_id","modified_id":"duzenleyen_user_id"}</code>

		<p>Raf silmek için url adresi :</p>
		<code><?php echo base_url(); ?>raflar/sil</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"shelve_id":"silinecek_id","deleted_id":"silen_user_id"}</code>

		<h4>Ürün Grupları işlemleri ile ilgili bilgiler:</h4>
		<p>Ürün grupları listesini görmek için url adresi :</p>
		<code><?php echo base_url(); ?>urungruplari</code>

		<p>Ürün Grubu eklemek için url adresi :</p>
		<code><?php echo base_url(); ?>urungruplari/ekle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"productgroup_name":"Eklenecek_grup_ismi","created_id":"ekleyen_user_id"}</code>
		
		<p>Ürün Grubu düzenlemek için url adresi :</p>
		<code><?php echo base_url(); ?>urungruplari/guncelle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"productgroup_id":"duzenlenecek_id","productgroup_name":"grup_Adi","modified_id":"duzenleyen_user_id"}</code>

		<p>Ürün Grubu silmek için url adresi :</p>
		<code><?php echo base_url(); ?>urungruplari/sil</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"productgroup_id":"silinecek_id","deleted_id":"silen_user_id"}</code>

		<h4>Alt Ürün Grupları işlemleri ile ilgili bilgiler:</h4>
		<p>Ürün alt grupları listesini görmek için url adresi :</p>
		<code><?php echo base_url(); ?>urungruplari/altgruplar</code>
		
		<p>Alt Ürün Grubu Eklemek için url adresi :</p>
		<code><?php echo base_url(); ?>urungruplari/altgruplar/ekle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"subproductgroup_name":"Eklenecek_grup_ismi","productgroup_id":"ana_grup_idsi","created_id":"olusturan_id"}</code>

		<p>Alt Ürün Grubu Düzenlemek için url adresi :</p>
		<code><?php echo base_url(); ?>urungruplari/altgruplar/guncelle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"subproductgroup_id":"duzenlenecek_id","subproductgroup_name":"alt_grup_Adi","productgroup_id":"ana_grup_idsi","modified_id":"duzenleyen_user_id"}</code>
		
		<p>Alt Ürün Grubu Silmek için url adresi :</p>
		<code><?php echo base_url(); ?>urungruplari/altgruplar/sil</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"subproductgroup_id":"silinecek_id","deleted_id":"silen_user_id"}</code>
		
		<h4>Stok Kartı işlemleri ile ilgili bilgiler:</h4>
		<p>Stok Kartı listesini görmek için url adresi :</p>
		<code><?php echo base_url(); ?>stokkartlari</code>

		<p>Stok Kartı Eklemek için url adresi :</p>
		<code><?php echo base_url(); ?>stokkartlari/ekle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"productname":"Eklenecek stok karti ismi","productgroup_id":"ana grup idsi","subproductgroup_id":"alt grup idsi","created_id":"ekleyen_user_id"}</code>
		
		<p>Stok Kartı Düzenlemek için url adresi :</p>
		<code><?php echo base_url(); ?>stokkartlari/guncelle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"stockcard_id":"duzenlenecek_id","productname":"Eklenecek stok karti ismi","productgroup_id":"ana grup idsi","subproductgroup_id":"alt grup idsi","modified_id":"duzenleyen_user_id"}</code>
		
		<p>Stok Kartı Silmek için url adresi :</p>
		<code><?php echo base_url(); ?>stokkartlari/sil</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"stockcard_id":"silinecek_id","deleted_id":"silen_user_id"}</code>

		<h4>Stok Hareket işlemleri ile ilgili bilgiler:</h4>
		<p>Stok hareket listesini görmek için url adresi :</p>
		<code><?php echo base_url(); ?>stokhareketleri</code>
		
		<p>Stok hareketi eklemek için url adresi :</p>
		<code><?php echo base_url(); ?>stokhareketleri/ekle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"date":"islem_tarihi_YYYY-AA-GG","stockcard_id":"stok_karti_id","stores_id":"depo_numarasi","shelve_id":"raf_numarasi","details":"detay notu","entries":"giris_miktari","outputs":"cikis_miktari","created_id":"ekleyen_user_id"}</code>
		
		<p>Stok hareketi düzenlemek için url adresi :</p>
		<code><?php echo base_url(); ?>stokhareketleri/guncelle</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"stocks_id":"stok_hareket_numarasi","date":"islem_tarihi_YYYY-AA-GG","stockcard_id":"stok_karti_id","stores_id":"depo_numarasi","shelve_id":"raf_numarasi","details":"detay notu","entries":"giris_miktari","outputs":"cikis_miktari","modified_id":"duzenleyen_user_id"}</code>

		<p>Stok hareketi silmek için url adresi :</p>
		<code><?php echo base_url(); ?>stokhareketleri/sil</code>
		<p>Aşağıdaki json çıktısını ilgili alanları doldurarak sunucuya gönderin.</p>
		<code>{"stocks_id":"silinecek_id","deleted_id":"silen_user_id"}</code>
		
		<hr>

		<h4>Getir fonksiyonu ile ilgili bilgiler:</h4>
		<p>Getir hizmetine ulaşmak için url adresi :</p>
		<code><?php echo base_url(); ?>getir</code>
		<p>Getir hizmeti istenen verileri modüllerden ham bir şekilde ilgili tablolar ile birleştirmeden geri döndürür. Örnekleri aşağıda yer almaktadır.</p>
		<h3>Getir ile veri getirilebilecek modüller;</h3>
		<code>
		<?php echo base_url(); ?>getir/kullanicilar<br>
		<?php echo base_url(); ?>getir/kullanicigruplari<br>
		<?php echo base_url(); ?>getir/depolar<br>
		<?php echo base_url(); ?>getir/raflar<br>
		<?php echo base_url(); ?>getir/urungruplari<br>
		<?php echo base_url(); ?>getir/alturungruplari<br>
		<?php echo base_url(); ?>getir/stokkartlari<br>
		<?php echo base_url(); ?>getir/stokhareketleri
		</code>
		<p>yukarıdaki adreslere aşağıdaki örneklerdeki gibi json formatında veri gönderildiğinde sistem istenen koşullara uygun verileri geri döndürecektir.</p>
		<code>
			Örnek json formatı : <br>
			{"created":"2022-03-24 20:16:49"} <br>
			gönderilecek parametreler istenen modüllerde normal veri alışverişinde kullanılan parametreler ile eşleşmelidir.<br><br>

			{"deleted !=":"null"} // deleted kısımlarının boş olmayanlarını çekmektedir.<br>
			{"deleted":"null"} // deleted kısımlarının boş olanlarını çekmektedir.<br>
			{"created >":"YYYY-AA-GG"} // belirtilen tarihten buyuk olanları çekmektedir.<br>
			{"created <":"YYYY-AA-GG"} // belirtilen tarihten küçük olanları çekmektedir.<br>
			{"created >=":"YYYY-AA-GG"} // belirtilen tarihten buyuk ve eşit olanları çekmektedir.<br>
			{"created <=":"YYYY-AA-GG"} // belirtilen tarihten küçük ve eşit olanları çekmektedir.<br>
			{"created":"YYYY-AA-GG"} // belirtilen veriye eşit olanları çekmektedir.<br>
			<br>
			yukarıdaki örneklere uygun birden fazla uygun parametre göndererek filtre edebilirsiniz.

		</code>
	
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
