<?php

 
 /**
 * @version 1.0.3 PDO Abstraction for common CRUD statements with auto-column binding.
 *
 * @internal the debug() method imports "model_error.css" for nice error styling. Adjust path to this file accordingly.
 *
 * @update 1.0.3 added error_log() within the __construct() to record connection failures.
 *
 * @update 1.0.4 clarified method comments with regards to calling methods.
 *
 * @update 1.0.5 updated run() function to return last record id on insert, and affected records for update or delete.
 *
 * @update 1.0.7 HTML Entities returned from the database will be decoded by default when calling select() or run() methods.
 * 
 * @update 1.0.8 Return FALSE if no data found when using select() method.
 * 
 * @update 1.0.9 Added selectOne() method for single record queries.
 */

/* PDO is automatically included in PHP 7.2+, otherwise uncomment the following lines.
use \PDO as PDO;
use PDOException;
use \PDOException as PDOException;
*/

class Database extends PDO
{

    private $error;
    private $sql;
    private $bind;
    private $errorCallbackFunction;
    private $errorMsgFormat;
    private $errorCssPath = 'model_error.css'; // Styles to pretty up the custom error output.

    public function __construct()
    {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );

        define('DB_DRIVER','mysql');
        define('DB_HOSTNAME', 'guia_db');
        //define('DB_DATABASE','guia');
        define('DB_DATABASE','login_2019');
        define('DB_USERNAME','root');
        define('DB_PASSWORD','');     
        define('ENVIRONMENT','development');

        

        try {
            parent::__construct(DB_DRIVER . ':host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE . '', DB_USERNAME, DB_PASSWORD, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log('DB Model Connection Error: ' . $this->error, 0);
            echo 'DB Connection Error: ' . $this->error;
        }
    }

