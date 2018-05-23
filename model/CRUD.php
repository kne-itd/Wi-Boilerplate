<?php
/**
 * Helper methods for child-classes
 * 
 * Property 'db_connection' must be set by child-class as an instance of mysqli
 * Properties 'table_name' and 'db_connection' must be set by child class
 * Property 'fieldname_and_value' is an associative array used by
 * Create and Update methods determining the database table's fieldnames/columns and their values
 * Property 'primary_key' is set by child-class and is used to set the name of the database table's primary key column
 * 
 * All methods use prepared statements/parameterized queries to protect from SQL-injection
 * 
 * @author kne
 */
class CRUD {
    protected $db_connection;
    protected $table_name;
    protected $primary_key;
    protected $field_name;
    protected $fieldname_and_value = array();
    protected $order_by;

    /**
     * 
     * @return integer mysqli->insert_id on success
     * @return string error_no + error_message on failure
     */
    protected function Create()
    {
        $fieldnames = array_keys($this->fieldname_and_value);
        $fields = implode(',', $fieldnames);
        $count = count($fieldnames);
        $qms = str_repeat('?,', $count);
        $qms = rtrim($qms, ',');
        $types = str_repeat('s', $count); // shortcut: we pas all arguments to bind_param as strings
        // for debugging sql query
//        $temp = array();
//        foreach ($this->fieldname_and_value as $value) {
//            $temp[] = $this->db_connection->real_escape_string($value);
//        }
//        $values = implode(',', $this->fieldname_and_value);
//        echo $sql = "INSERT INTO $this->table_name ($fields) "
//                . "VALUES ($values)";
//        $values = "'" . implode("', '", $temp) . "'";
//        //'
        $sql = "INSERT INTO $this->table_name ($fields) VALUES ($qms)";

        $stmt = $this->db_connection->prepare($sql);

        // Ellipsis is unpacking the argument(array_values($this->fieldname_and_value)
        // array_values is neccessary, as ellipsis cannot unpack array with text-indexes
        $stmt->bind_param($types, ...array_values($this->fieldname_and_value));
//        if ($this->db_connection->query($sql) ) {
        if ($stmt->execute() ) {
            return $this->db_connection->insert_id;
        } else {
            // 1452: Foreign Key constraint failure
            // 1062: Duplicate entry for key
            // 1366: incorrect integer value
            // 1292: incorrect date value
            // 1054: Unknown column
//            return 'error(' .$this->db_connection->errno . ')';
            return 'error(' .$this->db_connection->errno . ' | ' . $this->db_connection->error . ')';
        }
        
    }
    
    /**
     * 
     * @param optional string $id
     * @return Array of objects
     */
    protected function Read($id = null) {
        $sql = "SELECT * FROM $this->table_name ";
        
        if ($id) {
//            $sql .= " WHERE $this->field_name = '$id'";
            $sql .= " WHERE $this->field_name = ?";
        }
	if ($this->order_by) {
	    $sql .= " ORDER BY $this->order_by";
	}
        $stmt = $this->db_connection->prepare($sql);
        if ($id) {
            $stmt->bind_param('s', $id);
        }
//        echo $sql;
        $stmt->execute();
        $res = $stmt->get_result();
        $output = array();
        while ($row = $res->fetch_object()) {
            $output[] = $row;
        }
        return $output;
    }
    
    /**
     * 
     * @return boolean on success
     * @return string error_no + error_message on failure
     */
    protected function Update($id)
    {
        $types = '';
        $sql = "UPDATE $this->table_name SET ";
//        foreach ($this->fieldname_and_value as $key => $value) {
//            $sql .= " $key = '$value', ";
//        }
//        $sql = rtrim($sql, ', ');
//        $sql .= " WHERE $this->field_name = $id";
        foreach ($this->fieldname_and_value as $key => $value) {
            $sql .= " $key = ?, ";
            $types .= 's';
        }
        $sql = rtrim($sql, ', ');
        $sql .= " WHERE $this->field_name = $id";
        
//        echo $sql;

        $stmt = $this->db_connection->prepare($sql);
        $stmt->bind_param($types, ...array_values(($this->fieldname_and_value)));
        if ($stmt->execute()) {
            return TRUE;
        } else {
//            return 'error(' .$this->db_connection->errno . ')';
            return 'error(' .$this->db_connection->errno . ' | ' . $this->db_connection->error . ')';            
            return 'error(' .$stmt->errno . ' | ' . $stmt->error . ')';            
        }
//        return $this->db_connection->query($sql);
    }
    
    /**
     * 
     * @return boolean
     */
    protected function Delete()
    {   
        $fieldname = array_keys($this->fieldname_and_value)[0];
        $value = $this->fieldname_and_value[$fieldname];
        
//        $value = $this->db_connection->real_escape_string($value);
        
        $sql = "DELETE FROM $this->table_name WHERE $fieldname = ?";
        $stmt = $this->db_connection->prepare($sql);
        $stmt->bind_param('s', $value);
        
        return $stmt->execute();
    }
}
