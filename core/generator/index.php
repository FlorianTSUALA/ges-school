<?php
/**
 * @license GPLv3 (http://www.gnu.org/licenses/gpl-3.0.html)
 * @version 1.0.0_20130220000000
 */

require_once('db_code_generator.php');

$table_type = array();
$table_type['db2'] = 'DB2/400 (db2)';
$table_type['mssql'] = 'Microsoft SQL Server (mssql)';
$table_type['mysql'] = 'MySQL (mysql)';
$table_type['pgsql'] = 'PostGRESQL (pgsql)';
$table_type['sqlite'] = 'SQLite (sqlite)';

$database = (isset($_POST['database'])) ? $_POST['database'] : 'my_database';
$host = (isset($_POST['host'])) ? $_POST['host'] : 'localhost';
$username = (isset($_POST['username'])) ? $_POST['username'] : 'root';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$table = (isset($_POST['table'])) ? $_POST['table'] : '';
$type = (isset($_POST['type'])) ? $_POST['type'] : 'mysql';

$library = (isset($_POST['library'])) ? $_POST['library'] : 'LIBRARY';
$file = (isset($_POST['file'])) ? $_POST['file'] : 'STATES';
//---------------------------------------------------------------------------
?>
<div class="data_input">
    <form action="" method="post">
        <fieldset class="top">
            <legend>Code Generator</legend>
            <label for="host">Hostname or IP:
            <input id="host" maxlength="32" name="host" tabindex="<?php echo $tabindex++; ?>" title="Enter the database host name" type="text" value="<?php echo $host; ?>" />
            </label>
            <br />

            <label for="username">Username:
            <input id="username" maxlength="32" name="username" tabindex="<?php echo $tabindex++; ?>" title="Enter the database username" type="text" value="<?php echo $username; ?>" />
            </label>
            <br />

            <label for="password">Password:
            <input id="password" maxlength="32" name="password" tabindex="<?php echo $tabindex++; ?>" title="Enter the database password" type="password" value="<?php echo $password; ?>" />
            </label>
            <br />

            <label for="type">Type:
            <select id="type" name="type" tabindex="<?php echo $tabindex++; ?>">
                <?php
                foreach ($table_type AS $key=>$value){
                    echo('<option ');
                    if ($key == $type){
                        echo 'selected="selected" ';
                    }
                    echo 'value="'. $key .'">'. $value .'</option>';
                }
                ?>
            </select>
            </label>
            <br />

        </fieldset>

        <fieldset class="top">
            <legend>PostGRESQL/MSSQL/MySQL Parameters</legend>

            <label for="database">Database:
            <input id="database" maxlength="100" name="database" tabindex="<?php echo $tabindex++; ?>" title="Enter the database name" type="text" value="<?php echo $database; ?>" />
            </label>
            <br />

            <label for="table">Table:
            <input id="table" maxlength="100" name="table" tabindex="<?php echo $tabindex++; ?>" title="Enter the table name" type="text" value="<?php echo $table; ?>" />
            </label>
            <br />

        </fieldset>
        <fieldset class="top">
            <legend>DB2 Parameters</legend>

            <label for="library">Library:
            <input id="library" maxlength="10" name="library" tabindex="<?php echo $tabindex++; ?>" title="Enter the library name" type="text" value="<?php echo $library; ?>" />
            </label>
            <br />

            <label for="file">Physical File:
            <input id="file" maxlength="10" name="file" tabindex="<?php echo $tabindex++; ?>" title="Enter the file name" type="text" value="<?php echo $file; ?>" />
            </label>
            <br />

        </fieldset>
        <fieldset class="bottom">
            <button tabindex="<?php echo $tabindex++; ?>" type="submit">Generate!</button>
        </fieldset>
    </form>
</div>
<?php

if (isset($_POST['host'])){
    if ('db2' == $_POST['type']){
        $_POST['database'] = strtoupper($_POST['library']); // Library
        $_POST['table'] = strtoupper($_POST['file']); // Physical file
        $_POST['host'] = 'db2_host';
        $_POST['username'] = 'db2_username';
        $_POST['password'] = 'db2_password';
    }
    $object = new db_code_generator($_POST['database'], $_POST['table'], $_POST['username'], $_POST['password'], $_POST['host'], $_POST['type']);
    echo('<textarea rows="75" style="margin-left : 50px; width : 90%;" onfocus="select()">'. $object->get_code() .'</textarea>');
}
?>