<?php

 namespace Core\Session;

 interface IToast{
    
    public function timeOut($timeOut = 10000) : IToast;
    public function extendedTimeOut($extendedTimeOut = 2000) : IToast;
    public function showMethod($showMethod = 'slideDown') : IToast;
    public function hideMethod($hideMethod = 'slideUp') : IToast;
    public function closeMethod($closeMethod = 'slideUp') : IToast;
    public function progressBar($progressBar = true) : IToast;
    public function preventDuplicates($preventDuplicates = true) : IToast;
    public function build($title, $message) : String;
    public function default($title, $message) : String;

} 