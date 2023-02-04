<?php

class Storage_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Stores_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        
    }
    
	public function index(){
         // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $results= $this->Stores_model->getall(); // verileri almak icin modelimizin ilgili metoduna erişiyoruz.
        return $results; // gelen verileri geri gönderiyoruz.
	}
    public function add(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        if($_arraydata['stores_name']=="" || $_arraydata['stores_name']==" " ||  $_arraydata['created_id']=="" ||!isset($_arraydata['stores_name']) || !isset($_arraydata['created_id'])) return "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
        $results= $this->Stores_model->add($_arraydata); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($results)echo "Kayit Basarili."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Kayit Basarisiz";
    }
    public function update(){
        $_updatearray = json_decode(file_get_contents('php://input'), true);  // gelen json veriyi dize olarak sakliyoruz.
        if($_updatearray['stores_name']=="" || $_updatearray['stores_name']==" " ||  $_updatearray['modified_id']=="" ||!isset($_updatearray['stores_name']) || !isset($_updatearray['modified_id'])) return "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
        $updateresult= $this->Stores_model->update($_updatearray); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($updateresult)echo $_updatearray['stores_id']." Numarali Depo duzenlendi."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo $_updatearray['stores_id']." Numarali Depo duzenlenemedi";
    }
    public function delete(){
       
        $_delarray = json_decode(file_get_contents('php://input'), true);   // gelen json veriyi dize olarak sakliyoruz.
        if($_delarray['stores_id']=="" || $_delarray['stores_id']==" " ||  $_delarray['deleted_id']=="" ||!isset($_delarray['stores_id']) || !isset($_delarray['deleted_id'])) return "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
        $result= $this->Stores_model->delete($_delarray); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($result)echo $_delarray["stores_id"]." Numarali Depo Silindi.";  // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Belirtilen Depo silinemedi.";
    }
}
