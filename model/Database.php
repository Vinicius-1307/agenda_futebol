
<?php
    class BancoAgendaFutebol {
        private $host = "127.0.0.1";
        private $user = "root";
        private $senha = "";
        private $banco = "agenda_futebol";
        private $porta = "3306";
        private $con=null;
        private function conectar(){
            $this->con = new mysqli( $this->host, $this->user,$this->senha,$this->banco, $this->porta);
            if ( $this->con->connect_error) {
                die("Falha ao conectar: " . $this->con->connect_error);
            }
        }
        public function getConexao(){
            if( $this->con==null){
                $this->conectar();
            }
            return $this->con;
        }
    }
?>
