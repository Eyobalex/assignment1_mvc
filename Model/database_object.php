<?php
/**
 * Created by Eyob.
 * Date: 8/24/2018
 * Time: 8:37 AM
 */

require_once LIB_PATH.DS."database.php";
class DatabaseObject
{


    protected static $table_name;
    protected static $db_fields;



    public static function find_all(){
        return self::find_by_sql("select * from ". static::$table_name);
    }

    public static function find_by_id($id){
        global $database;
        $result_array = static::find_by_sql("select * from ". static::$table_name. " where id ='".$database->escape_value($id)."'");
        return !empty($result_array) ? array_shift($result_array) : false ;
    }

    public static function find_by_sql($sql){
        global $database;
        $result_set = $database->query($sql);
        $object_array = [];
        while ($row =  $database->fetch_assoc($result_set)){
            $object_array[]= static::instantiate($row);
        }
        return $object_array;
    }

    public static function count_all(){
        global $database;
        $sql = "select count(*) from" . self::$table_name;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }
    private static function instantiate($record){
        $class_name = get_called_class();
        $object = new $class_name;

        foreach ($record as $attribute => $value){
            if ($object->has_attribute($attribute)){
                $object->$attribute =$value;
            }
        }
        return $object;


    }
    private function has_attribute($attribute){
        $object_vars = get_object_vars($this);

        return array_key_exists($attribute, $object_vars);
    }

    protected function attributes(){
        $attributes = array();
        foreach(static::$db_fields as $field) {
            if(property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }
    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }
    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }

    protected function create(){
        global $database;
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        }else{
            return false;
        }
    }
    protected function update(){
        global $database;
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".self::$table_name." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }


    public function delete(){
        global $database;
        $sql = "delete from ".static::$table_name." where id ='{$this->id}' ";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }


}