<?php
/**
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0.0_20130220000000
 */

/**
 * This class will generate PHP source code for a "model" that interfaces with 
 * a database table.
 * 
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0.0_20130220000000
 */
class db_code_generator{
    private $closing_tag;
    private $columns;
    private $database;
    private $host;
    private $password;
    private $port;
    private $table;
    private $type;
    private $username;

    /**
     * Constructor. By default we will try to connect to a MySQL database on 
     * localhost.
     * 
     * @param string $database The name of the database the user wants to connect
     * to.
     * 
     * @param string $table The name of the table to generate code for.
     * 
     * @param string $username The username we should use to connect to the 
     * database.
     * 
     * @param string $password The password we need to connect to the database.
     * 
     * @param string $host The host or server we will try to connect to. If the 
     * user doesn't give us a host we default to localhost.
     * 
     * @param string $port The port we should try to connect to. Typically this 
     * will not be passed so we default to NULL.
     * 
     * @param string $type The type of database we are connecting to. Valid 
     * values are: db2, mssql, mysql, pgsql, sqlite.
     */
    public function __construct($database = NULL,
                                         $table = NULL,
                                         $username = NULL,
                                         $password = NULL,
                                         $host = 'localhost',
                                         $type = 'mysql',
                                         $port = NULL,
                                         $closing_tag = TRUE){
        $this->database = $database;
        $this->table = $table;
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        $this->type = $type;
        $this->closing_tag = $closing_tag;
    }

    /**
     * Generate the code for a model that represents a record in a table.
     * 
     * @return string The PHP code generated for this model.
     */
    public function get_code(){
        $this->get_data_definition();
        $code = $this->get_file_head();
        $code .= $this->get_properties();
        $code .= $this->get_ctor();
        $code .= $this->get_dtor();
        $code .= $this->get_method_stubs();
        $code .= $this->get_file_foot();
        return $code;
    }

    /**
     * Create the code needed for the __construct function.
     * 
     * @return string The PHP code for the __construct function.
     */
    private function get_ctor(){
        $code = "\t/**\n";
        $code .= "\t * Constructor.\n";
        $code .= "\t *\n";
        $code .= "\t * @param mixed \$id The unique id for a record in this table. Defaults to NULL\n";
        if ('db2' === $this->type){
            $code .= "\n\t * @param string \$library The library where the physical file resides. Defaults to LIBRARY\n";
        }
        $code .= "\t *\n";
        $code .= "\t * @see base_$this->type::__construct\n";
        $code .= "\t */\n";
        if ('db2' === $this->type){
            $code .= "\tpublic function __construct(\$id = NULL, \$library = 'LIBRARY'){\n";
            $code .= "\t\tparent::__construct(\$id, \$library);\n";
        }else{
            $code .= "\tpublic function __construct(\$id = NULL){\n";
            $code .= "\t\tparent::__construct(\$id);\n";
        }
        $code .= "\t}\n\n";
        return $code;
    }

    /**
     * Connect to the requested database and get the data definition for the
     * requested table.
     */
    private function get_data_definition(){
        try{
            switch ($this->type){
                case 'db2':
                    $this->get_data_definition_db2();
                    break;
                case 'mssql':
                    $this->get_data_definition_mssql();
                    break;
                case 'mysql':
                    $this->get_data_definition_mysql();
                    break;
                case 'pgsql':
                    $this->get_data_definition_pgsql();
                    break;
                case 'sqlite':
                    $this->get_data_definition_sqlite();
                    break;
            }
        }catch(PDOException $e){
        }
    }

