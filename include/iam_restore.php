<?php
/**
 *  IAM_restore A class for restoring a database from a backup file
 *  @package iam_backup
 *  @desc IAM_restore A class for restoring a database from a backup file
 *
 *  @author     Iván Ariel Melgrati <phpclasses@imelgrat.mailshell.com>
 *  @version 1.1.1
 *
 *  Requires PHP v 4.0+ and MySQL 3.23+
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 */
/**
 * IAM_restore A class for restoring a database from a backup file
 * @package iam_backup
 */
class iam_restore
{
/**
* @var string $host Host that holds the DB
* @access private
*/
    var $host="localhost";

/**
* @var string $dbname  Database to restore
* @access private
*/
    var $dbname="mysql";

/**
*
* @var string $dbuser User to access the Database
* @access private
*/
    var $dbuser="root";

/**
* @var string $dbpass Password to access the Database
* @access private
*/
    var $dbpass="";

/**
*
* @var String $filename Filename from which the class will restore the DB
* @access private
*/
    var $filename;

/**
* Initialize this class. Constructor
* @access public
* @param String $filename Filename from which the class will restore the DB
* @param string $host  Host that holds the DB
* @param string $dbanme Database to restore
* @param string $dbuser User to access the Database
* @param string $dbpass Password to access the Database
*/
    function iam_restore($filename, $host, $dbname, $dbuser, $dbpass)
    {
        $this->host = $host;
        $this->dbname =  $dbname;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        $this->filename = $filename;
    }

/**
* Open the file containing the backup data
* @return String a String containing the DB Dump 
* @access private
*/
    function _Open()
        {
            $fp = gzopen( $this->filename, "rb" ) or die("Error. No se pudo abrir el archivo $this->filename");
            while ( ! gzeof( $fp ) )
                {
                $line = gzgets( $fp, 1024 );
                $SQL .= "$line";
                }
            gzclose($fp);
            return $SQL;
        }
/**
* Restore the data from file
* @access public
*/
    function perform_restore()
        {
            $SQL = explode("#<--break-->", $this->_Open());
            $link = mysql_connect($this->host, $this->dbuser, $this->dbpass) or (die (mysql_error()));
            mysql_select_db($this->dbname, $link) or (die (mysql_error()));

			mysql_query( "set names 'utf8'" );
            //---- And now execute the SQL statements from backup file.
            for ($i=0;$i<count($SQL)-1;$i++)
                {
                    mysql_unbuffered_query($SQL[$i]) or (die (mysql_error()));
                }
            return 1;
            }
}
?>