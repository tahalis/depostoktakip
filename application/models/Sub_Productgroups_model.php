<?php
date_default_timezone_set("Europe/Istanbul"); //  zaman tarih referansını
class Sub_Productgroups_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Users_model");  // ilgili kullanici tablosu modelimizi kullanici idlerini kontrol etmek üzere yüklüyoruz.
        $this->load->model("Productgroups_model");  // ilgili Urun Grubu tablosu modelimizi urungrubu idlerini kontrol etmek üzere yüklüyoruz.
    }
    public function getall(){
        try
        {
            $data=$this->db
            ->select('sub_product_groups.subproductgroup_id, sub_product_groups.subproductgroup_name, product_groups.productgroup_name, sub_product_groups.created, sub_product_groups.modified, sub_product_groups.deleted, sub_product_groups.created_id, sub_product_groups.modified_id, sub_product_groups.deleted_id') // tabloya birleştirilen kolonları seçiyoruz.
            ->join('product_groups','sub_product_groups.productgroup_id=product_groups.productgroup_id') // join ile productgroup ve subproductgroup tablosunu birleştiriyoruz.
            ->where(["sub_product_groups.deleted"=>null,"sub_product_groups.deleted_id"=>null]) // verilerin gösterilmesinde koşulumuz.
            ->get("sub_product_groups")->result(); // sub_product_groups tablosundan tüm sonuçları alıyor.
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
            $whereproductgroup=array( // ekleyen kullanicinin gecerli ust urun grubu bilgisi olup olmadigini sorgusunu hazirliyoruz
                "productgroup_id"=>$_arraydata["productgroup_id"],
                "deleted"=>null
            );
            $created_pg = $this->Productgroups_model->getproductgroup($whereproductgroup); // eklenecek olan urun grubunun gecerli olup olmadığını kontrol ediyoruz.
            if(!$created_pg) return 0; // ust urun grubu bilgisi gecerli degil ise negatif geri donus sagliyoruz
            $whereuser=array( // ekleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
                "users_id"=>$_arraydata["created_id"],
                "deleted"=>null
            );
            $created_user = $this->Users_model->getUser($whereuser); // ekleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
            $inserarray=array( // ekleyecegimi kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "subproductgroup_name"=>$_arraydata['subproductgroup_name'],
                "productgroup_id"=>$_arraydata['productgroup_id'],
                "created"=>date("Y-m-d H:i:s"), 
                "created_id"=>$_arraydata['created_id']
            );
            $results=$this->db->insert("sub_product_groups",$inserarray); // bilgileri veritabanına gönderiyoruz.
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
            $whereproductgroup=array( // ekleyen kullanicinin gecerli ust urun grubu bilgisi olup olmadigini sorgusunu hazirliyoruz
                "productgroup_id"=>$_arraydata["productgroup_id"],
                "deleted"=>null
            );
            $created_group = $this->Productgroups_model->getproductgroup($whereproductgroup); // eklenecek urun grubunun  gecerli olup olmadığını kontrol ediyoruz.
            if(!$created_group) return 0; // urun grubu bilgisi gecerli degil ise negatif geri donus sagliyoruz
            $updatearray=array( // güncellenecek urun alt grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "subproductgroup_name"=>$_arraydata['subproductgroup_name'],
                "subproductgroup_id"=>$_arraydata['subproductgroup_id'],
                "modified"=>date("Y-m-d H:i:s"), 
                "modified_id"=>$_arraydata['modified_id']
            );
            $results=$this->db->where("subproductgroup_id",$_arraydata['subproductgroup_id'])->update("sub_product_groups",$updatearray); // bilgileri veritabanına gönderiyoruz.
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
        /*$whereusers=array( // guncelleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "groups_id"=>$_arraydata["id"],
            "deleted"=>null,
        );
        $created_users = $this->Users_model->getUsers($whereusers); // silme islemi gerceklestirilecek grup ile ilgili kullanici kontrolu 
        if($created_users) return 0; // sorgu sonucu pozitifse negatif sonuç döndürüyoruz.
        */
        $deletearray=array( // güncellenecek alt urun grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "deleted"=>date("Y-m-d H:i:s"), 
            "deleted_id"=>$_arraydata['deleted_id']
        );
        $results=$this->db->where(["subproductgroup_id"=>$_arraydata['subproductgroup_id'],"deleted"=>null])->update("sub_product_groups",$deletearray); // bilgileri veritabanına gönderiyoruz.
        return $results; // işlem sonucunu geri gönderiyoruz      
    }
    public function get_sub_product_group($where=array()){
        try
        {
            if(!$where)return 0; // gelen id verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $groupdata=$this->db->where($where)->get("sub_product_groups")->result(); // alt urun grubu tablosundan tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
}
