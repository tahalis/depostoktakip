<?php 
class Stocks_controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Stocks_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
    }
    public function index(){
        $results= $this->Stocks_model->getall(); // verileri almak icin modelimizin ilgili metoduna erişiyoruz.
        return $results; // gelen verileri geri gönderiyoruz.
    }
    public function add(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.

        // ilk olarak giris ve cikis parametrelerini sorguluyoruz
        if(isset($_arraydata['entries']) && isset($_arraydata['outputs']) || !isset($_arraydata['entries']) && !isset($_arraydata['outputs'])){
            echo "Giris ve cikis degerleri bir kullanilamaz ya da bos birakilamaz.";
            die();
        }
        else 
        {
            // kayit giris tipini belirliyoruz
            if(isset($_arraydata['entries']) && $_arraydata['entries']>0)$_arraydata["record_type"]="entries"; // stok giris verisini kontrol edip giris yada cikis yapilacak oldugunu belirliyoruz.
            else $_arraydata["record_type"]="outputs";

            // verileri kontrol ediyoruz /*
            if(!isset($_arraydata['stockcard_id']) || !isset($_arraydata['stores_id']) || !isset($_arraydata['shelve_id']) || !isset($_arraydata['details'])){ 
                echo "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
                die();
            }
            
            $results= $this->Stocks_model->add($_arraydata); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
            echo $results; // gelen sonucu kullaniciya gonderiyoruz
        }
    }
    public function update(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.

        // ilk olarak giris ve cikis parametrelerini sorguluyoruz
        if(isset($_arraydata['entries']) && isset($_arraydata['outputs']) || !isset($_arraydata['entries']) && !isset($_arraydata['outputs'])){
            echo "Giris ve cikis degerleri bir kullanilamaz ya da bos birakilamaz.";
            die();
        }
        else 
        {
            // kayit giris tipini belirliyoruz
            if(isset($_arraydata['entries']) && $_arraydata['entries']>0)$_arraydata["record_type"]="entries"; // stok giris verisini kontrol edip giris yada cikis yapilacak oldugunu belirliyoruz.
            else $_arraydata["record_type"]="outputs";

            // verileri kontrol ediyoruz /*
            if(!isset($_arraydata['stocks_id']) || !isset($_arraydata['stockcard_id']) || !isset($_arraydata['stores_id']) || !isset($_arraydata['shelve_id']) || !isset($_arraydata['details'])){
                echo  "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
                die();
            }
            
            $results= $this->Stocks_model->update($_arraydata); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
            echo $results; // gelen sonucu kullaniciya gonderiyoruz
        }
    }
    public function delete(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.

        // verileri kontrol ediyoruz /*
        if(!isset($_arraydata['stocks_id']) || !isset($_arraydata['deleted_id'])) {
            echo  "Bilgiler bos birakilamaz"; // istediğimiz bilgileri kontrol ediyoruz.
            die();
        }
        
        $results= $this->Stocks_model->delete($_arraydata); // gelen dizeyi modele guncellemek üzere gönderiyoruz.
        echo $results; // gelen sonucu kullanici gonderiyoruz
        
    }

}

