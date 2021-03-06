<?php

// @author Caique M. Oliveira
// @data 12/04/2018
// @description Classe cliente

class ClienteDAO
{
  /**
  * Insere um novo cliente no banco de dados
  * @param $clienteObj Objeto Cliente qual será inserido no banco de dados
  * @return Int Identificação (idCliente) do novo cliente inserido no banco de dados
  * @return null Falha ao tentar registrar o cliente na base de dados
  */
  function cadastrarCliente($clienteObj)
  {
    // Instância de acesso ao db
    $mySql = new MySql();

    // Abre uma nova conexão com o db
    $con = $mySql->getConnection();

    $stmt = $con->prepare(
      'INSERT INTO tbl_cliente ('.
        'nome,'.
        'dtNasc,'.
        'cpf,'.
        'email,'.
        'celular,'.
        'id_endereco,'.
        'sexo,'.
        'telefone,'.
        'id_usuario,'.
        'foto_perfil'.
      ') VALUES(?,?,?,?,?,?,?,?,?,?)'
    );

    $stmt->bindParam(1, $clienteObj->nome);
    $stmt->bindParam(2, $clienteObj->dtNasc);
    $stmt->bindParam(3, $clienteObj->cpf);
    $stmt->bindParam(4, $clienteObj->email);
    $stmt->bindParam(5, $clienteObj->celular);
    $stmt->bindParam(6, $clienteObj->idEndereco);
    $stmt->bindParam(7, $clienteObj->sexo);
    $stmt->bindParam(8, $clienteObj->telefone);
    $stmt->bindParam(9, $clienteObj->idUsuario);
    $stmt->bindParam(10, $clienteObj->foto);

    // Verifica se a inserção do registro ocorreu com sucesso e retorna a resposta adquirida
    $result = $stmt->execute() ? $con->lastInsertId() : null;

    // Fecha a conexão com o db
    $con = null;

    return $result;
  }

  /**
  * Atualiza o cliente no banco de dados
  * @param $clienteObj Objeto Cliente qual será atualizado no banco de dados
  * @return true Cliente atualizado com sucesso na base de dados
  * @return false Falha ao tentar atualizar o cliente na base de dados
  */
  function atualizarCliente($clienteObj)
  {
    // Instância de acesso ao db
    $mySql = new MySql();

    // Abre uma nova conexão com o db
    $con = $mySql->getConnection();

    $stmt = $con->prepare(
      'UPDATE tbl_cliente SET '.
        'nome = ?,'.
        'dtNasc = ?,'.
        'cpf = ?,'.
        'email = ?,'.
        'celular = ?,'.
        'id_endereco = ?,'.
        'sexo = ?,'.
        'telefone = ?,'.
        'foto_perfil = ? '.
        'WHERE '.
        'id_cliente = ?'
    );

    $stmt->bindParam(1, $clienteObj->nome);
    $stmt->bindParam(2, $clienteObj->dtNasc);
    $stmt->bindParam(3, $clienteObj->cpf);
    $stmt->bindParam(4, $clienteObj->email);
    $stmt->bindParam(5, $clienteObj->celular);
    $stmt->bindParam(6, $clienteObj->idEndereco);
    $stmt->bindParam(7, $clienteObj->sexo);
    $stmt->bindParam(8, $clienteObj->telefone);
    $stmt->bindParam(9, $clienteObj->foto);
    $stmt->bindParam(10, $clienteObj->idCliente);

    // Verifica se a atualização do registro ocorreu com sucesso e retorna a resposta adquirida
    $result = $stmt->execute() ? true : false;

    // Fecha a conexão com o db
    $con = null;

    return $result;

  }

  /**
  * Verifica se o cpf existente na base de dados pertence ao objeto informado
  * @param $clienteObj Objeto Cliente qual terá seu CPF checada
  * @return true Cliente proprietário do cpf contido no objeto Cliente
  * @return false Cliente não proprietário do cpf contido no objeto Cliente
  */
  function proprietarioCpf($clienteObj)
  {
    // Instância de acesso ao db
    $mySql = new MySql();

    // Abre uma nova conexão com o db
    $con = $mySql->getConnection();

    $stmt = $con->prepare('SELECT COUNT(*) AS counter FROM tbl_cliente WHERE cpf = ? AND id_cliente <> ?');
    $stmt->bindParam(1, $clienteObj->cpf);
    $stmt->bindParam(2, $clienteObj->idCliente);

    // Verifica se o select foi executado com êxito
    if($stmt->execute())
    {
      while ($answer = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result = $answer['counter'] > 0 ? false : true;
      }
    }

    // Fecha a conexão com o db
    $con = null;

    return $result;
  }

