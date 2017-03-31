<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management extends MY_Controller {
    
    public function index()
    {
//        $this->load->helper('text');
//
//        $r = $this->db->query("SELECT * FROM slogans WHERE id=(SELECT max(id) FROM slogans)");
//        $slogans = $r->result();
//
//        $r = $this->db->query("SELECT * FROM blog ORDER BY id DESC");
//        $blog = $r->result();

//        $this->data['js_plugins'] = 
//        '<script type="text/javascript" src="'.base_url().'style/bs/js/pages/home.js"></script>';
        
        $post = array();
        $where = "";
        if( !empty($this->input->post()) ){
            $post = $this->input->post();
            
            $dateWhere = "";
            if($post['searchPeriod'] == 2){
                $dateWhere = " ord.date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
            }else if($post['searchPeriod'] == 3){
                $dateWhere = " ord.date BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()";
            }else{
                $dateWhere = "";
            }
            $userProductWhere = "";
            if( !empty($post['searchField']) ){
                
                if($post['searchPeriod'] == 1){
                    $userProductWhere = " CONCAT(usr.firstName, ' ', usr.lastName) LIKE '".htmlentities($post['searchField'])."' OR prdc.name LIKE '".htmlentities($post['searchField'])."'";
                }else{
                    $userProductWhere = " AND (CONCAT(usr.firstName, ' ', usr.lastName) LIKE '".htmlentities($post['searchField'])."' OR prdc.name LIKE '".htmlentities($post['searchField'])."')";
                }
            }
            $where = ($post['searchPeriod'] == 1 && empty($userProductWhere) ) ? "" : " WHERE".$dateWhere.$userProductWhere;
        }
        
        $r = $this->db->query("SELECT * FROM users");
        $users = $r->result();
        $r = $this->db->query("SELECT * FROM products");
        $products = $r->result();
        $r = $this->db->query("SELECT * FROM search_filters");
        $searchFilters = $r->result();
        
        $indexQuery = "SELECT CONCAT(usr.firstName, ' ', usr.lastName) as userName, 
            ord.id,
            prdc.name as productName, 
            prdc.price as productPrice, 
            prdc.currency as productCurr, 
            prdc.discount as discount, 
            ord.qty, 
            ord.total, 
            ord.date 
            FROM orders as ord 
            LEFT JOIN users as usr on (ord.userID = usr.id) 
            LEFT JOIN products as prdc on (ord.productID = prdc.id)".$where;
        $r = $this->db->query($indexQuery);
        $orders = $r->result();
        
        $this->data['users'] = $users;
        $this->data['products'] = $products;
        $this->data['searchFilters'] = $searchFilters;
        $this->data['orders'] = $orders;
        $this->data['content'] = 'management/index';
        $this->data['title'] = 'Management App';
        $this->load->view($this->layout, $this->data);
    }
    
    public function addOrder(){
        
        
        if( empty($this->input->post())){
            redirect('/error');
        }
        $post = $this->input->post();
        
        $r = $this->db->query("SELECT * FROM products WHERE id=".htmlentities($post['productID'], true));
        $products = end($r->result());
        
        $total = $this->calcDiscount(3, $post['qty'], $products->price, $products->discount/100);
        
        $data = array(
            'productID' => $post['productID'] ,
            'userID' => $post['userID'] ,
            'qty' => $post['qty'],
            'total' => $total
        );
        $this->db->insert('orders', $data); 
        redirect('management');
    }
    public function edit($id){
        
        $this->data['js_plugins'] = 
        '<script type="text/javascript" src="'.base_url().'style/bs/js/pages/management.js"></script>';
                
        if( is_null($id)){
            redirect('/error');
        }
        $id = intval($id, 10);
        
        $r = $this->db->query("SELECT * FROM orders WHERE id=".$id);
        $orders = $r->result();
        
        if($orders == null){
            exit("Wrong page ID");
        }
        $orders = end($orders);
        
        $r = $this->db->query("SELECT * FROM users");
        $users = $r->result();
        
        $r = $this->db->query("SELECT * FROM products");
        $products = $r->result();
        
        $r = $this->db->query("SELECT discount FROM products 
                RIGHT JOIN orders ON (products.id = orders.productID)
                WHERE orders.id =".$id);
        $currProductDiscount = end($r->result());
        
        $this->data['orderID'] = $id;
        $this->data['currProductDiscount'] = $currProductDiscount->discount;
        $this->data['users'] = $users;
        $this->data['products'] = $products;
        $this->data['orders'] = $orders;
        $this->data['content'] = 'management/edit';
        $this->data['title'] = 'Management - edit order';
        $this->load->view($this->layout, $this->data);
    }
    
    public function getProductPrice ($productID, $mimeType = false){
        $r = $this->db->query("SELECT price, discount FROM products WHERE id=".htmlentities($productID, true));
        $products = $r->result();
        if ($mimeType == true){
            echo json_encode($products[0]);
            return true;
        }
        return $products[0]->price;
    }
    
    public function calcDiscount($discountQTY, $qty, $price, $discount, $mimeType = false){
        $total = 0.00;
        $curTotal = $price * $qty;
        if( $qty >= $discountQTY && $discount > 0 ){
            $total = number_format(
                    (float)($curTotal - ($curTotal * $discount ))
                    , 2, '.', '');
        }else{
            $total = number_format(
                    (float)($curTotal)
                    , 2, '.', '');
        }
        if($mimeType == true){
            echo json_encode($total);
            return true;
        }
        return $total;
    }
    
    public function editOrder(){
        if( empty($this->input->post())){
            redirect('/error');
        }
        $post = $this->input->post();
        
        $r = $this->db->query("SELECT * FROM products WHERE id=".$post['productID']);
        $products = end($r->result());
                
//        $total = $this->calcDiscount(3, $post['qty'], $products->price, (float)($products->discount/100));
        
        $data = array(
            'productID' => $post['productID'] ,
            'userID' => $post['userID'] ,
            'qty' => $post['qty'],
            'total' => $post['total']
        );
        
        $this->db->where('id', htmlentities($post['orderID'], true));
        $this->db->update('orders', $data);
        redirect('management');
    }
    public function delete($id){
        $id = intval($id, 10);
        $this->load->helper('url');
        
        $this->db->delete('orders', array('id' => $id));
        redirect('/management', 'refresh');
    }
      	
}
