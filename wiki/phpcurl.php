<?php
/* @package Sorfuddin
 */
/*
Plugin Name: phpCURL
Plugin URI: http://sorfuddin.com/
Description: Zoho Integration.
Version: 2.4.0
Author: Automattic
Author URI: http://facebook.com/sorfuddin/
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/
/*
Sean Huber CURL library

This library is a basic implementation of CURL capabilities.
It works in most modern versions of IE and FF.

==================================== USAGE ====================================
It exports the CURL object globally, so set a callback with setCallback($func).
(Use setCallback(array('class_name', 'func_name')) to set a callback as a func
that lies within a different class)
Then use one of the CURL request methods:

get($url);
post($url, $vars); vars is a urlencoded string in query string format.

Your callback function will then be called with 1 argument, the response text.
If a callback is not defined, your request will return the response text.
*/

class CURL {
    var $callback = false;

function setCallback($func_name) {
    $this->callback = $func_name;
}

function doRequest($method, $url, $vars) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    }
    $data = curl_exec($ch);
   
    if ($data) {
        if ($this->callback)
        {
            $callback = $this->callback;
            $this->callback = false;
            return call_user_func($callback, $data);
        } else {
            return $data;
        }
    } else {
        return curl_error($ch);
    }
     curl_close($ch);
}

function get($url) {
	echo 'In curl class';
	    return $this->doRequest('GET', $url, 'NULL');
}

function post($url, $vars) {
    return $this->doRequest('POST', $url, $vars);
}
}
?>
