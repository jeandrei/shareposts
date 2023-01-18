<?php 

    class Posts extends Controller {

        
        public function __construct(){
            //IMPEDE O ACESSO A POSTS SE NÃO ESTIVER LOGADO
            // isLoggedIn está no arquivo session_helper
            if(!isLoggedIn()){
                redirect('users/login');
            }

            // Carregamos o model
            // $this->model('Post') pq Posts extends Controller
            $this->postModel = $this->model('Post');
            // para poder aproveitar uma função de outro model basta adicionar ele
            // aqui por exemplo adicionei o User para poder usar a função
            // $user = $this->userModel->getUserById($post->user_id);
            $this->userModel = $this->model('User');
        }

        public function index(){

            // Get posts
            $posts = $this->postModel->getPosts();
            
            $data = [
                'posts' => $posts
            ];

            $this->view('posts/index', $data);
        }

        public function add(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate title
                if(empty($data['title'])){
                    $data['title_err'] = 'Por favor informe o título';
                }

                  // Validate body
                  if(empty($data['body'])){
                    $data['body_err'] = 'Por favor informe o texto';
                }
                
                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err'])){
                   // Validate
                   if($this->postModel->addPost($data)){
                    flash('post_message', 'Post Adicionado');
                    redirect('posts');
                   } else {
                    die('Algo de errado aconteceu');
                   }
                } else {
                    // Load view with errors
                    $this->view('posts/add', $data);
                }
    
            } else {

            $data = [
                'title' => '',
                'boddy' => ''
            ];

            $this->view('posts/add', $data);
            }

        }

        public function edit($id){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate title
                if(empty($data['title'])){
                    $data['title_err'] = 'Por favor informe o título';
                }

                  // Validate body
                  if(empty($data['body'])){
                    $data['body_err'] = 'Por favor informe o texto';
                }
                
                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err'])){
                   // Validate
                   if($this->postModel->updatePost($data)){
                    flash('post_message', 'Post Atualizado');
                    redirect('posts');
                   } else {
                    die('Algo de errado aconteceu');
                   }
                } else {
                    // Load view with errors
                    $this->view('posts/edit', $data);
                }
    
            } else {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);
            
            // Check for owner
            // se não for dono do post ele redireciona para o posts
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            $data = [
                //id que vem da própria função public function edit($id){
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];

            $this->view('posts/edit', $data);
            }

        }
    
    
        public function show($id){
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($post->user_id);
            
            $data = [
                'post' => $post,
                'user' => $user
            ];


            $this->view('posts/show' ,$data);
        }

        public function delete($id){           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            // Get existing post from model
            $post = $this->postModel->getPostById($id);            
            // Check for owner
            // se não for dono do post ele redireciona para o posts
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }                
                if($this->postModel->deletePost($id)){
                    flash('post_message', 'Post Removido');
                    redirect('posts');
                } else {
                    die('Algo de errado aconteceu');
                }
            } else {
                redirect('posts');
            }
        }
    
    
    
    
    }


?>