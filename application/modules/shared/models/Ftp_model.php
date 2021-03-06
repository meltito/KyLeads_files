<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ftp_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->library('ftp');
    }

    /**
     * tests wether or not a FTP connection can be made and wether or not the path is ok
     * @param  string   $server
     * @param  string   $user
     * @param  string   $pass
     * @param  string   $port
     * @param  string   $path
     * @return array    $return
     */
    public function test($server, $user, $pass, $port, $path)
    {
    	$return = array();//return array

    	$config['hostname'] = $server;
    	$config['username'] = $user;
    	$config['password'] = $pass;
    	$config['port'] = $port;
    	$config['debug'] = FALSE;

        //connection is ok
    	if ($this->ftp->connect($config))
        {
    		//test the path
    		$list = $this->ftp->list_files( $path );
    		if ($list)
            {
    			$return['connection'] = TRUE;
    		}
            else
            {
    			$return['connection'] = FALSE;
    			$return['problem'] = "path";
    		}

    	}
        //connection failed
        else
        {
    		$return['connection'] = FALSE;
    		$return['problem'] = "connection";
    	}

    	$this->ftp->close();

    	return $return;
    }

    /**
     * FTP Test login
     * @param  string   $server
     * @param  string   $user
     * @param  string   $pass
     * @param  string   $port
     * @return mixed    $ftpConnection/FALSE
     */
    public function testLogin($server, $user, $pass, $port)
    {
    	$config['hostname'] = $server;
    	$config['username'] = $user;
    	$config['password'] = $pass;
    	$config['port'] = $port;
    	$config['debug'] = FALSE;

    	if ($this->ftp->connect($config))
        {
    		$this->ftp->close();
    		return $ftpConnection;
    	}
        else
        {
    		$this->ftp->close();
    		return FALSE;
    	}
    }

    /**
     * tests the path
     * @param  string   $server
     * @param  string   $user
     * @param  string   $pass
     * @param  string   $port
     * @param  string   $path
     * @return boolean  TRUE/FALSE
     */
    public function testPath($server, $user, $pass, $port, $path)
    {
    	$config['hostname'] = $server;
    	$config['username'] = $user;
    	$config['password'] = $pass;
    	$config['port'] = $port;
    	$config['debug'] = FALSE;

    	if ($this->ftp->connect($config))
        {
    		$list = $this->ftp->list_files($path);
    		if ($list)
            {
    			$this->ftp->close();
    			return TRUE;
    		}
            else
            {
    			$this->ftp->close();
    			return FALSE;
    		}
    	}
        else
        {
    		$this->ftp->close();
    		return FALSE;
    	}
    }

}