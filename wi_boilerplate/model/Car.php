<?php
Class Car extends CRUD
{

  private $car_id;		// int(11) auto_increment NULL(NO)
  private $brand;		// varchar(100)  NULL(NO)
  private $model;		// varchar(100)  NULL(NO)
  private $reg_date;		// date  NULL(NO)
  private $doors;		// tinyint(2)  NULL(NO)
  private $mileage;		// int(11)  NULL(NO)
  private $price;		// int(11)  NULL(NO)
  private $image;                // varchar NULL[YES)
  private $category_id;		// int(11)  NULL(NO)

  public function __construct(mysqli $mysqli)
  {
    $this->table_name = 'bilbixen_car';
    $this->primary_key = 'car_id';
    $this->db_connection = $mysqli;
  }


  public function getCar_id()
  {
    return $this->car_id;
  }

  public function getBrand()
  {
    return $this->brand;
  }

  public function getModel()
  {
    return $this->model;
  }

  public function getReg_date()
  {
    return $this->reg_date;
  }

  public function getDoors()
  {
    return $this->doors;
  }

  public function getMileage()
  {
    return $this->mileage;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function getCategory_id()
  {
    return $this->category_id;
  }
  
  public function getImage() {
      return $this->image;
  }

  public function setCar_id($car_id)
  {
    $this->car_id = $car_id;
  }

  public function setBrand($brand)
  {
    $this->brand = $brand;
  }

  public function setModel($model)
  {
    $this->model = $model;
  }

  public function setReg_date($reg_date)
  {
    $this->reg_date = $reg_date;
  }

  public function setDoors($doors)
  {
    $this->doors = $doors;
  }

  public function setMileage($mileage)
  {
    $this->mileage = $mileage;
  }

  public function setPrice($price)
  {
    $this->price = $price;
  }
  
  public function setImage($image) {
      $this->image = $image;
  }

  public function setCategory_id($category_id)
  {
    $this->category_id = $category_id;
  }

  /** 
  * property "fieldname_and_value" of parent class CRUD 
  * needs to bes set with an associative array 
  *  
  * @return Integer mysqli->insert_id on success, String error-message containg mysqli->err_no on failure 
  */

  public function Save()
  {
    unset($this->fieldname_and_value);
    $this->fieldname_and_value = array(
    'brand' => $this->brand,
    'model' => $this->model,
    'reg_date' => $this->reg_date,
    'doors' => $this->doors,
    'mileage' => $this->mileage,
    'price' => $this->price,
    'image' => $this->image,
    'category_id' => $this->category_id
    );

    return parent::Create();
  }
  /** 
  * property "fieldname_and_value" of parent class CRUD 
  * needs to bes set with an associative array 
  *  
  * @return Integer mysqli->insert_id  
  */

  public function Delete()
  {
    unset($this->fieldname_and_value);
    $PK = $this->primary_key;
    $this->fieldname_and_value[$this->primary_key] = $this->$PK;
    return parent::Delete();
  }
  /** 
  * property "fieldname_and_value" of parent class CRUD 
  * needs to bes set with an associative array 
  *  
  * @return Boolean  on success, String error-message containg mysqli->err_no on failure 
  */

  public function Edit($fields_to_update)
  {
    unset($this->fieldname_and_value);
    $this->field_name = $this->primary_key;
    foreach ($fields_to_update as $value) {
  	    $this->fieldname_and_value[$value] = $this->$value;
    }
    $PK = $this->primary_key;
    return parent::Update($this->$PK);
  }
  /**
   * 
   * @param  $id optional. If provided, it indicates the id/name/... of the query
   * The method defauls to use the primary field for querying
   * @return Array 
   */
  public function Fetch($id = null) 
  {
    $this->field_name = $this->primary_key;
    return parent::Read($id);
  }
  
  public function FetchWithCategory($id = null)
  {
      $this->field_name = $this->primary_key;
              $sql = "SELECT * FROM $this->table_name "
                      . "INNER JOIN bilbixen_category ON "
                      . "($this->table_name.category_id = bilbixen_category.category_id)";
        
        if ($id) {
//            $sql .= " WHERE $this->field_name = '$id'";
            $sql .= " WHERE $this->field_name = ?";
        }
	if ($this->order_by) {
	    $sql .= " ORDER BY $this->order_by";
	}
//        echo $sql; 
        $stmt = $this->db_connection->prepare($sql);
        if ($id) {
            $stmt->bind_param('s', $id);
        }
        
        $stmt->execute();
        $res = $stmt->get_result();
        $output = array();
        while ($row = $res->fetch_object()) {
            $output[] = $row;
        }
        return $output;
  }

}
