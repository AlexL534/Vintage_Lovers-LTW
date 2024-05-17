<?php

    class Session {
        private array $messages;

        public function __construct() {
            session_start();
      
            $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
            unset($_SESSION['messages']);
            
            //token for increase security
            if (!isset($_SESSION['csrf'])) {
                $_SESSION['csrf'] = $this->generate_random_token();
            }
        }

        public function isLoggedIn() : bool {
            return isset($_SESSION['id']);    
        }

        public function logout() {
            session_destroy();
        }

        public function getId() : ?int {
            return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
        }
    
        public function getUserName() : ?string {
            return isset($_SESSION['Username']) ? $_SESSION['Username'] : null;
        }
    
        public function setId(int $id) {
            $_SESSION['id'] = $id;
        }
    
        public function setUsername(string $Username) {
            $_SESSION['Username'] = $Username;
        }
    
        public function addMessage(string $type, string $text) {
            $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
        }
    
        public function getMessages() {
            return $this->messages;
        }

        function generate_random_token() {
            return bin2hex(openssl_random_pseudo_bytes(32));
        }
    }