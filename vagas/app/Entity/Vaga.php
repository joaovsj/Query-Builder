<?php 

namespace App\Entity;
use \App\Db\Database;
use\PDO;
date_default_timezone_set('America/Sao_Paulo');

class Vaga{
    
    public $id;
    public $titulo;
    public $descricao;
    public $ativo;
    public $data;

    // criar um cadastro de Vaga com os dados da própria instancia
    public function cadastrar(){
        
        // defininindo a data
        $this->data = date('Y-m-d H:i:s');

        // inserir a data no banco 
        // atribuir o id da vaga na instancia
        $obDatabase = new Database('vagas');
        /* chave => nome do Campo */
        $this->id = $obDatabase->insert([  
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);        

        return true;
    }

    //ele é statico por que vai retornar um array varias intancias de vagas, mas eu não preciso da instancia real no momento da consulta
    public static function getVagas($where = null, $order = null, $limit = null){
        // por que eu preciso apenas do resultado que essa instancia vai me trazer
        return (new Database('vagas'))
        ->select($where, $order, $limit)
        ->fetchAll(PDO::FETCH_CLASS, self::class);        
        /*array de classes, objeto da classe especificada*/ 
    }

    // retorna dados com relação ao id
    public static function getVaga($id){
        return (new Database('vagas'))
        ->select('id = '.$id)
        ->fetchObject(self::class);
    }

    public function atualizar(){
        return (new Database('vagas'))->update('id = '.$this->id,[  
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);
    }

    public function excluir(){
        return (new Database('vagas'))
        ->delete('id = '.$this->id);
    }
}   
