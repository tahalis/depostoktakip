<?php
class Usersgroups_controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model("Usersgroups_model"); // kullanacagimiz ilgili modeli yukluyoruz.
    }
    public function index(){
        $results= $this->Usersgroups_model->getall(); // verileri almak icin modelimizin ilgili metoduna erişiyoruz.
        return $results; // metoddan gelen veriyi kullaniciya geri gönderiyoruz.
    }
    public function addgroup(){
        try
        {
            $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
            if($_arraydata['usergroup_name']=="" || $_arraydata['usergroup_name']==" " ||  $_arraydata['created_userid']=="" ||!isset($_arraydata['usergroup_name']) || !isset($_arraydata['created_userid'])) return "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
            $results= $this->Usersgroups_model->addgroup($_arraydata); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
            if($results)echo "Kayit Basarili."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
            else echo "Kayit Basarisiz";
        }
        catch(Exception $e)
        {
            echo "Hata ile karsilasildi. ".$e->getMessage(); //hata çıktısı kullaniciya gonderilir.
        }
    }
    public function updategroup(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        if($_arraydata['usergroup_name']=="" || $_arraydata['groups_id']=="" ||  $_arraydata['modifield_userid']=="" ||!isset($_arraydata['usergroup_name']) || !isset($_arraydata['modifield_userid']) || !isset($_arraydata['groups_id'])) return "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
        $results= $this->Usersgroups_model->updategroup($_arraydata); // gelen dizeyi modele güncellenmek üzere gönderiyoruz.
        if($results)echo "Kayit Guncellendi."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Kayit Guncellenemedi";
    }
    public function deletegroup(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        if(!$_arraydata["groups_id"] || !$_arraydata["deleted_userid"])return 0; // gelen verilerin pozitif olup olmadığına dikkat ediyoruz.
        $results=$this->Usersgroups_model->deletegroup($_arraydata); // modele ilgili verileri silinmek üzere gönderiyoruz.
        if($results)echo "Kayit Silindi."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Kayit Silinemedi";
    }
}

?>