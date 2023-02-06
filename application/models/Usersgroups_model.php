<?php
date_default_timezone_set("Europe/Istanbul"); //  zaman tarih referansını
class Usersgroups_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Users_model");  // ilgili kullanici tablosu modelimizi kullanici idlerini kontrol etmek üzere yüklüyoruz.
    }
    public function getall(){
        try
        {
            $data=$this->db->where(["deleted"=>null,"deleted_userid"=>null])->get("user_groups")->result(); // tüm sonuçları alıyoruz.
            echo json_encode( $data ); // $data dizesini json formatına döndürerek ekrana basıyor.
        }
        catch(Exception $e){
            //hata var ise burada yakalanır
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
        
    }
    public function addgroup($_arraydata){
        try
        {
            $whereuser=array( // ekleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
                "users_id"=>$_arraydata["created_userid"],
                "deleted"=>null
            );
            $created_user = $this->Users_model->getUser($whereuser); // ekleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz

            $inserarray=array( // ekleyecegimi kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "usergroup_name"=>$_arraydata['usergroup_name'],
                "created"=>date("Y-m-d H:i:s"), 
                "created_userid"=>$_arraydata['created_userid']
            );
            $results=$this->db->insert("user_groups",$inserarray); // bilgileri veritabanına gönderiyoruz.
            return $results; // işlem sonucunu geri gönderiyoruz
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderiyoruz
        }
    }
    public function updategroup($_arraydata){
        try
        {
            $whereuser=array( // guncelleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
                "users_id"=>$_arraydata["modifield_userid"],
                "deleted"=>null
            );
            $created_user = $this->Users_model->getUser($whereuser); // güncelleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
            if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
            
            $updatearray=array( // güncellenecek kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
                "usergroup_name"=>$_arraydata['usergroup_name'],
                "modified"=>date("Y-m-d H:i:s"), 
                "modifield_userid"=>$_arraydata['modifield_userid']
            );
            $results=$this->db->where("groups_id",$_arraydata['groups_id'])->update("user_groups",$updatearray); // bilgileri veritabanına gönderiyoruz.
            return $results; // işlem sonucunu geri gönderiyoruz
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderiyoruz    
        }
    }
    public function deletegroup($_arraydata){
        $whereuser=array( // guncelleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "users_id"=>$_arraydata["deleted_userid"],
            "deleted"=>null
        );
        $created_user = $this->Users_model->getUser($whereuser); // silme islemi gerceklestirecek kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
        
        $whereusers=array( // silen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "groups_id"=>$_arraydata["groups_id"],
            "deleted"=>null,
        );
        $created_users = $this->Users_model->getUsers($whereusers); // silme islemi gerceklestirilecek grup ile ilgili kullanici kontrolu 
        if($created_users) return 0; // sorgu sonucu pozitifse negatif sonuç döndürüyoruz.
       
        $deletearray=array( // silinecek kullanici grubu kaydinin aldigimiz veriler ile icerigini belirliyoruz.
            "deleted"=>date("Y-m-d H:i:s"), 
            "deleted_userid"=>$_arraydata['deleted_userid']
        );
        $results=$this->db->where("groups_id",$_arraydata['groups_id'])
        ->where("deleted",null)
        ->update("user_groups",$deletearray); // bilgileri veritabanına gönderiyoruz.
        return $results; // işlem sonucunu geri gönderiyoruz      
    }
    public function getUsergroup($where=array()){
        try
        {
            if(!$where)return 0; // gelen sorgu verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $groupdata=$this->db->where($where)->get("user_groups")->row(); // tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
    public function getUsergroups($where=array()){
        try
        {
            if(!$where)return 0; // gelen sorgu verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $groupdata=$this->db->where($where)->get("user_groups")->result(); // tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
}