  /**
  * Obtém todos os clientes existentes na base de dados
  * @return Array Contendo todos os clientes existentes na base de dados
  * Obs.: Caso ocorra algum erro ao tentar realizar a consulta na base de dados este retornará um array contendo um índice ("error") com o valor true ("error":true)
  */
  function obterClientes()
  {

    // Array qual irá armazenas os clientes existentes
    $clientes = array('error'=>true);

    // Instância de acesso ao db
    $mySql = new MySql();

    // Abre uma nova conexão com o db
    $con = $mySql->getConnection();

    $stmt = $con->prepare(
      'SELECT '.
      'tbl_cliente.id_usuario AS idUsuario, '.
      'id_endereco AS idEndereco, '.
      'id_cliente AS idCliente, '.
      'foto_perfil AS foto, '.
      'nome, '.
      'dtNasc, '.
      'cpf, '.
      'email, '.
      'celular, '.
      'telefone, '.
      'sexo, '.
      'usr.ativo '.
      'FROM tbl_cliente '.
      'INNER JOIN tbl_usuario AS usr '.
      'ON usr.id_usuario = tbl_cliente.id_usuario'
    );

    // Verifica se o select foi executado com êxito
    if($stmt->execute())
    {
      // Popula a lista com os objetos clientes advindos do DB
      while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
        $clientes[] = $rs;
      }
    }

    // Fecha a conexão com o db
    $con = null;

    return $clientes;
  }

  /**
  * Verifica se já encontra-se cadastrado o cpf na base de dados
  * @param $clienteObj Objeto Cliente qual terá seu CPF verificado
  * @return true CPF existente na base de dados
  * @return false CPF inexistente na base de dados
  */
  function cpfExistente($clienteObj)
  {
    // Instância de acesso ao db
    $mySql = new MySql();

    // Abre uma nova conexão com o db
    $con = $mySql->getConnection();

    $stmt = $con->prepare('SELECT COUNT(*) AS counter FROM tbl_cliente WHERE cpf = ?');
    $stmt->bindParam(1, $clienteObj->cpf);

    // Verifica se o select foi executado com êxito
    if($stmt->execute())
    {
      while ($answer = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result = $answer['counter'] > 0 ? true : false;
      }
    }

    // Fecha a conexão com o db
    $con = null;

    return $result;
  }

  /**
  * Obtém um cliente da base de dados
  * @param $idCliente Id do cliente a ser obtido
  * @return PDO (FETCH_OBJ) Objeto cliente existente na base de dados
  * @return null Falha ao tentar obter o cliente na base de dados
  */
  function obterDadosClienteById($idCliente)
  {
    // Armazena os dados do cliente
    $dadosCliente = null;

    // Instância de acesso ao db
    $mySql = new MySql();

    // Abre uma nova conexão com o db
    $con = $mySql->getConnection();

    $stmt = $con->prepare('SELECT * FROM view_cliente WHERE id_cliente = ?');
    $stmt->bindParam(1, $idCliente);

    // Verifica se o select foi executado com êxito
    if($stmt->execute())
    {
      while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
        $dadosCliente = $rs;
      }
    }

    // Fecha a conexão com o db
    $con = null;

    return $dadosCliente;
  }

  /**
  * Deleta o cliente da base de dados
  * @param $clienteObj Objeto cliente qual será excluído
  * @return true Cliente excluído com sucesso
  * @return false Falha ao tentar excluir o cliente
  */
  function deletarCliente($clienteObj)
  {
    // Instância de acesso ao db
    $mySql = new MySql();

    // Abre uma nova conexão com o db
    $con = $mySql->getConnection();

    $stmt = $con->prepare('DELETE FROM tbl_cliente WHERE id_cliente = ?');
    $stmt->bindParam(1, $clienteObj->idCliente);

    try {

      // Executa a statement e armazena a quantidade de registros que foram deletados
      $result = $stmt->execute() ? $stmt->rowCount() : -1;

      // Verifica se a exclusão do registro ocorreu com sucesso
      $result = $result == -1 ? false : true;

    } catch (\Exception $e) {
      $result = false;
    }

    // Fecha a conexão com o db
    $con = null;

    return $result;
  }

}

?>
