<?php

class Shelves_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Shelves_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        
    }
    
	public function index(){
       
        $results= $this->Shelves_model->getall(); // verileri almak icin modelimizin ilgili metoduna erişiyoruz.
        return $results; // gelen verileri geri gönderiyoruz.
	}
    public function add(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        if(!isset($_arraydata['shelve_name']) || !isset($_arraydata['created_id'])){
             echo "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
             die();
        }
        $results= $this->Shelves_model->add($_arraydata); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($results)echo "Kayit Basarili."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Kayit Basarisiz";
    }
    public function update(){
        $_updatearray = json_decode(file_get_contents('php://input'), true);  // gelen json veriyi dize olarak sakliyoruz.
        if(!isset($_updatearray['shelve_name']) || !isset($_updatearray['modified_id'])){
             echo "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
             die();
        }
        $updateresult= $this->Shelves_model->update($_updatearray); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($updateresult)echo $_updatearray['shelve_id']." Numarali Raf duzenlendi."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo $_updatearray['shelve_id']." Numarali Raf duzenlenemedi";
    }
    public function delete(){
       
        $_delarray = json_decode(file_get_contents('php://input'), true);   // gelen json veriyi dize olarak sakliyoruz.
        if(!isset($_delarray['shelve_id']) || !isset($_delarray['deleted_id'])){
            echo "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
            die();
        }
        $result= $this->Shelves_model->delete($_delarray); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($result)echo $_delarray["shelve_id"]." Numarali Depo Silindi.";  // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Belirtilen Depo silinemedi.";
    }
}
