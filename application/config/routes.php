<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*{
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
}
*/

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

// kullanici islemleri---------------------------------------
/* Kullanici Ekle Json Format 
{"user_name":"Eklenecek Kullanici","groups_id":"0","created_id":"0"}
*/
$route['kullaniciekle']='Users_controller/add_users';

/*Kullanici Duzenle Json Format
{"users_id":"6","user_name":"thdmbs","groups_id":"0","modified_id":"0"}
*/
$route['kullaniciduzenle']='Users_controller/update_user';

/* Kullanici Sil Json Format
{"users_id":"6","deleted_id":"0"}
 */
$route['kullanicisil']='Users_controller/del_user';

$route['kullanicilar']='Users_controller/index';

//----------------------------------------------------------
// kullanici gruplari islemleri-----------------------------

$route['kullanicigruplari']="Usersgroups_controller/index";
/* Kullanici Grubu Ekleme Json format?? 
    {"usergroup_name":"Eklenecek Grup","created_userid":"0"}
*/
$route['kullanicigruplari/ekle']="Usersgroups_controller/addgroup";
/* KUllanici Gurubu Guncelleme Json Format
    {"groups_id":"duzenlenecek_id","usergroup_name":"yeni_grub_ismi","modifield_userid":"0"}
*/
$route['kullanicigruplari/guncelle']="Usersgroups_controller/updategroup";
/* Kullanici grubu silme islemi Json Foormat??
{"groups_id":"silinecek_id","deleted_userid":"0"}
*/
$route['kullanicigruplari/sil']="Usersgroups_controller/deletegroup";

//----------------------------------------------------------
// Depo islemleri-------------------------------------------

$route['depolar']="Storage_controller/index";
/* Depo Ekleme Json format?? 
    {"stores_name":"Eklenecek Depo","created_id":"0"}
*/
$route['depolar/ekle']="Storage_controller/add";
/* Depo Guncelleme Json Format
    {"stores_id":"duzenlenecek_id","stores_name":"Yeni_depo_ismi","modified_id":"0"}
*/
$route['depolar/guncelle']="Storage_controller/update";
/* Depo silme islemi Json Foormat??
{"stores_id":"silinecek_id","deleted_id":"0"}
*/
$route['depolar/sil']="Storage_controller/delete";


//----------------------------------------------------------
// Raf islemleri-------------------------------------------

$route['raflar']="Shelves_controller/index";
/* Depo Ekleme Json format?? 
    {"shelve_name":"Eklenecek raf","stores_id":"Depo_id","created_id":"0"}
*/
$route['raflar/ekle']="Shelves_controller/add";
/* Depo Guncelleme Json Format
    {"shelve_id":"duzenlenecek_id","shelve_name":"raf_Adi","stores_id":"Depo_id","modified_id":"0"}
*/
$route['raflar/guncelle']="Shelves_controller/update";
/* Depo silme islemi Json Foormat??
{"shelve_id":"silinecek_id","deleted_id":"0"}
*/
$route['raflar/sil']="Shelves_controller/delete";

//----------------------------------------------------------
// Urun Gruplari islemleri-------------------------------------------

$route['urungruplari']="Productgroups_controller/index";
/* ??r??n Grubu Ekleme Json format?? 
    {"productgroup_name":"Eklenecek grup ismi","created_id":"0"}
*/
$route['urungruplari/ekle']="Productgroups_controller/add";
/* ??r??n Grubu Guncelleme Json Format
    {"productgroup_id":"duzenlenecek_id","productgroup_name":"grup_Adi","modified_id":"0"}
*/
$route['urungruplari/guncelle']="Productgroups_controller/update";
/* ??r??n Grubu silme islemi Json Foormat??
{"productgroup_id":"silinecek_id","deleted_id":"0"}
*/
$route['urungruplari/sil']="Productgroups_controller/delete";


//----------------------------------------------------------
// Alt Urun Gruplari islemleri-------------------------------------------

$route['urungruplari/altgruplar']="Sub_Productgroups_controller/index";
/* Alt ??r??n Grubu Ekleme Json format?? 
    {"subproductgroup_name":"Eklenecek grup ismi","productgroup_id":"ana grup idsi","created_id":"0"}
*/
$route['urungruplari/altgruplar/ekle']="Sub_Productgroups_controller/add";
/* Alt ??r??n Grubu Guncelleme Json Format
    {"subproductgroup_id":"duzenlenecek_id","subproductgroup_name":"grup_Adi","productgroup_id":"ana grup idsi","modified_id":"0"}
*/
$route['urungruplari/altgruplar/guncelle']="Sub_Productgroups_controller/update";
/* Alt ??r??n Grubu silme islemi Json Foormat??
{"subproductgroup_id":"silinecek_id","deleted_id":"0"}
*/
$route['urungruplari/altgruplar/sil']="Sub_Productgroups_controller/delete";

