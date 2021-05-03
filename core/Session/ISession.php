<?php

namespace Core\Session;

interface ISession{
    
    //Help to manage flash messge
    function has();
    function get();
    function flush();


}