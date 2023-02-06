###################
Depo Stok Takip Sistemi
###################

Projeyi localhostumda yazmis bulunmaktayim. Denemelerde uzak sunucu da kullanmis bulunmaktayim. Projeyi calistirdiginizda kok dizin de yapabileceginiz islemleri gosteren ve
komutlarin neler oldugunu gosteren bilgi sayfasi icermektedir Eger kok url dizininde direkt gelmiyor ise /welcome urlsinden erisebilirsiniz. Ayrica proje icerisinde base_url localhost a gore ayarlanmistir. Eger farkli bir ortamda test edecekseniz
degistirmeniz gerekebilir.

base_url : http://localhost/depostoktakip seklinde ayarlidir.

Veritabani icin proje ana dizininde Database klasoru bulunmaktadir. icerisindeki sql dosyasini veritabanina yukleyerek veritabanini aktif hale getirebilirsiniz. 
Ayrica projenin veritabani ayarlari localhost uzerine root kullanici adli ve sifresiz gelmektedir. 


Ayrica veritabani icerisinde her tabloda 1000 satir veri bulunmaktadir. Sifirdan kendi verilerim ile test edecegim derseniz ilk once kullanici gruplarina veritabanindan el ile 1 tane kullanici grubu 
olusturup ilk kullanicinizi ona tanimlamaniz gerekmektedir. Elle kullanici kaydi atsanizda kullanici grubu gecersiz ise kullanicilar listesini bastirdiginizda goremeyebilirsiniz.


Ayrica veritabanindaki test verilerinde mesela urun gruplarinin alt urun gruplari ayni id numaralarina denk geldigi icin urun grubundan farkli id yazdiginiz zaman kabul
etmemektedir. o sorun tamamen ust ve alt urun gruplarinin tamamen ayni idlere denk gelmesinden kaynaklidir. Harici yeni alt ve ust urun grubu kayitlari atarak kontrol edebilirsiniz.
Ayni sorun depo ve raflarda da gecerliridir. Veri tabaninda depo idsi ile eslestirilecek raf idleri ayni olarak olusturulmustur. Fakat birden fazla alt urun grubu ya da depo altina raf ekleyebilirsiniz.
