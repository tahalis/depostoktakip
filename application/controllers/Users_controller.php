<?php

class Users_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Users_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        
    }
    
	public function index(){
         // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $results= $this->Users_model->getall(); // verileri almak icin modelimizin ilgili metoduna erişiyoruz.
        return $results; // gelen verileri geri gönderiyoruz.
	}
    public function add_users(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results= $this->Users_model->add($_arraydata); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($results)echo "Kayit Basarili."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Kayit Basarisiz";
    }
    public function update_user(){
       
        $_updatearray = json_decode(file_get_contents('php://input'), true);  // gelen json veriyi dize olarak sakliyoruz.
        $updateresult= $this->Users_model->update($_updatearray); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($updateresult)echo $_updatearray['users_id']." Numarali Kullanici duzenlendi."; // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo $_updatearray['users_id']." Numarali Kullanici duzenlenemedi";
    }
    public function del_user(){
       
        $_delarray = json_decode(file_get_contents('php://input'), true);   // gelen json veriyi dize olarak sakliyoruz.
        $result= $this->Users_model->delete($_delarray); // gelen dizeyi modele kaydolmak üzere gönderiyoruz.
        if($result)echo $_delarray["users_id"]." Numarali Kullanici Silindi.";  // modelden gelen cevap pozitif ise başarılı değil ise başarısız olarak geri döndürüyoruz. 
        else echo "Belirtilen kullanici silinemedi.";
    }
}
