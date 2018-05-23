<?php

/**
 * Description of Scaffold
 *
 * @author kaj
 */
class Scaffold {

    private $db_connection;
    private $db_name;
    private $db_tables = array();
    private $primary_key;
    private $propertylist;

    public function __construct(mysqli $db_connection, $db_name) 
    {
	$this->db_connection = $db_connection;
	$this->db_name = $db_name;
    }

    private function GetTables($prefix = null)
    {
	$sql = "SHOW TABLES ";
	if ($prefix) {
	    $sql .= "WHERE Tables_in_$this->db_name LIKE '$prefix%'";
	}

	$res = $this->db_connection->query($sql);
//	$output = array();
	while ($row = $res->fetch_object()) {
//	    $output[] = $row;
            $this->db_tables[] = $row;
	}
	return $this->db_tables;
    }
    
    private function getProperties($table_name)
    {
	 $sql = 'SHOW COLUMNS FROM ' . $table_name;
        unset($this->propertylist);
            
        try {    
            $res = $this->db_connection->query($sql);
            
            if ($res) {
                while ($array = $res->fetch_assoc()){
		    $this->propertylist[] = $array;
                    if ($array['Key'] == 'PRI') {
                        $this->primary_key = $array['Field'];
                    }
                    
		    $output .= PHP_EOL;
		    $output .=  '  private $' . $array['Field'] . ';		// ' . $array['Type'] .' '. $array['Extra'] . ' NULL(' . $array['Null'] .')';
                    $output .= (!empty($array['Default'] )) ? ' Default(' . $array['Default'] . ')' : '';
                } 
                $output .= PHP_EOL . PHP_EOL;

            }
            return $output;
        } catch (Exception $e){
                echo  $e->getMessage(); //return exception
        }  

    }
    
    private function CreateConstructor($table_name)
    {
	$output = '';
	$output .= '  public function __construct(mysqli $mysqli)' . PHP_EOL
	. '  {' . PHP_EOL
	. '    $this->table_name = \'' . $table_name . '\';' . PHP_EOL
	. '    $this->primary_key = \'' . $this->primary_key . '\';' . PHP_EOL
	. '    $this->db_connection = $mysqli;' . PHP_EOL
	. '  }'. PHP_EOL;	
	return $output;
    }
    
    private function CreateGetSet()
    {
	$getters = '';
	$setters = '';
	foreach ( $this->propertylist as $property) {
//	    print_r($property) ;
	    $getters .= '  public function get' . ucfirst($property['Field']) . '()' .PHP_EOL;
	    $getters .= '  {' . PHP_EOL;
	    $getters .= '    return $this->' . $property['Field'] . ';' . PHP_EOL;
	    $getters .= '  }' . PHP_EOL . PHP_EOL;
	    
	    $setters .= '  public function set' . ucfirst($property['Field']) . '($' . $property['Field'] . ')' .PHP_EOL;
	    $setters .= '  {' . PHP_EOL;
	    $setters .= '    $this->' . $property['Field'] . ' = $' . $property['Field'] . ';' . PHP_EOL;
	    $setters .= '  }' . PHP_EOL . PHP_EOL;
	    
	}
	return $getters . $setters;
    }
    
    private function CreateSaveMethod()
    {
	$output = '';
	$output = '  /**' . PHP_EOL;
	$output .= '  * property "fieldname_and_value" of parent class CRUD' . PHP_EOL;
	$output .= '  * needs to bes set with an associative array' . PHP_EOL;
	$output .= '  * ' .PHP_EOL;
	$output .= '  * @return Integer mysqli->insert_id on success, String error-message containg mysqli->err_no on failure' . PHP_EOL;
	$output .= '  */' . PHP_EOL . PHP_EOL;
	 
	 $output .= '  public function Save()' . PHP_EOL;
	 $output .= '  {' . PHP_EOL;
         $output .= '    unset($this->fieldname_and_value);' . PHP_EOL;
	 $output .= '    $this->fieldname_and_value = array(' . PHP_EOL;
	 foreach ( $this->propertylist as $property) {
	     if ($property['Extra'] == 'auto_increment') {
		 continue;
	     }
	     $output .= "    '" . $property['Field'] . "'" . ' => $this->' . $property['Field'] . ','  . PHP_EOL;
	 }
	 $output = rtrim($output, ",".PHP_EOL);
	 $output .= PHP_EOL . '    );' . PHP_EOL . PHP_EOL;
	 $output .= '    return parent::Create();' . PHP_EOL;
	 $output .= '  }' . PHP_EOL;
	 return $output;
    }
    
