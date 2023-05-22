# Query Builder
 Exemplo de uma aplicação usando Query Builder. Com ela podemos criar comandos SQL dinâmicamente, 
 sem precisar ficarmos fazendo tudo à mão.
 
 Para isso temos uma classe dento do diretório **App\Db\Database** </br>
 Ela é responsável por fazer toda a contrução de todas as nossas consultas.
 Ainda dentro do diretório **app**, temos outro chamado **Entity**, ali dentro podemos colocar as entidades que consumirão da nossa classe.
 
 Tudo que precisamos fazer é setarmos os valores dentro de um arquivo que vai receber a requisição. Exatamente similar a um ORM (Active Record).
 

```php
    use \App\Entity\Vaga;
    $obVaga = new Vaga;

    if(isset($_POST['titulo'],$_POST['descricao'],$_POST['ativo'])){

        $obVaga = new Vaga();
        $obVaga->titulo = $_POST['titulo'];
        $obVaga->descricao = $_POST['descricao'];
        $obVaga->ativo = $_POST['ativo'];
        $obVaga->cadastrar();
    
        header('Location: index.php?status=success');
        exit;
    }
```
 
 Agora dentro da nossa *entidade*, definimos nossas propriedades e os métodos respectivos:
 ```php
   namespace App\Entity;
   use \App\Db\Database;
   use\PDO;
 
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

 ```
 Quando instânciamos a classe Database, passamos como parâmetro para um construtor a tabela que vamos trabalhar, após isso podemos acessar vários métodos
 onde passamos um array/vetor com as chaves sendo as colunas do banco de dados e os valores aqueles que estão definidos na prória classe. Nesse caso, ele cadastra e retorna
 o último ID inserido.
 
 > lembrando que esses dados podem ser substituídos pelos valores que você quiser, esses são apenas exemplos de como cconsumir essa classe.
 Eu vou deixar alguns exemplos de outras operações.
 
 ### Atualizar
 
 ```php
       if(isset($_POST['titulo'],$_POST['descricao'],$_POST['ativo'])){

        $obVaga->titulo = $_POST['titulo'];
        $obVaga->descricao = $_POST['descricao'];
        $obVaga->ativo = $_POST['ativo'];
    
        $obVaga->atualizar();
        header('Location: index.php?status=success');
        exit;
    }
 ```
 
 ```php
      public function atualizar(){
        return (new Database('vagas'))->update('id = '.$this->id,[  
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);
    }
 ```
 ### Resgatar todos os valores, sendo passível de aplicar filtros.
 
 ```php
    $vagas = Vaga::getVagas($where);  

 ```
 
 ```php
        public static function getVagas($where = null, $order = null, $limit = null){
        // por que eu preciso apenas do resultado que essa instancia vai me trazer
        return (new Database('vagas'))
        ->select($where, $order, $limit)
        ->fetchAll(PDO::FETCH_CLASS, self::class);        
        /*array de classes, objeto da classe especificada*/ 
    }

 ```
 
 Para fazer o teste e explorar ainda outras mais operações, basta importar o banco e adicionar a aplicação no seu localhost.
 Exigindo pelo menos o PHP >= 7
