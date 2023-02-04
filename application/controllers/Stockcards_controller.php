<?php

class Stockcards_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Stockcards_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
    }
    
	public function index(){
       
        $results= $this->Stockcards_model->getall(); // verileri almak icin modelimizin ilgili metoduna erişiyoruz.
        return $results; // gelen verileri geri gönderiyoruz.
	}
    public function add(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        if(!isset($_arraydata['productname']) || !isset($_arraydata['created_id'])){echo  "Bilgiler bos birakilamaz";die(); } // istediğimiz bilgileri kontrol ediyoruz.
        $results= $this->Stockcards_model->add($_arraydata); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($results)echo "Kayit Basarili."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Kayit Basarisiz";
    }
    public function update(){
        $_updatearray = json_decode(file_get_contents('php://input'), true);  // gelen json veriyi dize olarak sakliyoruz.
        if(!isset($_updatearray['stockcard_id']) ||!isset($_updatearray['productname']) || !isset($_updatearray['modified_id'])) {echo "Bilgiler bos birakilamaz";die();} // istediğimiz bilgileri kontrol ediyoruz.
        $updateresult= $this->Stockcards_model->update($_updatearray); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($updateresult)echo $_updatearray['stockcard_id']." Numarali Stok Karti duzenlendi."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo $_updatearray['stockcard_id']." Numarali Stok Karti duzenlenemedi";
    }
    public function delete(){
        $_delarray = json_decode(file_get_contents('php://input'), true);   // gelen json veriyi dize olarak sakliyoruz.
        if(!isset($_delarray['stockcard_id']) || !isset($_delarray['deleted_id'])){echo "Bilgiler bos birakilamaz";die();} // istediğimiz bilgileri kontrol ediyoruz.
        $result= $this->Stockcards_model->delete($_delarray); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($result)echo $_delarray["stockcard_id"]." Numarali Stok Karti Silindi.";  // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Belirtilen Stok Karti silinemedi.";
    }
}
