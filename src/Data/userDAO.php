<?php
namespace MyApp\Data;

class userDAO
{
  private $ch;  
  
  public $output;
  public $outputArray;
 

  function __construct($url)
  {
    $this->ch = curl_init($url);
    curl_setopt($this->ch, CURLOPT_URL, $url);
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->ch, CURLOPT_HEADER, 0);

  }
// Zadanie 1. 

  public function getAll()
  {
    try {
      $this->output = curl_exec($this->ch);
      $this->outputArray = json_decode($this->output, true);

      if (is_array($this->outputArray)) {
        return $this->outputArray;
      } else {
        var_dump($this->output);
      }
      curl_close($this->ch);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
// Zadanie 2

  public function getDomain()
  {
    $inputArray = $this->getAll();

    if (is_array($inputArray)) {
      
        if ($inputArray['email']) {
          $this->output = explode('@', $inputArray['email'])[1];
        }
      
      return $this->output;
    }
  }
// Zadanie 3

  public function getPersonData()
  {
    $inputArray = $this->getAll();    

    if (is_array($inputArray)) {
      
        if ($inputArray['id']) {
          unset($inputArray['id']);
        }
        if ($inputArray['address']) {
          unset($inputArray['address']);
        }
        if ($inputArray['company']) {
          unset($inputArray['company']);
        }
      
      return json_encode($inputArray);
    }
  }
}

