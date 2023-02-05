<?php
class Search_contoller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Productgroups_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $this->load->model("Shelves_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $this->load->model("Stockcards_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $this->load->model("Stocks_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $this->load->model("Stores_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $this->load->model("Sub_Productgroups_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $this->load->model("Users_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        $this->load->model("Usersgroups_model");  // ilgili modelimizi kullanmak üzere yüklüyoruz.
        
    }
    public function kullanicilar(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results=$this->Users_model->getUsers($_arraydata); // Json dan oluşturulan dizeyi modele gönderiyoruz.
        echo json_encode( $results ); // sonuçları tekrar json formatina çevirip kullaniciya gonderiyoruz.
    }
    public function kullanicigruplari(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results=$this->Usersgroups_model->getUsergroups($_arraydata); // Json dan oluşturulan dizeyi modele gönderiyoruz.
        echo json_encode( $results ); // sonuçları tekrar json formatina çevirip kullaniciya gonderiyoruz.
    }
    public function depolar(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results=$this->Stores_model->getstores($_arraydata); // Json dan oluşturulan dizeyi modele gönderiyoruz.
        echo json_encode( $results ); // sonuçları tekrar json formatina çevirip kullaniciya gonderiyoruz.
    }
    public function raflar(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results=$this->Shelves_model->getshelve($_arraydata); // Json dan oluşturulan dizeyi modele gönderiyoruz.
        echo json_encode( $results ); // sonuçları tekrar json formatina çevirip kullaniciya gonderiyoruz.
    }
    public function urungruplari(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results=$this->Productgroups_model->getproductgroup($_arraydata); // Json dan oluşturulan dizeyi modele gönderiyoruz.
        echo json_encode( $results ); // sonuçları tekrar json formatina çevirip kullaniciya gonderiyoruz.
    }
    public function alturungruplari(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results=$this->Sub_Productgroups_model->get_sub_product_group($_arraydata); // Json dan oluşturulan dizeyi modele gönderiyoruz.
        echo json_encode( $results ); // sonuçları tekrar json formatina çevirip kullaniciya gonderiyoruz.
    }
    public function stokkartlari(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results=$this->Stockcards_model->get_stok_cards($_arraydata); // Json dan oluşturulan dizeyi modele gönderiyoruz.
        echo json_encode( $results ); // sonuçları tekrar json formatina çevirip kullaniciya gonderiyoruz.
    }
    public function stokhareketleri(){
        $_arraydata = json_decode(file_get_contents('php://input'), true); // gelen json veriyi dize olarak sakliyoruz.
        $results=$this->Stocks_model->gets_stocks_list($_arraydata); // Json dan oluşturulan dizeyi modele gönderiyoruz.
        echo json_encode( $results ); // sonuçları tekrar json formatina çevirip kullaniciya gonderiyoruz.
    }

}