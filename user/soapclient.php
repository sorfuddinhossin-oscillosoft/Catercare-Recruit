<?php
class SimpleSoapClient
{
  protected $host;
  protected $port;
  protected $ns;
  protected $url;
  protected $act;
  protected $debug;

  protected function Post($method, $params)
  {
    return $this->_Post($method, $params);
  }

  protected function _Post($method, $params)
  {

    $namespaces = array();
    foreach($params as $p)
    {
      if (isset($p->ns))
      {
        if ($namespaces[$p->ns])
          $p->prefix = $namespaces[$p->ns];
        else
          $p->prefix = $namespaces[$p->ns] = 'ns'.count($namespaces);
      }
    }   

    if ($this->debug)
    {
      $cn = get_class($this);
      echo "\n   ======   Calling $cn::$method   ======   \n\nParams: ";
      print_r($params);
    }

    $host = $this->host;
    $port = $this->port;
    $ns   = $this->ns;
    $url  = $this->url;
    $act  = $this->act;

    $fp = fsockopen($host, $port, $errno, $errstr, 30);
    if (!$fp)
      die ("Oops: $errstr ($errno)<br />\n");

    $xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?><s:Envelope xmlns:s=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"";
    foreach($namespaces as $k=>$v)
      $xml .= " xmlns:$v=\"$k\"";
    $xml .= "><s:Body><$method xmlns=\"$ns\">";
    foreach($params as $k=>$v) 
      $xml .= "<$k>$v</$k>";
    $xml .= "</$method></s:Body></s:Envelope>";
    $head = "POST $url HTTP/1.1\r\n"
          . "Host: $host\r\n"
          . "Content-Type: text/xml; charset=utf-8\r\n"
          . "Content-Length: ".strlen($xml)."\r\n"
          . "SOAPAction: \"$act$method\"\r\n"
          . "Connection: Close\r\n\r\n";

    if ($this->debug)
      echo "\nRequest:\n\n$head$xml\n\n";

    $s;
    fwrite($fp, $head.$xml);
    while (!feof($fp)) 
      $s .= fgets($fp);
    fclose($fp);
    $s = trim(substr($s,strpos($s, "\r\n\r\n")));

    if ($this->debug)
      echo "Response:\n\n$s\n\n";

    if (strstr($s,'<error_message>'))
      die("\nError communicating with SOAP server.\n");

    return($this->xml2assoc($s));
  }

  private function xml2assoc($xmlstring) 
  {
    $xml;
    if (is_object($xmlstring))
      $xml = $xmlstring;
    else
    {
      $xml = new XMLReader();
      $xml->xml($xmlstring);
    }

    $tree = null;
    while($xml->read())
    {
      switch ($xml->nodeType) 
      {
        case XMLReader::END_ELEMENT: return $tree;
        case XMLReader::ELEMENT:
          $node = array('tag' => $xml->name, 
            'value' => $xml->isEmptyElement ? '' : $this->xml2assoc($xml));
          if($xml->hasAttributes)
            while($xml->moveToNextAttribute())
              $node['attributes'][$xml->name] = $xml->value;
          $tree[] = $node;
          break;
        case XMLReader::TEXT:
        case XMLReader::CDATA:
          $tree .= $xml->value;
      }
    }
    // if ($this->debug) { echo "\nTREE:\n"; print_r($tree); }
    return  $tree;
  }  

  public function DateFormat($date=null)
  {
    if (is_string($date))
      $date = new DateTime($date);
    return implode('-',array_slice(split('-',$date ? $date->format('c') : date('c')), 0, 3));
  }

}


class SimpleSoapType
{
  public $prefix;
  public $type;
  public $value;
  public $ns;
  function __construct($value)
  {
    $this->value  = $value;
  }
  function __toString()
  {
    $t = (isset($this->prefix) ? $this->prefix.':' : '').$this->type; 
    $st = "<$t>"; $et = "</$t>";
    if (is_array($this->value))
      foreach ($this->value as $v)
        $r .= $st.$v.$et;
    else
      $r = $st.$this->value.$et;
    return $r;
  }
  protected function init() { throw('init is abstract'); }
}

?>