//----------------------------------------------------------
// Stok Karti  islemleri-------------------------------------------

$route['stokkartlari']="Stockcards_controller/index";
/* Stok kart??  Ekleme Json format?? 
    {"productname":"Eklenecek stok karti ismi","stores_id":"depo idsi","productgroup_id":"ana grup idsi","subproductgroup_id":"alt grup idsi","shelve_id":"raf idsi","created_id":"0"}
*/
$route['stokkartlari/ekle']="Stockcards_controller/add";
/* Stok kart?? Guncelleme Json Format
    {"stockcard_id":"duzenlenecek_id","productname":"Eklenecek stok karti ismi","stores_id":"depo idsi","productgroup_id":"ana grup idsi","subproductgroup_id":"alt grup idsi","shelve_id":"raf idsi","modified_id":"0"}
*/
$route['stokkartlari/guncelle']="Stockcards_controller/update";
/* Stok kart?? silme islemi Json Foormat??
{"stockcard_id ":"silinecek_id","deleted_id":"0"}
*/
$route['stokkartlari/sil']="Stockcards_controller/delete";

//----------------------------------------------------------
// Stok  Hareketi islemleri---------------------------------

$route['stokhareketleri']="Stocks_controller/index";
/* Stok  Giris/Cikis Json format?? 
    {"date":"islem_tarihi_YYYY-AA-GG","stockcard_id":"stok_karti_id","stores_id":"depo_numarasi","shelve_id":"raf_numarasi","details":"detay notu","entries":"giris miktari","outputs":"cikis miktari","created_id":"0"}
*/
$route['stokhareketleri/ekle']="Stocks_controller/add";
/* Stok  Guncelleme Json Format
   {"stocks_id":"stok hareket numarasi","date":"islem_tarihi_YYYY-AA-GG","stockcard_id":"stok_karti_id","stores_id":"depo_numarasi","shelve_id":"raf_numarasi","details":"detay notu","entries":"giris miktari","outputs":"cikis miktari","modified_id":"0"}
*/
$route['stokhareketleri/guncelle']="Stocks_controller/update";
/* Stok Kayit silme islemi Json Foormat??
{"stocks_id ":"silinecek_id","deleted_id":"0"}
*/
$route['stokhareketleri/sil']="Stocks_controller/delete";

//----------------------------------------------------------
// Getir islemleri------------------------------------------
/* Veri g??nderilecek adresin sonuna "domain.com/getir/stokhareket"  ??eklinde ??a????r??lmak istenen mod??l ve modullere bagli parametreler ile girilmelidir.
dogru girilen parametreler ile ilgili aramalarda filtrelenmi?? verileri tablolar?? B??RLE??T??RMEDEN HAM HAL??NDE getirecektir.

g??nderilecek veri ??rne??i : 

{"deleted !=":"null"} // deleted k??s??mlar??n??n bo?? olmayanlar??n?? ??ekmektedir.
{"deleted":"null"} // deleted k??s??mlar??n??n bo?? olanlar??n?? ??ekmektedir.
{"deleted !=":"null"} // deleted k??s??mlar??n??n bo?? olmayanlar??n?? ??ekmektedir.<br>
{"deleted":"null"} // deleted k??s??mlar??n??n bo?? olanlar??n?? ??ekmektedir.<br>
{"created >":"YYYY-AA-GG"} // belirtilen tarihten buyuk olanlar?? ??ekmektedir.<br>
{"created <":"YYYY-AA-GG"} // belirtilen tarihten k??????k olanlar?? ??ekmektedir.<br>
{"created >=":"YYYY-AA-GG"} // belirtilen tarihten buyuk ve e??it olanlar?? ??ekmektedir.<br>
{"created <=":"YYYY-AA-GG"} // belirtilen tarihten k??????k ve e??it olanlar?? ??ekmektedir.<br>
{"created":"YYYY-AA-GG"} // belirtilen veriye e??it olanlar?? ??ekmektedir.<br>

Veriler json formati ile sunucuya g??nderilmelidir.

*/
$route['getir/kullanicilar']="Search_contoller/kullanicilar";
$route['getir/kullanicigruplari']="Search_contoller/kullanicigruplari";
$route['getir/depolar']="Search_contoller/depolar";
$route['getir/raflar']="Search_contoller/raflar";
$route['getir/urungruplari']="Search_contoller/urungruplari";
$route['getir/alturungruplari']="Search_contoller/alturungruplari";
$route['getir/stokkartlari']="Search_contoller/stokkartlari";
$route['getir/stokhareketleri']="Search_contoller/stokhareketleri";
