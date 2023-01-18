<?php
/*
* App Core Class
* Creates URL and Loads core controller
* URL Format - /controller/method/params
*/
// 1) CRIAMOS A CLASSE, DEFINIMOS OS ATRIBUTOS E DEFINIMOS OS VALORES PADRÃO
//esta classe Core é iniciada no arquivo mvc/public/index.pp
class Core{
    //se for para o endereço localhost/mvc vai automáticamente para o controlador Pages
    protected $currentController = 'Pages';
    // se não for passado nenhum metodo como localhost/mvc/post ele vai direto para o views/pages/index.php
    protected $currentMethod = 'index';
    // se não passar nenhum parâmetro ex localhost/mvc/post/edit/1 que aqui 1 é o parâmetro
    // montamos um array vazio
    protected $params = [];

    // 2) PASSAMOS A URL TRATADA PARA A VARIÁVEL $url
    public function __construct(){
        // print_r($this->getUrl());
        // ao iniciar a classe Core
        // passamos a url já tratada pela função getUrl();
        // ex:  [0]=> string(5) "pages" [1]=> string(5) "about" [2]=> string(2) "33"
        $url = $this->getUrl();


        // 3) VERIFICAMOS SE O ARQUIVO REFERENTE AO CONTROLAOR EXISTE DENTRO DA PASTA CONTROLLERS
        // E CARREGAMOS NO SCRIPT
        //***************CAPTURAR O CONTROLLER DA URL**************************************
        // Look in contrller for first value
        // na linha abaixo ele vai verificar a existencia de um arquivo dentro da pasta /app/controllers
        // função file_exists
        // para o Array  [0]=> string(5) "pages" [1]=> string(5) "about" [2]=> string(2) "33"
        // [0] => pages logo verificamos
        // dentro do if se o arquivo /app/controllers/Pages.php existe
        //ucwords coloca a primeira letra em maúsculo        
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            // if exists, set as controller
            // passamos o controller para a propriedade currentController vai substituir
            // Pages que é o valor padrão pelo valor do indice 0 da variável url neste caso Pages
            $this->currentController = ucwords($url[0]);            
            // Unset 0 Indexs             
            unset($url[0]);
            // fica no array para a o passo 5 Array [1]=> string(5) "about" [2]=> string(2) "33"
        }

        // Require the controller
        // Aqui ele vai requerer o arquivo com base nas propriedades da classe Core
        // Se na propriedade currentController não for passado nada o valor padrão é Pages
        // Logo vai montar
        // (referência 1) require once '../app/controllers/Pages.php'; 
        require_once '../app/controllers/' . $this->currentController . '.php';       
        //Instantiate controller class
        // exemplo que está montando na linha abaixo $pages = new Pages;
        $this->currentController = new $this->currentController;
        //**************************FIM PEGAR CONTROLLER**********************************
        




        // 4) **********************CAPTURAR O METODO DA URL******************************
        // Check for second part of URL method
        // no exemplo localhost/mvc/pages/about/33 - about é o método
        // logo verificaremos dentro da classe Pages se existe o método about
        // pegaremos essa parte com URL[1] Array [1]=> string(5) "about" [2]=> string(2) "33"
        if(isset($url[1])){
            //Check to see if method exists in controller
            //função method_exists verifica se existe um metodo dentro de uma classe
            // nesse caso method_exists(pages, about)
            // estamos verificando se existe o metodo about dentro da classe pages 
            // do arquivo mvc/app/Pages.php
            if(method_exists($this->currentController, $url[1])){
                // se existe setamos o metodo na propriedade currentMethod
                $this->currentMethod = $url[1];                
                unset($url[1]);                
                // array fica [2]=> string(2) "33"
            }
        }        
        //*************************FIM CAPTURAR O METODO DA URL**************************



        // 5)**********************CAPTURAR O PARÂMETRO DA URL***************************
        // Primeira coisa como lá no passo 4 e 5 no final demos um unset($url[0]);
        // ficou apenas um valor no array que é o parametro
        // array(1)  [2]=> string(2) "33"}
        // Get params 
        // a linha abaixo é um if de padrão curto
        // se tiver parametro ele é atribuido ao atributo param da classe
        // se não tiver ele vai receber um array vazio
        // se params puder receber $url ou seja tem algo na $url
        // é verdadeiro e a propriedade params recebe o valor 33 do array([2]=> string(2) "33")       
        // caso contrário recebe um array vazio
        // que é o valor padrão da propriedade params
        $this->params = $url ? array_values($url) : []; 
        /* Call a callback with array of params
        
        se não passar nada na url com valores padrão
        call_user_func_array([Pages, index], []]);
        está executando a classe Pages método index do arquivo /app/controllers/Pages.php
        que foi requerido/adicionado onde eu coloquei referência 1
        */
        call_user_func_array([$this->currentController,$this->currentMethod], $this->params);
        //**********************FIM CAPTURAR O PARÂMETRO DA URL**************************



        }//construct

   
    // 2.1) EXTRAIMOS E PREPARAMOS A URL
    /*   
    dentro do metodo getUrl se dermos um echo $_GET['url'];
    ele vai retornar apenas o que está depois do /mvc
    isso foi configurado em nosso arquivo public/.htasses
    se a url for loclhost/mvc/pages/about/33
    o resultado do $_GET['url'] seria pages/about/33
    só entra na função getUrl se for passado alguma coisa depois do /mvc
    caso contrário ele carrega o /views/pages/index
    */
    public function getUrl(){
        //testamos se existe alguma coisa no GET
        if(isset($_GET['url'])){
            //tiramos a / no final da url rtrim retira espaço em branco ou caractere no final de uma string
            $url = rtrim($_GET['url'], '/');
            // vamos usar filter_var para validar/verificar se é uma url válida
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // quebamos a url em todas as / e transformamos em um array
            $url = explode('/', $url);
            // retornamos o array com os dados da url
            // ao final se tivermos a url /mvc/pages/about/33
            // o método vai retornar o seguinte array
            // Array ( [0] => pages [1] => about [2] => 33 )            
            return $url;
        }
    }
}

//verificaremos agora o método ex mvc/pages/about
// procuraremos dentro da classe Pages se tem o métdo about pegará dentro do array da url
// a posição [1] Array ( [0] => post [1] => edit [2] => 1 )