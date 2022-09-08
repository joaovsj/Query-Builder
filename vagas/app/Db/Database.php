<?php 

namespace App\Db;
use \PDO;


class Database{

    const HOST = 'localhost';
    const NAME = 'query_builder';
    const USER = 'root';
    const PASS = '';

    private $table;
    private $connection;

    // defini a tabela e instancia a conexao
    public function __construct($table = null){
        $this->table = $table;
        $this->setConnection();
    }

    // cria uma conexao com banco de dados
    private function setConnection(){
        try {
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME.';charset=utf8', self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        } catch (\PDOException $e) {
            die('Erro: '.$e->getMessage());
        }
    }

    /**
     * metodo responsavel por inserir os dados no banco
     * @param array $values[fileds => values]
     */
    public function insert($values){

        // dados da query
        $fields = array_keys($values); 
        // criar as posições 
        $binds = array_pad([], count($fields),'?');
                
        
        
        //monta a query
        $query = 'INSERT INTO '.$this->table.'('.implode(',', $fields).') VALUES('.implode(',', $binds).')';
        
        //  devem ser passados apenas indices numericos
        $this->execute($query, array_values($values));

        // metodo que retorna o ultimo id inserido
        return $this->connection->lastInsertId(); 
    }

    /**
     * metodo responsavel por executar a query
     * @param $query -> query 
     * @param $params -> são os valores que precisam ser
     * inseridos apenas com os indices numéricos, se não funciona
     */
    public function execute($query, $params = []){
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (\PDOException $e) {
            die('Erro: '.$e->getMessage());
        }
    }

    public function select($where = null, $order = null, $limit = null, $fields = '*'){
        
        // dados da query
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY'.$order : '';
        $limit = strlen($limit) ? 'LIMIT'.$limit : '';

        // monta  a query
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        // executa a query
        return $this->execute($query);

    }

    public function update($where, $values){

        // dados da query
        $fields  = array_keys($values);

        // monta a query
        $query = 'UPDATE '.$this->table.' SET '.implode('=?, ', $fields).'=? WHERE '.$where;
        
        // values -> devem ser passados com indices numericos
        $this->execute($query, array_values($values));
    
        return true;
    }

    public function delete($where){
        
        //monta a query
        $query = 'DELETE FROM '.$this->table.' WHERE '. $where;

        // executa a query 
        $this->execute($query);

        return true;
    }
}
