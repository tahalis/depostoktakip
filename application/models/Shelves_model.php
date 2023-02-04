<?php
date_default_timezone_set("Europe/Istanbul"); //  zaman tarih referansı
class Shelves_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Users_model");  // ilgili kullanici tablosu modelimizi kullanici idlerini kontrol etmek üzere yüklüyoruz.
        $this->load->model("Stores_model");  // ilgili Depo tablosu modelimizi depo idlerini kontrol etmek üzere yüklüyoruz.
        $this->load->model("Stockcards_model"); // kayitli kart var ise silme islemini engellemek icin verileri yukluyoruz
        $this->load->model("Stocks_model"); // kayitli hareket var ise silme islemini engellemek icin verileri yukluyoruz
    }
    public function getall(){
        try
        {
            $data=$this->db
            ->select('shelves.shelve_id, shelves.shelve_name, stores.stores_name, shelves.created, shelves.modified, shelves.deleted, shelves.created_id, shelves.modified_id, shelves.deleted_id') // tabloya birleştirilen kolonları seçiyoruz.
            ->join('stores','shelves.stores_id=stores.stores_id') // join ile stores ve shelves tablosunu birleştiriyoruz.
            ->where(["shelves.deleted"=>null,"shelves.deleted_id"=>null]) // verilerin gösterilmesinde koşulumuz.
            ->get("shelves")->result(); // shelves tablosundan tüm sonuçları alıyor.
            echo json_encode( $data ); // $data dizesini json formatına döndürerek ekrana basıyor.
        }
        catch(Exception $e){
            
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
        
    }
    public function add($_arraydata){
        try
        {
            $wherestore=array( // ekleyen kullanicinin gecerli depo bilgisi olup olmadigini sorgusunu hazirliyoruz
                "stores_id"=>$_arraydata["stores_id"],
                "deleted"=>null
            );
            $created_store = $this->Stores_model->getstores($wherestore); // eklenecek olan deponun gecerli olup olmadığını kontrol ediyoruz.
            if(!$created_store) return 0; // depo bilgisi gecerli degil ise negatif geri donus sagliyoruz
            $whereuser=array( // ekleyen kullanıcının gecerli olup olmadigini sorgusunu hazirliyoruz
                "users_id"=>$_arraydata["created_id"],
                "deleted"=>null
            );
            $created_user = $this->Users_model->getUser($whereuser); // ekleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
            $inserarray=array( // ekleyecegimi raf  kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "shelve_name"=>$_arraydata['shelve_name'],
                "stores_id"=>$_arraydata['stores_id'],
                "created"=>date("Y-m-d H:i:s"), 
                "created_id"=>$_arraydata['created_id']
            );
            $results=$this->db->insert("shelves",$inserarray); // bilgileri veritabanına gönderiyoruz.
            return $results; // işlem sonucunu geri gönderiyoruz
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderiyoruz
        }
    }
    public function update($_arraydata){
        try
        {
            $whereuser=array( // guncelleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
                "users_id"=>$_arraydata["modified_id"],
                "deleted"=>null
            );
            $created_user = $this->Users_model->getUser($whereuser); // güncelleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
            $wherestore=array( // ekleyen kullanicinin gecerli depo bilgisi olup olmadigini sorgusunu hazirliyoruz
                "stores_id"=>$_arraydata["stores_id"],
                "deleted"=>null
            );
            $created_store = $this->Stores_model->getstores($wherestore); // guncellenecek olan deponun gecerli olup olmadığını kontrol ediyoruz.
            if(!$created_store) return 0; // depo bilgisi gecerli degil ise negatif geri donus sagliyoruz
            $updatearray=array( // güncellenecek raf kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "shelve_name"=>$_arraydata['shelve_name'],
                "stores_id"=>$_arraydata['stores_id'],
                "modified"=>date("Y-m-d H:i:s"), 
                "modified_id"=>$_arraydata['modified_id']
            );
            $results=$this->db->where("shelve_id",$_arraydata['shelve_id'])->update("shelves",$updatearray); // bilgileri veritabanına gönderiyoruz.
            return $results; // işlem sonucunu geri gönderiyoruz
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderiyoruz    
        }
    }
    public function delete($_arraydata){
        $whereuser=array( // silen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "users_id"=>$_arraydata["deleted_id"],
            "deleted"=>null
        );
        $created_user = $this->Users_model->getUser($whereuser); // silme islemi gerceklestirecek kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
        $wherestockcards=array( // silinen raf kaydının gecerli stok kartlari olup olmadigini sorgusunu hazirliyoruz
            "shelve_id"=>$_arraydata["shelve_id"],
            "deleted"=>null,
        );

        $created_stockcards = $this->Stockcards_model->get_stok_cards($wherestockcards); // raf ile ilgili stok kartı kontrolü için modelin ilgili metodunu kullanıyoruz.
        if($created_stockcards) return 0; // sorgu sonucu pozitifse negatif sonuç döndürüyoruz.

        $wherestocks=array( // silinen rafin kayitli urunleri var mı kontrol sorgusu
            "shelve_id"=>$_arraydata["shelve_id"],
            "deleted"=>null,
        );
        $created_stocks = $this->Stocks_model->gets_stocks_list($wherestocks); // silme islemi gerceklestirilecek kayitli stok hareketleri ile ilgili veri kontrolu 
        if($created_stocks) return 0; // sorgu sonucu pozitifse negatif sonuç döndürüyoruz.
        
        $deletearray=array( // silinecek raf kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "deleted"=>date("Y-m-d H:i:s"), 
            "deleted_id"=>$_arraydata['deleted_id']
        );
        $results=$this->db->where("shelve_id",$_arraydata['shelve_id'])->update("shelves",$deletearray); // bilgileri veritabanına gönderiyoruz.
        return $results; // işlem sonucunu geri gönderiyoruz      
    }
    public function getshelve($where=array()){
        try
        {
            if(!$where)return 0; // gelen id verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $groupdata=$this->db->where($where)->get("shelves")->result(); // shelves tablosundan tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
}
