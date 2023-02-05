<?php
date_default_timezone_set("Europe/Istanbul"); //  zaman tarih referansını
class Productgroups_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Users_model");  // ilgili kullanici tablosu modelimizi kullanici idlerini kontrol etmek üzere yüklüyoruz.
        $this->load->model("Sub_Productgroups_model"); // alt ürün grupları tablosunda işlem için modeli yüklüyoruz.
    }
    public function getall(){
        try
        {
            $data=$this->db->where(["deleted"=>null,"deleted_id"=>null])->get("product_groups")->result(); // urun gruplari tablosundan tüm sonuçları alıyor.
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
            $inserarray=array( // ekleyecegimi ürün grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "productgroup_name"=>$_arraydata['productgroup_name'],
                "created"=>date("Y-m-d H:i:s"), 
                "created_id"=>$_arraydata['created_id']
            );
            $results=$this->db->insert("product_groups",$inserarray); // bilgileri veritabanına gönderiyoruz.
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
            $updatearray=array( // güncellenecek ürün grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "productgroup_name"=>$_arraydata['productgroup_name'],
                "modified"=>date("Y-m-d H:i:s"), 
                "modified_id"=>$_arraydata['modified_id']
            );
            $results=$this->db->where("productgroup_id",$_arraydata['productgroup_id'])->update("product_groups",$updatearray); // bilgileri veritabanına gönderiyoruz.
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

        $wheressubgroup=array( //  alt grup verisinin guncel dolu olup olmadigini sorgusunu hazirliyoruz
            "productgroup_id"=>$_arraydata["productgroup_id"],
            "deleted"=>null,
        );
        $created_subproduct_group = $this->Sub_Productgroups_model->get_sub_product_group($wheressubgroup); // silme islemi gerceklestirilecek grup ile ilgili alt grup kontrolu 
        if($created_subproduct_group) return 0; // sorgu sonucu pozitifse negatif sonuç döndürüyoruz.
        
        $deletearray=array( // silinecek ürün grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "deleted"=>date("Y-m-d H:i:s"), 
            "deleted_id"=>$_arraydata['deleted_id']
        );
        $results=$this->db->where(["productgroup_id"=>$_arraydata['productgroup_id'],"deleted"=>null])->update("product_groups",$deletearray); // bilgileri veritabanına gönderiyoruz.
        return $results; // işlem sonucunu geri gönderiyoruz      
    }
    public function getproductgroup($where=array()){
        try
        {
            if(!$where)return 0; // gelen sorgu verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $groupdata=$this->db->where($where)->get("product_groups")->result(); // tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
}
