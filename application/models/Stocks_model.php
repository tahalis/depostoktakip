<?php
date_default_timezone_set("Europe/Istanbul"); //  zaman tarih referansını
class Stocks_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Users_model");  // ilgili kullanici tablosu modelimizi kullanici idlerini kontrol etmek üzere yüklüyoruz.
        $this->load->model("Stores_model");  // ilgili Depo tablosu modelimizi depo idlerini kontrol etmek üzere yüklüyoruz.
        $this->load->model("Stockcards_model"); // ilgili stok kartlarinin cekilecegi modeli yukluyoruz
        $this->load->model("Shelves_model"); // ilgili raf verilerini getirecek modeli yukluyoruz
    }
    public function getall(){
        try
        {
            $data=$this->db
            ->select('stocks_lists.stocks_id,stocks_lists.date, stokcards.productname, stores.stores_name, shelves.shelve_name,
            stocks_lists.details, stocks_lists.entries, stocks_lists.outputs, stocks_lists.created, stocks_lists.modified,
            stocks_lists.deleted, stocks_lists.created_id, stocks_lists.modified_id, stocks_lists.deleted_id') // tabloya birleştirilen kolonları seçiyoruz.
            ->join('stores','stocks_lists.stores_id=stores.stores_id') // join ile stores ve shelves tablosunu birleştiriyoruz.
            ->join('stokcards','stocks_lists.stockcard_id=stokcards.stockcard_id') // stok kartı ile stoks tablosunu birleştiriyoruz
            ->join('shelves','stocks_lists.shelve_id=shelves.shelve_id') // raf tablosu ile stok tablosunu birleştiriyoruz
            ->where(["stocks_lists.deleted"=>null,"stocks_lists.deleted_id"=>null]) // verilerin gösterilmesinde koşulumuz.
            ->get("stocks_lists")->result(); //  tüm sonuçları alıyor.
            echo json_encode( $data ); // $data dizesini json formatına döndürerek ekrana basıyor.
        }
        catch(Exception $e){
            //hata var ise burada yakalanır
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
    public function add($_arraydata){
        // stok hareketi ekleyecek kullanici sorgusu
        $whereuser=array( // ekleyen kullanıcı sorgusunu hazırlıyoruz
            "users_id"=>$_arraydata["created_id"],
            "deleted"=>null
        );
        $created_user = $this->Users_model->getUser($whereuser); // ekleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_user) return "Kullanici bilgisi gecerli degil."; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz

        //ürün stok kartı sorgusu
        $wherecard=array( // urun stok kartının gecerli olup olmadigini sorgusunu hazirliyoruz
            "stockcard_id"=>$_arraydata["stockcard_id"],
            "deleted"=>null
        );
        $created_card = $this->Stockcards_model->get_stok_cards($wherecard); // belirtilen stok kartı bilgisini ilgili modele gönderip kontrol ettiriyoruz. 
        if(!$created_card) return "Girilen stok karti bilgisi gecersiz."; // stok kartı bilgisi gecerli degil ise negatif geri donus sagliyoruz

        // depo bilgisi sorgusu
        $wherestores=array( // urun depo kartının gecerli olup olmadigini sorgusunu hazirliyoruz
            "stores_id"=>$_arraydata["stores_id"],
            "deleted"=>null
        );
        $created_store = $this->Stores_model->getstores($wherestores); // eklenen deponun hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_store) return "Girilen depo bilgisi gecersiz."; // depo bilgisi gecerli degil ise negatif geri donus sagliyoruz

        //raf bilgisi sorgusu
        $whereshelve=array( // urun raf kartının gecerli olup olmadigini sorgusunu hazirliyoruz
            "stores_id"=>$_arraydata['stores_id'],
            "shelve_id"=>$_arraydata["shelve_id"],
            "deleted"=>null
        );
        $created_shelve= $this->Shelves_model->getshelve($whereshelve); // eklenen raf hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_shelve) return "Girilen raf bilgisi gecersiz. Yada yanlis depo ile kullanilmak isteniyor."; // raf bilgisi gecerli degil ise negatif geri donus sagliyoruz

        // istedigimiz bilgiler ile stok hareket kaydini olusturuyoruz
        $amount;
        if($_arraydata['record_type']=='entries') $amount=$_arraydata['entries'];
        else if ($_arraydata['record_type']=='outputs') $amount=$_arraydata['outputs'];
        $inserarray=array( // ekleyecegimi stok hareket kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "stockcard_id"=>$_arraydata['stockcard_id'],
            "stores_id"=>$_arraydata['stores_id'],
            "date"=>$_arraydata['date'],
            "shelve_id"=>$_arraydata['shelve_id'],
            "details"=>$_arraydata['details'],
            $_arraydata['record_type']=>$amount,
            "created"=>date("Y-m-d H:i:s"), 
            "created_id"=>$_arraydata['created_id']
        );
        $results=$this->db->insert("stocks_lists",$inserarray); // bilgileri veritabanına gönderiyoruz.
        if($results)return "Stok kaydi olusturuldu.";
        else return "Stok kaydi olusturulamadi";


    }
    public function update($_arraydata){
         // stok hareketi duzenleyecek kullanici sorgusu
         $whereuser=array( // duzenlenen deponun gecerli olup olmadigini sorgusunu hazirliyoruz
            "users_id"=>$_arraydata["modified_id"],
            "deleted"=>null
        );
        $created_user = $this->Users_model->getUser($whereuser); // duzenleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_user) return "Kullanici bilgisi gecersiz."; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz

        //ürün stok kartı sorgusu
        $wherecard=array( // urun stok kartının gecerli olup olmadigini sorgusunu hazirliyoruz
            "stockcard_id"=>$_arraydata["stockcard_id"],
            "deleted"=>null
        );
        $created_card = $this->Stockcards_model->get_stok_cards($wherecard); // duzenlenen stok kartının hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_card) return "Guncellenecek Stok karti bilgisi gecersiz."; // kart bilgisi gecerli degil ise negatif geri donus sagliyoruz

        // depo bilgisi sorgusu
        $wherestores=array( // urun depo kartının gecerli olup olmadigini sorgusunu hazirliyoruz
            "stores_id"=>$_arraydata["stores_id"],
            "deleted"=>null
        );
        $created_store = $this->Stores_model->getstores($wherestores); // eklenen deponun hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_store) return "Guncellenecek depo bilgisi gecersiz."; // depo bilgisi gecerli degil ise negatif geri donus sagliyoruz

        //raf bilgisi sorgusu
        $whereshelve=array( // urun raf kartının gecerli olup olmadigini sorgusunu hazirliyoruz
            "stores_id"=>$_arraydata['stores_id'],
            "shelve_id"=>$_arraydata["shelve_id"],
            "deleted"=>null
        );
        $created_shelve= $this->Shelves_model->getshelve($whereshelve); // duzenlenen raf hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_shelve) return "Guncellenecek raf bilgisi gecersiz. Veya belirtilen depo bilgisi ile eslesmiyor."; // raf bilgisi gecerli degil ise negatif geri donus sagliyoruz

        // istedigimiz bilgiler ile stok hareket kaydini duzenliyoruz
        $amount;
        if($_arraydata['record_type']=='entries') {$amount=$_arraydata['entries'];$_arraydata['deleted_column']="outputs";}
        else if ($_arraydata['record_type']=='outputs') {$amount=$_arraydata['outputs'];$_arraydata['deleted_column']="entries";}
        $updatearray=array( // duzenleyeceğimiz stok hareket kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "stockcard_id"=>$_arraydata['stockcard_id'],
            "stores_id"=>$_arraydata['stores_id'],
            "shelve_id"=>$_arraydata['shelve_id'],
            "date"=>$_arraydata['date'],
            "details"=>$_arraydata['details'],
            $_arraydata['record_type']=>$amount,
            $_arraydata['deleted_column']=>null,
            "modified"=>date("Y-m-d H:i:s"), 
            "modified_id"=>$_arraydata['modified_id']
        );
        $results=$this->db->where(['stocks_id'=>$_arraydata['stocks_id'],"deleted"=>null])->update("stocks_lists",$updatearray); // bilgileri veritabanına gönderiyoruz.
        if($results)return "Stok kaydi guncellendi.";
        else return "Stok kaydi guncellenemdi.";

    }
    public function delete($_arraydata){
        $whereuser=array( // silen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "users_id"=>$_arraydata["deleted_id"],
            "deleted"=>null
        );
        $created_user = $this->Users_model->getUser($whereuser); // silme islemi gerceklestirecek kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_user) return "Kullanici gecersiz.";
        $deletearray=array( // silinecek stok hareket kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "deleted"=>date("Y-m-d H:i:s"), 
            "deleted_id"=>$_arraydata['deleted_id']
        );
        $results=$this->db->where(["stocks_id"=>$_arraydata['stocks_id'],"deleted"=>null])->update("stocks_lists",$deletearray); // bilgileri veritabanına gönderiyoruz.
        if($results)return "stok hareketi silindi";
        else return "Stok hareketi silinemedi";     
    }
    public function gets_stocks_list($where=array()){
        try
        {
            if(!$where)return 0; // gelen id verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $groupdata=$this->db->where($where)->get("stocks_lists")->result(); // stok tablosundan tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
}