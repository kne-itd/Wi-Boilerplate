<?php
/**
 * Example of usage:
 * $u = new Upload();
 *  $u->setAllowed_mime_types(array('image/jpeg', 'image/png'));
 *  $u->setFolder('../img');
 *  $u->setFile($_FILES['fil']);
 *  $u->setNew_name($_POST['file_name'], true);
 *  try {
 *      $file_info = $u->Upload();
 *  } catch (Exception $exc) {
 *      echo $exc->getMessage();
 *  }
 *
 */
class Upload 
{
    private $allowed_mime_types = array();
    private $max_file_size;
    private $file = array();
    private $dir;
    private $new_name;
            
    public function __construct() {
        $this->max_file_size = 2;
    }
    
    public function setAllowed_mime_types(Array $allowed_mime_types) {
        $this->allowed_mime_types = $allowed_mime_types;
    }
    
    /**
     * 
     * @param integer $max_file_size Max filesize in MB accepted 
     */
    public function setMax_file_size($max_file_size) {
        $this->max_file_size = $max_file_size * 1000000;
    }
    
    /**
     * 
     * @param array $file $_FILES array
     */
    public function setFile(Array $file) {
        $this->file = $file;
        $this->setNew_name($file['name']);
    }
    
    /**
     * 
     * @param string $new_name
     * @param boolean $overwrite if filename already exists, it will be overwritten if true
     */
    public function setNew_name($new_name, $overwrite = false) {
        $this->rename($new_name, $overwrite);
    }
    
    private function rename($new_name, $overwrite) {
        $this->new_name = strtolower($new_name);
        if (!$overwrite) {
            $this->new_name = uniqid() . '_' . $this->new_name;
        }
        
    }
    
    /**
     * 
     * @param string $dir path of directory where uploaded file will be saved
     * the function checks for trailing '/'
     */
    public function setDir($dir) {
        if(substr($dir, -1) != "/"){
            $dir .= "/";
	}
        $this->dir = $dir;
    }
    
    private function ValidateFile()
    {
        if (!in_array($this->file['type'], $this->allowed_mime_types)) {
            throw new Exception('File type not allowed');
        }
        if ($this->file['size'] > $this->max_file_size) {
            throw new Exception('File size is too large');
        }
        if (!file_exists($this->dir)) {
            throw new Exception('Upload directory not found: "' . $this->dir . '"');
        }
        return TRUE;
    }


    public function Upload()
    {
        try {
            $this->ValidateFile();
            
            if( move_uploaded_file($this->file['tmp_name'], 
                    $this->dir . $this->new_name) ) {
            return array(
                "filename" => $this->new_name,
                "type" => $this->file['type'],
                "dir" => $this->dir
            );    
            } else {
                throw new Exception('Filen kunne ikke uploades');
            }
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }

            
    }





}