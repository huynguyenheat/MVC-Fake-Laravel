<?php
class Product extends Model{
    public $product_id;
    public $name;
    public $description;
    public $price;
    public $default_picture;

    public function get(){
        $SQL = 'SELECT Product.*, filename FROM Product LEFT JOIN Picture ON Product.default_picture = Picture.picture_id';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $stmt->fetchAll();
    }

    public function create(){
        $SQL = 'INSERT INTO Product(name, description, price) VALUE(:name, :description, :price)';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['name'=>$this->name, 'description'=>$this->description, 'price'=> $this->price]);
        return $stmt->rowCount();
    }

    public function find($product_id){
        $SQL = 'SELECT Product.*, filename FROM Product LEFT JOIN Picture ON Product.default_picture = Picture.picture_id WHERE Product.product_id=:product_id';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['product_id'=>$product_id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $stmt->fetch();
    }

    public function update(){
        $SQL = 'UPDATE Product SET name=:name, description=:description, price=:price, default_picture=:default_picture WHERE product_id=:product_id';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['name'=>$this->name, 'default_picture'=>$this->default_picture, 'description'=>$this->description, 'price'=> $this->price, 'product_id'=>$this->product_id]);
        return $stmt->rowCount();
    }

    public function delete(){
        $SQL = 'DELETE FROM Product WHERE product_id=:product_id';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['product_id'=>$this->product_id]);
        return $stmt->rowCount();
    }
}
?>