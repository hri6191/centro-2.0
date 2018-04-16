<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setdatabase extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
                        // Name of the file
            $filename = base_url().'database/basic_billing.sql';
            // MySQL host
            $mysql_host = 'localhost';
            // MySQL username
            $mysql_username = 'root';
            // MySQL password
            $mysql_password = '';
            // Database name
            $mysql_database = 'chiripa';

            // Connect to MySQL server
            mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
            // Select database
            mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

            // Temporary variable, used to store current query
            $templine = '';
            // Read in entire file
            $lines = file($filename);
            // Loop through each line
            foreach ($lines as $line)
            {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';')
            {
                // Perform the query
                mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                // Reset temp variable to empty
                $templine = '';
            }
            }
             echo "Tables imported successfully";
	}
	      
}