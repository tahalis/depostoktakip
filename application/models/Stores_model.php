<?php
date_default_timezone_set("Europe/Istanbul"); //  zaman tarih referansını
class Stores_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Users_model");  // ilgili kullanici tablosu modelimizi kullanici idlerini kontrol etmek üzere yüklüyoruz.
        $this->load->model("Shelves_model");
    }
    public function getall(){
        try
        {
            $data=$this->db->where(["deleted"=>null,"deleted_id"=>null])->get("stores")->result(); // stores tablosundan tüm sonuçları alıyor.
            echo json_encode( $data ); // $data dizesini json formatına döndürerek ekrana basıyor.
        }
        catch(Exception $e){
            //hata var ise burada yakalanır
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
        
    }
    public function add($_arraydata){
        try
        {
            $whereuser=array( // ekleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
                "users_id"=>$_arraydata["created_id"],
                "deleted"=>null
            );
            $created_user = $this->Users_model->getUser($whereuser); // ekleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
            $inserarray=array( // ekleyecegimi kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "stores_name"=>$_arraydata['stores_name'],
                "created"=>date("Y-m-d H:i:s"), 
                "created_id"=>$_arraydata['created_id']
            );
            $results=$this->db->insert("stores",$inserarray); // bilgileri veritabanına gönderiyoruz.
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
            $updatearray=array( // güncellenecek kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "stores_name"=>$_arraydata['stores_name'],
                "modified"=>date("Y-m-d H:i:s"), 
                "modified_id"=>$_arraydata['modified_id']
            );
            $results=$this->db->where("stores_id",$_arraydata['stores_id'])->update("stores",$updatearray); // bilgileri veritabanına gönderiyoruz.
            return $results; // işlem sonucunu geri gönderiyoruz
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderiyoruz    
        }
    }
    public function delete($_arraydata){
        $whereuser=array( // guncelleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "users_id"=>$_arraydata["deleted_id"],
            "deleted"=>null
        );
        $created_user = $this->Users_model->getUser($whereuser); // silme islemi gerceklestirecek kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz

        $whereshelves=array( //  raf verisinin guncel dolu olup olmadigini sorgusunu hazirliyoruz
            "stores_id"=>$_arraydata["stores_id"],
            "deleted"=>null,
        );
        $created_shelves = $this->Shelves_model->getshelve($whereshelves); // silme islemi gerceklestirilecek grup ile ilgili kullanici kontrolu 
        if($created_shelves) return 0; // sorgu sonucu pozitifse negatif sonuç döndürüyoruz.
        
        $deletearray=array( // güncellenecek kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "deleted"=>date("Y-m-d H:i:s"), 
            "deleted_id"=>$_arraydata['deleted_id']
        );
        $results=$this->db->where("stores_id",$_arraydata['stores_id'])->update("stores",$deletearray); // bilgileri veritabanına gönderiyoruz.
        return $results; // işlem sonucunu geri gönderiyoruz      
    }
    public function getstores($where=array()){
        try
        {
            if(!$where)return 0; // gelen id verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $groupdata=$this->db->where($where)->get("stores")->row(); // users tablosundan tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
}
