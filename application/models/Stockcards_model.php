<?php
date_default_timezone_set("Europe/Istanbul"); //  zaman tarih referansını
class Stockcards_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Users_model");  // ilgili kullanici tablosu modelimizi kullanici idlerini kontrol etmek üzere yüklüyoruz.
        //$this->load->model("Stores_model");  // ilgili Depo tablosu modelimizi depo idlerini kontrol etmek üzere yüklüyoruz.
        //$this->load->model("Shelves_model"); // ilgili raf modelimizi raf idlerini kontrol etmek için yüklüyoruz
        $this->load->model("Productgroups_model");
        $this->load->model("Sub_Productgroups_model");
    }
    public function getall(){
        try
        {
            $data=$this->db
            ->select('stokcards.stockcard_id, stokcards.productname,product_groups.productgroup_name, sub_product_groups.subproductgroup_name, stokcards.created, stokcards.modified,
            stokcards.deleted, stokcards.created_id, stokcards.modified_id, stokcards.deleted_id') // tabloya birleştirilen kolonları seçiyoruz.
            ->join('product_groups','stokcards.productgroup_id=product_groups.productgroup_id')
            ->join('sub_product_groups','stokcards.subproductgroup_id=sub_product_groups.subproductgroup_id')
            ->where(["stokcards.deleted"=>null,"stokcards.deleted_id"=>null]) // verilerin gösterilmesinde koşulumuz.
            ->get("stokcards")->result(); // shelves tablosundan tüm sonuçları alıyor.
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
           
            // ekleme yapacak kullanıcı sorgulaması
            $whereuser=array( // ekleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
                "users_id"=>$_arraydata["created_id"],
                "deleted"=>null
            );
            $created_user = $this->Users_model->getUser($whereuser); // ekleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz

            // ürün grubu sorgulaması
            $whereproduct=array( // urun gurubunun gecerli olup olmadigi bilgisi
                "productgroup_id"=>$_arraydata["productgroup_id"],
                "deleted"=>null
            );
            $created_productg = $this->Productgroups_model->getproductgroup($whereproduct); // ekleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_productg) return 0; // urun grubu bilgisi gecerli degil ise negatif geri donus sagliyoruz

            // alt urun grubu bilgisi gecerlimi kontrol ediyoruz
            $wheressubgroup=array( //  alt grup verisinin guncel dolu olup olmadigini sorgusunu hazirliyoruz
                "subproductgroup_id"=>$_arraydata["subproductgroup_id"],
                "productgroup_id"=>$_arraydata["productgroup_id"],
                "deleted"=>null,
            );
            $created_subproduct_group = $this->Sub_Productgroups_model->get_sub_product_group($wheressubgroup); // ekleme islemi gerceklestirilecek grup ile ilgili  kontrol 
            if(!$created_subproduct_group) return 0; // sorgu sonucu negatifse negatif sonuç döndürüyoruz.
           
        
           
            $inserarray=array( // ekleyecegimi kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "productname"=>$_arraydata['productname'],
                "productgroup_id"=>$_arraydata['productgroup_id'],
                "subproductgroup_id"=>$_arraydata['subproductgroup_id'],
                "created"=>date("Y-m-d H:i:s"), 
                "created_id"=>$_arraydata['created_id']
            );
            $results=$this->db->insert("stokcards",$inserarray); // bilgileri veritabanına gönderiyoruz.
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
     
             // ürün grubu sorgulaması
             $whereproduct=array( // urun gurubunun gecerli olup olmadigi bilgisi
                "productgroup_id"=>$_arraydata["productgroup_id"],
                "deleted"=>null
            );
            $created_productg = $this->Productgroups_model->getproductgroup($whereproduct); // guncellenen urun grubunun hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_productg) return 0; // urun grubu bilgisi gecerli degil ise negatif geri donus sagliyoruz
                
            // alt urun grubu bilgisi gecerlimi kontrol ediyoruz
            $wheressubgroup=array( //  alt grup verisinin guncel dolu olup olmadigini sorgusunu hazirliyoruz
                "subproductgroup_id"=>$_arraydata["subproductgroup_id"],
                "productgroup_id"=>$_arraydata["productgroup_id"],
                "deleted"=>null,
            );
            $created_subproduct_group = $this->Sub_Productgroups_model->get_sub_product_group($wheressubgroup); // guncelleme islemi gerceklestirilecek grup ile ilgili  kontrol 
            if(!$created_subproduct_group) return 0; // sorgu sonucu negatifse negatif sonuç döndürüyoruz.
            $updatearray=array( // güncellenecek kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "productname"=>$_arraydata['productname'],
                "productgroup_id"=>$_arraydata['productgroup_id'],
                "subproductgroup_id"=>$_arraydata['subproductgroup_id'],
                "modified"=>date("Y-m-d H:i:s"), 
                "modified_id"=>$_arraydata['modified_id']
            );
            $results=$this->db->where(["stockcard_id"=>$_arraydata['stockcard_id'],"deleted"=>null])->update("stokcards",$updatearray); // bilgileri veritabanına gönderiyoruz.
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
        /*$whereusers=array( // guncelleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "groups_id"=>$_arraydata["id"],
            "deleted"=>null,
        );
        $created_users = $this->Users_model->getUsers($whereusers); // silme islemi gerceklestirilecek grup ile ilgili kullanici kontrolu 
        if($created_users) return 0; // sorgu sonucu pozitifse negatif sonuç döndürüyoruz.
        */
        $deletearray=array( // güncellenecek kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "deleted"=>date("Y-m-d H:i:s"), 
            "deleted_id"=>$_arraydata['deleted_id']
        );
        $results=$this->db->where(["stockcard_id"=>$_arraydata['stockcard_id'],"deleted"=>null])->update("stokcards",$deletearray); // bilgileri veritabanına gönderiyoruz.
        return $results; // işlem sonucunu geri gönderiyoruz      
    }
    public function get_stok_cards($where=array()){
        try
        {
            if(!$where)return 0; // gelen id verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $groupdata=$this->db->where($where)->get("stokcards")->result(); // shelves tablosundan tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
}