    /**
     * Get data definition information for a DB2 table.
     */
    private function get_data_definition_db2(){
        $con = new PDO("odbc:DRIVER={iSeries Access ODBC Driver};SYSTEM=$this->host;PROTOCOL=TCPIP", $this->username, $this->password);
        $sql = "SELECT COLUMN_NAME, COLUMN_SIZE, COLUMN_TEXT, DECIMAL_DIGITS, ORDINAL_POSITION, TYPE_NAME FROM SYSIBM.SQLCOLUMNS WHERE TABLE_SCHEM = '". strtoupper($this->database) ."' AND TABLE_NAME = '". strtoupper($this->table) ."'";
        $statement = $con->prepare($sql);
        if ($statement->execute()){
            while ($row = $statement->fetch()){
                if (NULL !== $row['DECIMAL_DIGITS']){
                    $decimal = $row['DECIMAL_DIGITS'];
                }else{
                    $decimal = NULL;
                }
                if ('DECIMAL' === $row['TYPE_NAME'] && NULL !== $row['DECIMAL_DIGITS'] && '0' !== $row['DECIMAL_DIGITS']){
                    $type = 'float';
                }else if ('DECIMAL' === $row['TYPE_NAME']){
                    $type = 'integer';
                }else{
                    $type = strtolower($row['TYPE_NAME']);
                }
                if ('1' === $row['ORDINAL_POSITION']){
                    $key = 'PRI';
                }else{
                    $key = NULL;
                }
                $this->columns[$row['COLUMN_NAME']] = array('allow_null' => TRUE,
                                                                          'decimal' => $decimal,
                                                                          'default' => NULL,
                                                                          'extra' => NULL,
                                                                          'key' => $key,
                                                                          'length' => $row['COLUMN_SIZE'],
                                                                          'name' => $row['COLUMN_NAME'],
                                                                          'text' => $row['COLUMN_TEXT'],
                                                                          'type' => $type);
            }
            ksort($this->columns);
        }
    }

    /**
     * Get data definition information for a MS SQL table.
     */
    private function get_data_definition_mssql(){
        return "The code for generating MS SQL models is not yet implemented.\n";
    }

    /**
     * Get data definition information for a MySQL table.
     */
    private function get_data_definition_mysql(){
        $dsn = "mysql:host=$this->host;";
        if (NULL !== $this->port){
            $dsn .= "port=$this->port;";
        }
        $dsn .= "dbname=$this->database";
        $con = new PDO($dsn, $this->username, $this->password);
        $sql = "SHOW COLUMNS FROM $this->table";
        $statement = $con->prepare($sql);
        if ($statement->execute()){
            while ($row = $statement->fetch()){
                $this->columns[$row['Field']] = array('allow_null' => $row['Null'],
                                                                  'decimal' => NULL,
                                                                  'default' => $row['Default'],
                                                                  'extra' => $row['Extra'],
                                                                  'key' => $row['Key'],
                                                                  'length' => NULL,
                                                                  'name' => $row['Field'],
                                                                  'text' => NULL,
                                                                  'type' => $row['Type']);
            }
            ksort($this->columns);
        }
    }

    /**
     * Get data definition information for a PostgreSQL table.
     */
    private function get_data_definition_pgsql(){
        return "The code for generating PostgreSQL models is not yet implemented.\n";
    }

    /**
     * Get data definition information for a SQLite table.
     */
    private function get_data_definition_sqlite(){
        return "The code for generating SQLite models is not yet implemented.\n";
    }

    /**
     * Create the code needed for the __destruct function.
     * 
     * @return string The PHP code for the __destruct function.
     */
    private function get_dtor(){
        $code = "\t/**\n";
        $code .= "\t * Destructor.\n";
        $code .= "\t */\n";
        $code .= "\tpublic function __destruct(){\n";
        $code .= "\t\tparent::__destruct();\n";
        $code .= "\t}\n\n";
        return $code;
    }

    /**
     * Generate the code found at the end of the file - the closing brace, the 
     * ending PHP tag and a new line. Some PHP programmers prefer to not have a 
     * closing PHP tag while others want the closing tag and trailing newline - 
     * it probably just depends on their programming background. Regardless it's 
     * best to let everyone have things the way they want.
     */
    private function get_file_foot(){
        $code = '';
        if ($this->closing_tag){
            $code .= "}\n?>\n";
        }else{
            $code .= '}';
        }
        return $code;
    }