    private function CreateDeleteMethod()
    {
	$output = '';
	$output = '  /**' . PHP_EOL;
	 $output .= '  * property "fieldname_and_value" of parent class CRUD' . PHP_EOL;
	 $output .= '  * needs to bes set with an associative array' . PHP_EOL;
	 $output .= '  * ' . PHP_EOL;
	 $output .= '  * @return Integer mysqli->insert_id ' . PHP_EOL;
	 $output .= '  */' . PHP_EOL . PHP_EOL;
	 
	 $output .= '  public function Delete()' . PHP_EOL;
	 $output .= '  {' . PHP_EOL;
         $output .= '    unset($this->fieldname_and_value);' . PHP_EOL;
         $output .= '    $PK = $this->primary_key;'  . PHP_EOL;
	 $output .= '    $this->fieldname_and_value[$this->primary_key] = $this->$PK;'. PHP_EOL;
        $output .= '    return parent::Delete();'. PHP_EOL;
	$output .= '  }' . PHP_EOL;
	 return $output;
    }
    
    private function CreateEditMethod()
    {
	$output = '';
	$output = '  /**' . PHP_EOL;
	 $output .= '  * property "fieldname_and_value" of parent class CRUD' . PHP_EOL;
	 $output .= '  * needs to bes set with an associative array' . PHP_EOL;
	 $output .= '  * ' . PHP_EOL;
	 $output .= '  * @return Boolean  on success, String error-message containg mysqli->err_no on failure' . PHP_EOL;
	 $output .= '  */' . PHP_EOL . PHP_EOL;
	 
	 $output .= '  public function Edit($fields_to_update)' . PHP_EOL;
	 $output .= '  {' . PHP_EOL;
         $output .= '    unset($this->fieldname_and_value);' . PHP_EOL;
	 $output .= '    $this->field_name = $this->primary_key;' . PHP_EOL;
	 $output .= '    foreach ($fields_to_update as $value) {'  . PHP_EOL;
	 $output .= '  	    $this->fieldname_and_value[$value] = $this->$value;'  . PHP_EOL;
	 $output .= '    }'  . PHP_EOL;
         $output .= '    $PK = $this->primary_key;'  . PHP_EOL;
	 $output .= '    return parent::Update($this->$PK);' . PHP_EOL;
	 $output .= '  }' . PHP_EOL;
	 
	 return $output;
    }
    
    private function CreateFetchMethod()
    {
	$output = '';
        $output = '  /**' . PHP_EOL;
	$output .= '  * @param  $id optional. If provided, it indicates the id/name/... of the query' . PHP_EOL;
	$output .= '  * The method defaults to use the primary field for querying' . PHP_EOL;
        $output .= '  * @return Array' . PHP_EOL;
	$output .= '  */' . PHP_EOL . PHP_EOL;
	$output .= '  public function Fetch($id = null) ' . PHP_EOL;
	$output .= '  {' . PHP_EOL;
	$output .= '    $this->field_name = $this->primary_key;' . PHP_EOL;
	$output .= '    return parent::Read($id);' . PHP_EOL;
	$output .= '  }' . PHP_EOL;
	
	return $output;
    }
    private function CreateLoginMethod(array $properties) 
    {   
        $output = '';
        $output = '  public function Login()' . PHP_EOL;
        $output .= '  {' . PHP_EOL;
        $output .= '    $sql = "SELECT * FROM $this->table_name WHERE email = \'$this->email\'";' . PHP_EOL;
        $output .= '    $res = $this->db_connection->query($sql);' . PHP_EOL;
        $output .= '    $row = $res->fetch_object();' . PHP_EOL;
        $output .= '    if (password_verify($this->password, $row->password)) {' . PHP_EOL;
        foreach ($properties as $value) {
            if ($value['Extra'] == 'auto_increment') {
                continue;
            }
            $output .= '      $_SESSION["auth"]["' . $value['Field'] . '"] = $row->' . $value['Field'] . ';' . PHP_EOL;
        }
        $output .= '      return true;' . PHP_EOL;
        $output .= '    }' . PHP_EOL;
        $output .= '  return false;' . PHP_EOL;
        $output .= '  }' . PHP_EOL;
        
        return $output;
    }
    
    private function createLogoutMethod()
    {
        $output = '';
        $output .= '  public function Logout() ' . PHP_EOL;
        $output .= '  {' . PHP_EOL;
        $output .= '    unset($_SESSION["auth"]);' . PHP_EOL;
        $output .= '  }' . PHP_EOL;
        return $output;
    }

