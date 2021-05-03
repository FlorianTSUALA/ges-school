<?php

use IToast;

 namespace Core\Session;

 class ToastBuilder implements IToast{

    private $options = [];
    private $title = "";
    private $message = "";
    
    private $building = "";

    private function add2option($tag, $value){
        array_push($this->options, [$tag => $value]);
    }

    private function builder(): string{
        $json_options = "{";

        $this->building = '"'.$this->title.'", "'.$this->message;

        //Build Json Options
        foreach($this->options as $key => $value){

            end($this->options);

            if($key == key($this->options))
                $json_options .= "{$key}: {$value}";
            else
                $json_options .= "{$key}: {$value}, ";

        }

        $json_options .= "}";

        $this->building .= ", ".$this->message;
        
        return $json_options;
    }


    public function timeOut($timeOut = 10000) : IToast
    {
        $this->add2option('"timeOut"', $timeOut);
        array_push($this->str_options, '"timeOut": '.$timeOut); 
        return $this;
    }

    public function extendedTimeOut($extendedTimeOut = 2000) : IToast
    {
        $this->add2option('"extendedTimeOut"', $extendedTimeOut);
        array_push($this->str_options, '"extendedTimeOut": '.$extendedTimeOut); 
        return $this;
    }

    public function showMethod($showMethod = 'slideDown') : IToast
    {
        $this->add2option('"showMethod"', '"'.$showMethod.'"');
        array_push($this->str_options, '"showMethod": "'.$showMethod.'"'); 
        return $this;
    }

    public function hideMethod($hideMethod = 'slideUp') : IToast
    {
        $this->add2option('"hideMethod"', ''.$hideMethod.'');
        array_push($this->str_options, '"hideMethod": '.$hideMethod.''); 
        return $this;
    }

    public function closeMethod($closeMethod = 'slideUp') : IToast
    {
        $this->add2option('"closeMethod"', ''.$closeMethod.'');
        array_push($this->str_options, '"closeMethod": '.$closeMethod.''); 
        return $this;
    }

    public function progressBar($progressBar = true) : IToast
    {
        $this->add2option('"progressBar"', $progressBar);
        array_push($this->str_options, '"progressBar: '.$progressBar); 
        return $this;
    }

    public function preventDuplicates($preventDuplicates = true) : IToast
    {
        $this->add2option('"preventDuplicates"', $preventDuplicates);
        array_push($this->str_options, '"preventDuplicates: '.$preventDuplicates); 
        return $this;
    }

    public function init($title, $message) : IToast{
        $this->title = $title;
        $this->message = $message;
        return $this;
    }

    public function build($title, $message) : String{
        $this->title = $title;
        $this->message = $message;
        return $this->builder();
    }

    public function default($title, $message) : String{
        $this->title = $title;
        $this->message = $message;
        
        $this->timeOut()->
        $this->extendedTimeOut()->
        $this->showMethod()->
        $this->hideMethod()->
        $this->closeMethod()->
        $this->progressBar()->
        $this->preventDuplicates();
        
        return $this->builder();
    }


} 