    /**
     * run()
     * 
     * This method is used to run free-form SQL statements that can't be handled by the included delete, insert, select,
     * or update methods. If no SQL errors are produced, this method will return the number of affected rows for
     * DELETE, INSERT, and UPDATE statements, or an object of results for SELECT, DESCRIBE, and PRAGMA statements.
     *
     * Note: HTML Entities returned from 'select' queries will be decoded by default. Set $entity_decode = false otherwise.
     */
    public function run($sql, $bind = "", $entity_decode = true)
    {
        $this->sql   = trim($sql);
        $this->bind  = $this->cleanup($bind);
        $this->error = "";

        try {
            $pdostmt = $this->prepare($this->sql);
            if ($pdostmt->execute($this->bind) !== false) {
                if (preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql)) {
                    $results = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($entity_decode) {
                        array_walk_recursive($results, function (&$item) {
                            $item = htmlspecialchars_decode($item);
                        });
                    }
                    return $results;
                } elseif (preg_match("/^(" . implode("|", array("delete", "update")) . ") /i", $this->sql)) {
                    return $pdostmt->rowCount(); // return records affected.
                } elseif (preg_match("/^(" . implode("|", array("insert")) . ") /i", $this->sql)) {
                    return $this->lastInsertId(); // return new record id.
                }
            }
        } catch (PDOException $e) {

            if (ENVIRONMENT == 'development') {
                var_dump($sql);

                var_dump($e->getCode());
                var_dump($e->getMessage());
                $this->error = $e->getMessage();
                $this->debug();
            } else {

                $code = $e->getCode();

                switch ($code) {
                    case "23000":
                        throw new Exception(json_encode(["error" => "Error .El registro esta siendo utilizado en el sistema . Por lo cual no puede eliminarse"]), 1);
                        break;
                    default:
                        throw new Exception(json_encode(["error" => "Error .Con la base de datos detalle : " . $e->getMessage()]), 1);
                        break;
                }
            }


            return false;
        }
    }

    /**
     * select()
     * 
     * Example #1
     * $results = $this->db->select("mytable");
     *
     * Example #2
     * $results = $this->db->select("mytable", "Gender = 'male'");
     *
     * Example #3 w/Prepared Statement
     * $search = "J";
     * $bind = array(
     *      ":search" => "%$search"
     * );
     * $results = $this->db->select("mytable", "FName LIKE :search", $bind);
     * 
     * One or more records are returned as array of array.  If no records found, FALSE is returned.
     *
     * Note: HTML Entities returned from the database will be decoded by default. Set $entity_decode = false otherwise.
     */
    public function select($table, $where = "", $bind = "", $fields = "*", $entity_decode = true)
    {
        $sql = "SELECT " . $fields . " FROM " . $table;
        if (!empty($where)) {
            $sql .= " WHERE " . $where;
        }
        $sql .= ";";

        $data = $this->run($sql, $bind, $entity_decode);

        if (empty($data)) {
            return false;
        }

        return $data;
    }

    /**
     * selectOne()
     * 
     * Use this method in place of select() when you want to return a single record.
     * 
     * This method functions identically as select() accept it returns the results as a single array
     * and will LIMIT the results to the first record found.
     */
    public function selectOne($table, $where = "", $bind = "", $fields = "*", $entity_decode = true)
    {
        $sql = "SELECT " . $fields . " FROM " . $table;
        if (!empty($where)) {
            $sql .= " WHERE " . $where . " LIMIT 1";
        }
        $sql .= ";";

        $data = $this->run($sql, $bind, $entity_decode);

        if (empty($data)) {
            return false;
        }

        return $data[0];
    }

    /**
     * selectExtended()
     * 
     * Use this method when complex SQL statements are required, like table JOINS, are required.
     * 
     * Example:
     * $sql = "select * from users u join preferences p on p.user_id = u.id where p.role = :role ";
     * $bind = array (':role' => 'admin');
     * $results = $this->db->selectExtended($sql, $bind);
     * 
     * Note: HTML Entities returned from the database will be decoded by default. Set $entity_decode = false otherwise.
     */
    public function selectExtended($sql, $bind = "", $entity_decode = true)
    {
        $data = $this->run($sql, $bind, $entity_decode);

        if (empty($data)) {
            return false;
        } elseif (count($data[0]) > 1) {
            return $data; // return full index of records.
        } else {
            return $data[0]; // return single record.
        }
    }

    /**
     * insert()
     * 
     * If no SQL errors are produced, this method will return the number of rows affected by the INSERT statement.
     *
     * Example #1:
     * $insert = array(
     *      "FName" => "John",
     *      "LName" => "Doe",
     *      "Age" => 26,
     *      "Gender" => "male"
     * );
     * $this->db->insert("mytable", $insert);
     */
    public function insert($table, $info)
    {
        $fields = $this->filter($table, $info);
        $sql    = "INSERT INTO " . $table . " (" . implode(", ", $fields) . ") VALUES (:" . implode(", :", $fields) . ");";
        $bind   = array();
        foreach ($fields as $field) {
            $bind[":$field"] = $info[$field];
        }

        return $this->run($sql, $bind);
    }

    /**
     * update()
     * 
     * If no SQL errors are produced, this method will return the number of rows affected by the UPDATE statement.
     *
     * Example #1
     * $update = array(
     *      "FName" => "Jane",
     *      "Gender" => "female"
     * );
     * $this->db->update("mytable", $update, "FName = 'John'");
     *
     * Example #2 w/Prepared Statement
     * $update = array(
     *      "Age" => 24
     * );
     * $fname = "Jane";
     * $lname = "Doe";
     * $bind = array(
     *      ":fname" => $fname,
     *      ":lname" => $lname
     * );
     * $this->db->update("mytable", $update, "FName = :fname AND LName = :lname", $bind);
     */
    public function update($table, $info, $where, $bind = "")
    {
        $fields    = $this->filter($table, $info);
        $fieldSize = sizeof($fields);

        $sql = "UPDATE " . $table . " SET ";
        for ($f = 0; $f < $fieldSize; ++$f) {
            if ($f > 0) {
                $sql .= ", ";
            }
            $sql .= $fields[$f] . " = :update_" . $fields[$f];
        }
        $sql .= " WHERE " . $where . ";";

        $bind = $this->cleanup($bind);
        foreach ($fields as $field) {
            $bind[":update_$field"] = $info[$field];
        }

        return $this->run($sql, $bind);
    }

    /**
     * delete()
     * 
     * If no SQL errors are produced, this method will return the number of rows affected by the DELETE statement.
     *
     * Method #1
     * $this->db->delete("mytable", "Age < 30");
     *
     * Method #2 w/Prepared Statement
     * $lname = "Doe";
     * $bind = array(
     *      ":lname" => $lname
     * )
     * $this->db->delete("mytable", "LName = :lname", $bind);
     */
    public function delete($table, $where, $bind = "")
    {
        $sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
        $this->run($sql, $bind);
    }


    /**
     * filter()
     * 
     * Automated table binding for MySql or SQLite.
     */
    private function filter($table, $info)
    {
        $driver = $this->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver == 'sqlite') {
            $sql = "PRAGMA table_info('" . $table . "');";
            $key = "name";
        } elseif ($driver == 'mysqli') { // > php7
            $sql = "DESCRIBE " . $table . ";";
            $key = "Field";
        } elseif ($driver == 'mysql') { // < php7
            $sql = "DESCRIBE " . $table . ";";
            $key = "Field";
        } else {
            $sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
            $key = "column_name";
        }
        if (false !== ($list = $this->run($sql))) {
            foreach ($list as $record) {
                $fields[] = $record[$key];
            }

            return array_values(array_intersect($fields, array_keys($info)));
        }

        return array();
    }

    /**
     * cleanup()
     * 
     * Ensure we have an array to work with.
     */
    private function cleanup($bind)
    {
        if (!is_array($bind)) {
            if (!empty($bind))
                $bind = array($bind);
            else
                $bind = array();
        }

        return $bind;
    }

    /**
     * setErrorCallbackFunction()
     * 
     * The error message can then be displayed, emailed, etc within the callback function.
     *
     * Example:
     *
     * function myErrorHandler($error) {
     * }
     *
     * $db = new db("mysql:host=127.0.0.1;port=0000;dbname=mydb", "dbuser", "dbpasswd");
     * $this->db->setErrorCallbackFunction("myErrorHandler");
     *
     * Text Version
     * $this->db->setErrorCallbackFunction("myErrorHandler", "text");
     *
     * Internal/Built-In PHP Function
     * $this->db->setErrorCallbackFunction("echo");
     *
     * @param $errorCallbackFunction
     * @param string $errorMsgFormat
     */
    public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat = "html")
    {
        if (in_array(strtolower($errorCallbackFunction), array("echo", "print"))) {
            $errorCallbackFunction = "print_r";
        }

        if (method_exists($this, $errorCallbackFunction)) {
            $this->errorCallbackFunction = $errorCallbackFunction;
            if (!in_array(strtolower($errorMsgFormat), array("html", "text"))) {
                $errorMsgFormat = "html";
            }
            $this->errorMsgFormat = $errorMsgFormat;
        }
    }


    /**
     * debug()
     * 
     * A better PDO debugger, just because.
     */
    private function debug()
    {
        // If no other error handler is defined, then use this.
        if (!empty($this->errorCallbackFunction)) {

            $error = array("Error" => $this->error);
            if (!empty($this->sql)) {
                $error["SQL Statement"] = $this->sql;
            }

            if (!empty($this->bind)) {
                $error["Bind Parameters"] = trim(print_r($this->bind, true));
            }

            $backtrace = debug_backtrace();
            if (!empty($backtrace)) {
                foreach ($backtrace as $info) {
                    if ($info["file"] != __FILE__) {
                        $error["Backtrace"] = $info["file"] . " at line " . $info["line"];
                    }
                }
            }

            $msg = "";
            if ($this->errorMsgFormat == "html") {
                if (!empty($error["Bind Parameters"])) {
                    $error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
                }
                $css = trim(file_get_contents(dirname(__FILE__) . $this->errorCssPath)); // set this path
                $msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
                $msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
                foreach ($error as $key => $val) {
                    $msg .= "\n\t<label>" . $key . ":</label>" . $val;
                }
                $msg .= "\n\t</div>\n</div>";
            } elseif ($this->errorMsgFormat == "text") {
                $msg .= "SQL Error\n" . str_repeat("-", 50);
                foreach ($error as $key => $val) {
                    $msg .= "\n\n$key:\n$val";
                }
            }

            $func = $this->errorCallbackFunction;
            $this->{$func}($msg); // neat little trick to call a variable function.
        }
    }



    /**
     * Simple Callback Function.
     */
    public function basicCallbackFunction($msg)
    {
        print_r($msg);
    }



    /* GENERATE SQL INSERT */

    public function generateSQLInsert($table, $array)
    {
        $sql = "";

        if (count($array) > 0 && is_array($array)) {
            $sql = "INSERT INTO $table ";

            $sql .= "( " . implode(",", array_keys($array)) . " )";

            $arrayValues = [];

            foreach ($array as $sKey => $sValue) {


                $arrayValues[] =  (is_null($sValue) ? "NULL" : ($sValue == 'NOW()' || $sValue == 'CURDATE()' || substr($sValue, 0, 11) == 'STR_TO_DATE' ? $sValue :  $this->quote($sValue)));
            }

            $sql .= " VALUES ( " . implode(",", array_values($arrayValues)) . " ); ";
        }

        return $sql;
    }




    /* GENERATE SQL UPDATE */

    public function generateSQLUpdate($table, $array, $where)
    {
        $sql = "";

        if (count($array) > 0 && is_array($array)) {
            $sql = "UPDATE " . $table . " SET ";

            $nContador = 0;

            foreach ($array as $sKey => $sValue) {
                if (!is_null($sValue) && $nContador > 0) {
                    $sql .= " , ";
                }

                $sql .= (!is_null($sValue)  ?
                    ($sValue == 'NOW()' || $sValue == 'CURDATE()' || substr($sValue, 0, 11) == 'STR_TO_DATE' ? " $sKey = $sValue " : "  $sKey = {$this->quote($sValue)} ")
                    : "");

                $nContador++;
            }

            $sql .= " WHERE " . $where . ";";
        }

        return $sql;
    }


    public function generateSQLDelete($table, $where)
    {
        $sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
        return $sql;
    }


    // public function generateSQLSelect($table, $fields, $joins = "", $arrayWhere,  $aryFilter = [])
    // {
    //     $sql = "SELECT " . $fields . " FROM " . $table . $joins;

    //     $sWhere = "";

    //     if (is_array($arrayWhere) && count($arrayWhere) > 0) {
    //         foreach ($arrayWhere as $sKey => $sValue) {

    //             $sql .=  (strlen($sWhere) > 0 ? " AND " : '') . " $sKey  = $sValue ";
    //         }
    //     }

    //     $sGroupBy = "";
    //     return $sql;
    // }


    public function isNull($value = null)
    {
        if (is_array($value) && count($value) === 0) {
            return true;
        } else if (is_null($value)) {
            return true;
        } else if (is_string($value) && strlen($value) === 0) {
            return true;
        }
        return false;
    }


    public function filterArray($aryInput, $aryAllFilters)
    {
        if (is_array($aryInput) && count($aryInput) == 0) {
            return $aryAllFilters;
        }

        $newArray = [];
        if (is_array($aryAllFilters) && count($aryAllFilters) > 0) {
            foreach ($aryAllFilters as $sKey => $valueLoop) {
                if (array_key_exists($sKey, $aryInput)) {
                    $newArray[$sKey] = $aryInput[$sKey];
                } else {
                    $newArray[$sKey] = $valueLoop;
                }
            }
        }
        return $newArray;
    }
}
