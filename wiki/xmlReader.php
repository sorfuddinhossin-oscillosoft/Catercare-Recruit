<?php
/**
 * @package Sorfuddin
 */
/*
Plugin Name: xmlReader
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
/**
 * XML2Assoc Class to creating
 * PHP Assoc Array from XML File
 *
 * @author godseth (AT) o2.pl & rein_baarsma33 (AT) hotmail.com (Bugfixes in parseXml Method)
 * @uses XMLReader
 *
 */
class Xml2Assoc {

    /**
     * Optimization Enabled / Disabled
     *
     * @var bool
     */
    protected $bOptimize = false;
    
    

    /**
     * Method for loading XML Data from String
     *
     * @param string $sXml
     * @param bool $bOptimize
     */

    public function parseString( $sXml , $bOptimize = false) {
        $oXml = new XMLReader();
        $this -> bOptimize = (bool) $bOptimize;
        try {

            // Set String Containing XML data
            $oXml->XML($sXml);

            // Parse Xml and return result
            return $this->parseXml($oXml);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Method for loading Xml Data from file
     *
     * @param string $sXmlFilePath
     * @param bool $bOptimize
     */
    public function parseFile( $sXmlFilePath , $bOptimize = false ) {
    	$oXml = new XMLReader();
        $this -> bOptimize = (bool) $bOptimize;
        try {
            // Open XML file
            $oXml->open($sXmlFilePath);

            // // Parse Xml and return result
            return $this->parseXml($oXml);

        } catch (Exception $e) {
            echo $e->getMessage(). ' | Try open file: '.$sXmlFilePath;
        }
    }

    /**
     * XML Parser
     *
     * @param XMLReader $oXml
     * @return array
     */
    protected function parseXml( XMLReader $oXml ) {

        $aAssocXML = null;
        $iDc = -1;

        while($oXml->read()){
            switch ($oXml->nodeType) {

                case XMLReader::END_ELEMENT:

                    if ($this->bOptimize) {
                        $this->optXml($aAssocXML);
                    }
                    return $aAssocXML;
                case XMLReader::ELEMENT:

                    if(!isset($aAssocXML[$oXml->name])) {
                        if($oXml->hasAttributes) {
                            $aAssocXML[$oXml->name][] = $oXml->isEmptyElement ? '' : $this->parseXML($oXml);
                        } else {
                            if($oXml->isEmptyElement) {
                                $aAssocXML[$oXml->name] = '';
                            } else {
                                $aAssocXML[$oXml->name] = $this->parseXML($oXml);
                            }
                        }
                    } elseif (is_array($aAssocXML[$oXml->name])) {
                        if (!isset($aAssocXML[$oXml->name][0]))
                        {
                            $temp = $aAssocXML[$oXml->name];
                            foreach ($temp as $sKey=>$sValue)
                            unset($aAssocXML[$oXml->name][$sKey]);
                            $aAssocXML[$oXml->name][] = $temp;
                        }

                        if($oXml->hasAttributes) {
                            $aAssocXML[$oXml->name][] = $oXml->isEmptyElement ? '' : $this->parseXML($oXml);
                        } else {
                            if($oXml->isEmptyElement) {
                                $aAssocXML[$oXml->name][] = '';
                            } else {
                                $aAssocXML[$oXml->name][] = $this->parseXML($oXml);
                            }
                        }
                    } else {
                        $mOldVar = $aAssocXML[$oXml->name];
                        $aAssocXML[$oXml->name] = array($mOldVar);
                        if($oXml->hasAttributes) {
                            $aAssocXML[$oXml->name][] = $oXml->isEmptyElement ? '' : $this->parseXML($oXml);
                        } else {
                            if($oXml->isEmptyElement) {
                                $aAssocXML[$oXml->name][] = '';
                            } else {
                                $aAssocXML[$oXml->name][] = $this->parseXML($oXml);
                            }
                        }
                    }

                    if($oXml->hasAttributes) {
                        $mElement =& $aAssocXML[$oXml->name][count($aAssocXML[$oXml->name]) - 1];
                        while($oXml->moveToNextAttribute()) {
                            $mElement[$oXml->name] = $oXml->value;
                        }
                    }
                    break;
                case XMLReader::TEXT:
                case XMLReader::CDATA:

                    $aAssocXML[++$iDc] = $oXml->value;

            }
        }

        return $aAssocXML;
    }

    /**
     * Method to optimize assoc tree.
     * ( Deleting 0 index when element
     *  have one attribute / value )
     *
     * @param array $mData
     */
    public function optXml(&$mData) {
        if (is_array($mData)) {
            if (isset($mData[0]) && count($mData) == 1 ) {
                $mData = $mData[0];
                if (is_array($mData)) {
                    foreach ($mData as &$aSub) {
                        $this->optXml($aSub);
                    }
                }
            } else {
                foreach ($mData as &$aSub) {
                    $this->optXml($aSub);
                }
            }
        }
    }
}
?>