    /**
     * Generate the code found at the beginning of the file - the PHPDocumentor 
     * doc block, the require_once for the correct base class and the class name.
     * 
     * @return string The code generated for the beginning of the file.
     */
    private function get_file_head(){
        $code  = "<?php\n";
        $code .= "/**\n";
        $code .= " * Please enter a description of this class.\n";
        $code .= " *\n";
        $code .= " * @author XXX <XXX@domain.com>\n";
        $code .= " * @copyright Copyright (c) ". date('Y') ."\n";
        $code .= " * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3\n";
        $code .= " * @version ". date('Ymd') ."\n";
        $code .= " */\n\n";
        $code .= "require_once('base_$this->type.php');\n\n";
        $code .= "class ". strtolower($this->table) ." extends base_$this->type{\n";
        return $code;
    }

    /**
     * Generate the code for a delete method stub.
     * 
     * @return string The PHP code for the method stub.
     */
    private function get_method_stub_delete(){
        $code  = "\t/**\n";
        $code .= "\t * Override the delete method found in the base class.\n";
        $code .= "\t *\n";
        $code .= "\t * @param mixed \$id The unique record ID to be deleted.\n";
        $code .= "\t *\n";
        $code .= "\t * @return bool TRUE if a record was successfully deleted from the table, FALSE otherwise.\n";
        $code .= "\t */\n";
        $code .= "\tpublic function delete(\$id){\n";
        $code .= "\t\treturn parent::delete(\$id);\n";
        $code .= "\t}\n\n";
        return $code;
    }

    /**
     * Generate the code for an insert method stub.
     * 
     * @return string The PHP code for the method stub.
     */
    private function get_method_stub_insert(){
        $code  = "\t/**\n";
        $code .= "\t * Override the insert method found in the base class.\n";
        $code .= "\t *\n";
        $code .= "\t * @param array \$parms An array of data, probably the \$_POST array.\n";
        $code .= "\t * @param bool \$get_insert_id A flag indicating if we should get the autoincrement value of the record just created.\n";
        $code .= "\t *\n";
        $code .= "\t * @return bool TRUE if a record was successfully inserted into the table, FALSE otherwise.\n";
        $code .= "\t */\n";
        $code .= "\tpublic function insert(\$parms, \$get_insert_id = FALSE){\n";
        $code .= "\t\treturn parent::insert(\$parms, \$get_insert_id);\n";
        $code .= "\t}\n\n";
        return $code;
    }

    /**
     * Generate the code for an update method stub.
     * 
     * @return string The PHP code for the method stub.
     */
    private function get_method_stub_update(){
        $code  = "\t/**\n";
        $code .= "\t * Override the update method found in the base class.\n";
        $code .= "\t *\n";
        $code .= "\t * @param array &\$parms An array of key=>value pairs - most likely the \$_POST array.\n";
        $code .= "\t *\n";
        $code .= "\t * @param integer \$limit The number of records to update. Defaults to NULL.\n";
        $code .= "\t *\n";
        $code .= "\t * @return bool TRUE if a record was successfully updated, FALSE otherwise.\n";
        $code .= "\t */\n";
        $code .= "\tpublic function update(\$parms, \$limit = NULL){\n";
        $code .= "\t\treturn parent::update(\$parms, \$limit);\n";
        $code .= "\t}\n\n";
        return $code;
    }

    /**
     * Create method stubs for create, delete and update.
     * 
     * @return string The PHP code for these stubs.
     */
    private function get_method_stubs(){
        $code = $this->get_method_stub_delete();
        $code .= $this->get_method_stub_insert();
        $code .= $this->get_method_stub_update();
        return $code;
    }

    private function get_properties(){
        $code = '';
        if (count($this->columns)){
            foreach ($this->columns AS $index => $col){
                $code .= "\t/**\n";
                if (NULL !== $col['text']){
                    $code .= "\t * $col[text]\n";
                }else{
                    $code .= "\t * Description\n";
                }
                $code .= "\t * @var ". $col['type'];
                if (NULL !== $col['length']){
                    $code .= " ($col[length]";
                    if (NULL !== $col['decimal']){
                        $code .= ",$col[decimal]";
                    }
                    $code .= ")";
                }
                $code .= "\n\t */\n";
                $temp_name = str_replace('#', '_', $col['name']);
                $code .= "\tpublic \$$temp_name;\n\n";
            }
        }
        return $code;
    }
}
?>