    private function CreateClassNames($table_name, $prefix, $remove_prefix){
	    if ($remove_prefix) {
		    $class_name = str_replace($prefix, '', $table_name);
	    }
	    return ucfirst($class_name);
    }
    private function CreateClasses($prefix = null, $remove_prefix = true) 
    {
	$db_tables = $this->GetTables($prefix);
	$output = array();
	 $tbl_name = 'Tables_in_' . $this->db_name;
	foreach ($db_tables as $value) {
            $class_name = $this->CreateClassNames($value->$tbl_name, $prefix, $remove_prefix);
//	    $class_name = $value->$tbl_name;
//	    if ($remove_prefix) {
////		    $class_name = ltrim($class_name, $prefix);
//		    $class_name = str_replace($prefix, '', $class_name);
//	    }
//	    $class_name = ucfirst($class_name);
            
	    $temp = ''; 
	   
	    $temp .= '<?php' . PHP_EOL
		    . 'Class ' . $class_name . ' extends CRUD' . PHP_EOL
		    . '{' .PHP_EOL
		    . '';
	    $temp .= $this->getProperties($value->$tbl_name);
	    $temp .= $this->CreateConstructor($value->$tbl_name);
	    $temp .= PHP_EOL . PHP_EOL;
	    $temp .= $this->CreateGetSet();
	    $temp .= $this->CreateSaveMethod();
	    $temp .= $this->CreateDeleteMethod();
	    $temp .= $this->CreateEditMethod();
	    $temp .= $this->CreateFetchMethod();
            if (strtolower($class_name) == 'user') {
                $temp .= $this->CreateLoginMethod($this->propertylist);
                $temp .= $this->createLogoutMethod();
            }
	    $temp .= PHP_EOL
		    . '}' . PHP_EOL;
	    $output[$class_name] = $temp;
	}
	return $output;
    }
    
    /**
     * 
     * @param string $dir directory to save phpclass-files to
     * @param string $prefix prefix to tablenames i database to look for
     * @param boolean $remove_prefix if true classnames are created without prefix
     * @param booelan $create_seeder if true seeder-file for databse-tables wil be created
     * @return String
     */
    public function WriteClasses($dir = 'classes', $prefix = null, $remove_prefix = true, $create_seeder = false)
    {
	$classes = $this->CreateClasses($prefix, $remove_prefix);
	$output = array();
	foreach ($classes as $class_name => $class_content) {
	    try {
		$handle = new SplFileObject($dir . '/' . $class_name .'.php', 'w');
		$written = $handle->fwrite($class_content);
		if ($written > 0 ) {
		    $output[] = 'Class: ' . $class_name . ' created.';
		} else {
		    $output[] = 'Class: ' . $class_name . ' could NOT be created.';
		}
	    } catch (Exception $exc) {
		echo $exc->Message();
	    }
	}
        if ($create_seeder) {
            $output[] = $this->CreateSeeder($prefix, $remove_prefix);
        }
	return $output;
    }
    
    public function CreateSeeder($prefix, $remove_prefix)
    {   
        $output = '';
        $temp = '<?php' . PHP_EOL;
        $temp .= 'require_once("config.php");'  . PHP_EOL;
	$temp .= '/** ' . PHP_EOL;
	$temp .= '* Do not forget to: ' . PHP_EOL;
        $temp .= '* 1. rename "config.php" according to your own cofig file containing your database connection!' . PHP_EOL;
        $temp .= '* 2. rearrange according to database constraints!' . PHP_EOL;
        $temp .= '* 3. rename "$connection" to your database connection name!' . PHP_EOL;
        $temp .= '*/' . PHP_EOL;
        foreach ($this->db_tables as $value) {
            //var_dump($value) ;
            $tbl_name = 'Tables_in_' . $this->db_name;
            $class_name = $this->CreateClassNames($value->$tbl_name, $prefix, $remove_prefix);
            $temp .= '$'. lcfirst($class_name) . ' = new ' . $class_name . '($connection);' . PHP_EOL;
            $this->getProperties($value->$tbl_name);
            
            foreach ($this->propertylist as $property) {
//                var_dump( $property);
		 if ($property['Extra'] == 'auto_increment') {
		     continue;
		 }
		 $temp .= '$' . lcfirst($class_name) . '->set' . ucfirst($property['Field']) . '(\'\');' . PHP_EOL;
            }
	    $temp .= '$' . lcfirst($class_name) . '->Save();'. PHP_EOL . PHP_EOL;
        }
        try {
            $handle = new SplFileObject('seeder.php', 'w');
            $written = $handle->fwrite($temp);
            if ($written > 0 ) {
                $output = 'Seeder: seeder.php created.';
            } else {
                $output = 'Seeder could NOT be created.';
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }


        //echo $temp;
        return $output;
    }
}
