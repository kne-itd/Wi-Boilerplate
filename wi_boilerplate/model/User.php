<?php
Class User extends CRUD
{

  private $user_id;		// int(11) auto_increment NULL(NO)
  private $email;		// varchar(200)  NULL(NO)
  private $password;		// varchar(255)  NULL(NO)
  private $level;		// set('admin','dealer')  NULL(NO)

  public function __construct(mysqli $mysqli)
  {
    $this->table_name = 'bilbixen_user';
    $this->primary_key = 'user_id';
    $this->db_connection = $mysqli;
  }


  public function getUser_id()
  {
    return $this->user_id;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getLevel()
  {
    return $this->level;
  }

  public function setUser_id($user_id)
  {
    $this->user_id = $user_id;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function setLevel($level)
  {
    $this->level = $level;
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
    'email' => $this->email,
    'password' => password_hash($this->password, PASSWORD_DEFAULT),
    'level' => $this->level
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
  public function FetchByEmail() 
  {
    $this->field_name = 'email';
    return parent::Read($this->email);
  }
  public function Login()
  {
    $sql = "SELECT * FROM $this->table_name WHERE email = '$this->email'";
    $res = $this->db_connection->query($sql);
    $row = $res->fetch_object();
    if (password_verify($this->password, $row->password)) {
      $_SESSION["auth"]["email"] = $row->email;
      $_SESSION["auth"]["password"] = $row->password;
      $_SESSION["auth"]["level"] = $row->level;
      return true;
    }
  return false;
  }
  public function Logout()
  {
      unset($_SESSION['auth']);
  }
  public function GeneratePassword($length = 8)
  {
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
      $password = substr( str_shuffle( $chars ), 0, $length );
      return $password;
  }
}
