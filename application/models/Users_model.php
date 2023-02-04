<?php
date_default_timezone_set("Europe/Istanbul"); //  zaman tarih referansını
class Users_model extends CI_Model{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Usersgroups_model");  // ilgili kullanici tablosu modelimizi kullanici idlerini kontrol etmek üzere yüklüyoruz.
    }
    public function getall(){ // tüm listeyi çekiyor.
        
        $data=$this->db->select('users.users_id, users.user_name, users.created, users.modified, users.deleted, user_groups.usergroup_name')->where("users.deleted",null)
        ->join("user_groups","users.groups_id=user_groups.groups_id",'inner')
        ->get("users")
        ->result(); // users tablosundan tüm sonuçları alıyor.
        echo json_encode( $data ); // $data dizesini json formatına döndürerek ekrana basıyor.
    }
    public function add($_arraydata){
        $whereusergroup=array( // ekleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "groups_id"=>$_arraydata["groups_id"],
            "deleted"=>null
        );
        $created_groups = $this->Usersgroups_model->getUsergroup($whereusergroup); // eklenecek kullanici grubu sorgusu yapiliyor
        if(!$created_groups) return 0; // grup bilgisi gecerli degil ise negatif geri donus sagliyoruz  
        $_arraydata['created']=date("Y-m-d H:i:s"); // created tarihi oluşturuyoruz.
        $results=$this->db->insert("users",$_arraydata); // bilgileri veritabanına gönderiyoruz.
        return $results; // işlem sonucunu geri gönderiyoruz
    }
    public function update($_updatearray){ 
        $whereusergroup=array( // ekleyen kullanicinin gecerli olup olmadigi sorgusunu hazirliyoruz
            "groups_id"=>$_updatearray["groups_id"],
            "deleted"=>null
        );
        $created_groups = $this->Usersgroups_model->getUsergroup($whereusergroup); // eklenecek kullanıcı grubu sorgusu yapiliyor
        if(!$created_groups) return 0; // grup bilgisi gecerli degil ise negatif geri donus sagliyoruz  
        $whereuser=array( // guncelleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "users_id"=>$_updatearray["modified_id"],
            "deleted"=>null
        );
        $created_user = $this->Users_model->getUser($whereuser); // güncelleyen kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
        $lastupdate_array=array(// gondermek istedigimiz veriler için dize oluşturuyoruz.
            "user_name"=> $_updatearray["user_name"], 
            "modified"=> date("Y-m-d H:i:s"),
            "groups_id"=> $_updatearray["groups_id"],
            "modified_id"=> $_updatearray["modified_id"]
        );
        return $updateresult=$this->db->where("users_id",$_updatearray['users_id'])->update("users",$lastupdate_array);// oluşturduğumuz son dizeyi veritabanına gönderiyoruz. 
       
       
    }
    public function delete($_delarray){
        
        $whereuser=array( // guncelleyen kullanicinin gecerli olup olmadigini sorgusunu hazirliyoruz
            "users_id"=>$_delarray["deleted_id"],
            "deleted"=>null
        );
        $created_user = $this->Users_model->getUser($whereuser); // silme islemi gerceklestirecek kullanicinin hazirladigimiz sorgu ile bilgilerini cekiyoruz. 
        if(!$created_user) return 0; // kullanici bilgisi gecerli degil ise negatif geri donus sagliyoruz
        $deletearray=array( // silinme tarihini eklemek için veritabanına gönderilecek düzenlenen bilgileri dize içerisine alıyoruz.
            "deleted" => date("Y-m-d H:i:s"),
            "deleted_id" => $_delarray["deleted_id"]
        );
        $result=$this->db
        ->where("users_id",$_delarray['users_id'])
        ->where("deleted",null)
        ->update("users",$deletearray);// oluşturduğumuz son dizeyi veritabanına gönderiyoruz.
        return $result; // olusan sonucu geri gonderiyoruz.
       
    }
    public function getUser($where=array()){
        try
        {
            if(!$where)return 0; // gelen id verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $userdata=$this->db->where($where)->get("users")->row(); // users tablosundan tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
    public function getUsers($where=array()){
        try
        {
            if(!$where)return 0; // gelen sorgu verisi pozitif değil ise geri dönüş sağlıyoruz.
            return $userdata=$this->db->where($where)->get("users")->result(); // users tablosundan tüm sonuçları alıyor ve geri gönderiyoruz.
        }
        catch(Exception $e){
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
}

?>