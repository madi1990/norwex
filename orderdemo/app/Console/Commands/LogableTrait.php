<?php
namespace App\Console\Commands;

trait LogableTrait{
    private $logArray = array();

    private function echoLog($message){
		$dateTime = new \DateTime();
        $log = $dateTime->format('Y-m-d H:i:s'). " - ". $message. PHP_EOL;
        $this->logArray[] = $log;
        echo $log;
        return $log;
    }

    private function fileLog($name = ''){
        $path = storage_path('logs/'. $name. uniqid());
        file_put_contents($path, implode("\r\n", $this->logArray), FILE_APPEND);
        return true;
    }
}