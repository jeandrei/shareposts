<?php
// Load Config
require_once 'config/config.php';

// Load Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';

// Load Libraries
// apenas carrega todos os arquivos necessários
// para não ter que adicionar uma lista de arquivos em todas as páginas
// carregamos apenas o bootstrap.php


// Autoload Core Libraries vai ler automaticamente 
//dar um require_once em todos os arquivos dentro de libraries
spl_autoload_register(
    function($className){
    require_once 'libraries/' . $className . '.php';
    }
);//spl_autoload_register