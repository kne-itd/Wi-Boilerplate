<?php
Class Category extends CRUD
{

  private $category_id;		// int(11) auto_increment NULL(NO)
  private $category;		// varchar(100)  NULL(NO)

  public function __construct(mysqli $mysqli)
  {
    $this->table_name = 'bilbixen_category';
    $this->primary_key = 'category_id';
    $this->db_connection = $mysqli;
  }


  public function getCategory_id()
  {
    return $this->category_id;
  }

  public function getCategory()
  {
    return $this->category;
  }

  public function setCategory_id($category_id)
  {
    $this->category_id = $category_id;
  }

  public function setCategory($category)
  {
    $this->category = $category;
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
    'category' => $this->category
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
  public function Fetch($id = null) 
  {
    $this->field_name = $this->primary_key;
    return parent::Read($id);
  }

}
