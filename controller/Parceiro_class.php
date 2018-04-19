<?php

session_start();

/**
* @author Letícia S. Jesus
* @date 16/04/2018
* Obs.: Realiza o CRUD relacionado a Parceiro
* @controller Parceiro.
*/


class Parceiro{

  /**
  * INSERE UM NOVO REGISTRO.
  */
  public function novo(){

    $cadastro = new cadastro();

    require_once(upload_imagem.php);

    //CARREGANDO OS DADOS DIGITADOS PELO USUÁRIO NOS ATRIBUTOS DO objeto/classe.
    //OBS.: INFORMAR OS NOMES DAS TEXTS QUE ESTÃO FALTANDO.
    $cadastro->nome_fantasia = $_POST["txt_nome"];
    $cadastro->razao_social = $_POST["txt_razao"];
    $cadastro->cnpj = $_POST["txt_cnpj"];
    $cadastro->id_endereco = $_POST[""];
    $cadastro->socorrista = $_POST["txt_socorrista"];
    $cadastro->email = $_POST["txt_email"];
    $cadastro->telefone = $_POST["txt_telefone"];
    //$cadastro->foto_perfil = SalvarImagem($_FILES["btn_img_parceiro"]);
    $salvarimagem = SalvarImagem($_FILES['btn_img_parceiro']);
         //var_dump($_FILES['imagem']);
         if($salvarimagem == "false"){
           echo('Erro no uploade ');
         }else{
    $cadastro->foto_perfil=$salvarimagem;
    $cadastro->celular = $_POST["txt_celular"];
    $cadastro->id_usuario = $_POST[""];
    $cadastro->id_plano_contratacao = $_POST["slc_planos"];

    //CHAMANDO O MÉTODO INSERT DA CLASSE ParceiroDAO.
    Cadastro::insert($cadastro);
  }
  /**
  * ATUALIZANDO UM REGISTRO EXISTENTE.
  */
  public function editar(){

    //GUARDA O id DO CADASTRO QUE ESTÁ SENDO PASSADO PELA VIEW.
    $id_cadastro = $_GET['id_pac'];

    $cadastro = new Cadastro();

    $cadastro->nome_fantasia = $_POST["txt_nome"];
    $cadastro->razao_social = $_POST["txt_tazao"];
    $cadastro->cnpj = $_POST["txt_cnpj"];
    $cadastro->id_endereco = $_POST[""];
    $cadastro->socorrista = $_POST[""];
    $cadastro->email = $_POST["txt_email"];
    $cadastro->telefone = $_POST["txt_telefone"];
    $cadastro->foto_perfil = Upload($_FILES["btn_img_parceiro"]);
    $cadastro->celular = $_POST["txt_celular"];
    $cadastro->id_usuario = $_POST[""];
    $cadastro->id_plano_contratacao = $_POST["slc_planos"];

    //CHAMANDO O MÉTODO UPDATE DA CLASSE ParceiroDAO.
    Cadastro::update($cadastro);
  }
  /**
  * EXCLUÍNDO UM REGISTRO.
  */
  public function excluir(){

    //GUARDA O id DO CADASTRO QUE ESTÁ SENDO PASSADO PELA VIEW.
    $id_cadastro = $_GET['id_pac'];

    //INSTÂNCIA DA CLASSE ParceiroDAO.
    $cadastro = new Cadastro();

     //CARREGA O id DO REGISTRO PRA DENTRO DO OBJETO.
    $cadastro->id_parceiro = $id_cadastro;

    //CHAMANDO O MÉTODO DELETE DA CLASSE ParceiroDAO.
    Cadastro::delete($cadastro);
  }
  /**
  * LOCALIZANDO UM REGISTRO EXISTENTE.
  */
  public function buscar(){
    //INSTÂNCIA A CLASSE ParceiroDAO.
    $cadastro = new Cadastro();

    $dados_cadastro = new Cadastro();
    //GUARDA OS DADOS DO CADASTRO QUE FOI PASSADO PELA VIEW DENTRO DO OBJETO ProdutoDAO.
    $cadastro->idparceiro = $_GET['id_pac'];

    $dados_cadastro-> $cadastro->SelectById($cadastro);

    //OBS.:ESPECIFICAR O CAMINHO QUANDO A TELA DO CMS ESTIVER PRONTA.
    //require_once("");
  }
  /**
  * LISTANDO TODOS OS REGISTROS EXISTENTES.
  */
  public function listar{
    //INSTÂNCIA A CLASSE ParceiroDAO.
    $cadastro = new Cadastro();

    //CHAMA O MÉTODO PARA SE OBTER TODOS OS REGISTROS.
    return $cadastro->select();
  }
}
?>
