<?php
session_start();
require_once("../../database/conect.php");
Conexao_db();
$id_usuario = $_SESSION['id_usuario'];
// if da escolha , visualizar ou excluir
if(isset($_GET['escolha'])){
    $escolha = $_GET['escolha'];
    $id = $_GET['id'];

    //if da escolha excluir
    if($escolha == 'excluir'){
        $sql = "DELETE FROM tbl_veiculo WHERE id_veiculo= ".$id;
        mysql_query($sql);
        // echo ($sql);
        header('location:consultar_veiculo_parceiro.php');
      }else if($escolha == 'editar'){
          $sql="select * from tbl_veiculo where id_veiculo=".$id;

          $select = mysql_query($sql);
          $rsVP = mysql_fetch_array($select);

          $_SESSION['ano_fabricacao'] = $rsVP['ano_fabricacao'];
          $_SESSION['id_modelo_veiculo'] = $rsVP['id_modelo_veiculo'];
          $_SESSION['id_modelo'] = $rsVP['id_modelo'];
          $_SESSION['placa'] = $rsVP['placa'];
          $_SESSION['cor'] = $rsVP['id_cor'];
          $_SESSION['quilometragem'] = $rsVP['quilometro_rodado'];
          $_SESSION['tipoVeiculo'] = $rsVP['id_tipo_veiculo'];
          $_SESSION['qtdPortas'] = $rsVP['qtd_porta'];
          $_SESSION['id_veiculo'] = $rsVP['id_veiculo'];
          $_SESSION['botao'] = "Editar";


          if($_SESSION['ano_fabricacao'] !=null){
              header('location:editar_veiculo_parceiro.php');
              //echo($_SESSION['idNivelUsuario']);
          }else{
              echo("Deu ruim!!!");
          }
        }
      }


 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/parceiro/cms_agenda_parceiro.css">
    <link rel="stylesheet" href="../css/parceiro/consultar_veiculo_parceiro.css">
    <link rel="stylesheet" href="../css/padroes.css">
  </head>
  <body>
    <div class="container_conteudo_central_apc">
      <!-- MENU LATERAL -->
      <div class="container_menu_l_apc float_left borda_preta_1 margem_l_20">
        <div class="container_img_menu_apc centro_lr borda_preta_1 margem_t_20">
          <div class="item_img_menu_l_apc ">

          </div>
        </div>
        <!-- NOME USUÁRIO -->
        <div class="container_nome_usuario_apc margem_t_10">
          <div class="item_nome_usuario_apc centro_lr align_center preenche_t_15 fs_18 negrito txt_branco">
            Nome de Usuário
          </div>
        </div>
      </div>
        <!-- conteudo -->
      <form name="frmParceiro" method="get" action="consultar_veiculo_parceiro.php">
        <div class="container_geral">
          <div class="container_titulo">
            <div class="item_titulo fs_30">
              <h2>Gerenciamento de Veículos</h2>
            </div>
          </div>
          <div class="divisor_vc">

          </div>
          <div class="container_ok margem_t_30">
            <div class="item_dados align_center conteudo fs_18">
              Ano de Frabricação
            </div>
            <div class="item_dados align_center conteudo fs_18">
              Placa
            </div>
            <div class="item_dados align_center conteudo fs_18">
              Quilometragem
            </div>
            <div class="item_dados">
              <div class="excluir align_center ">
                <i class="material-icons" style="font-size:30px;">delete_forever</i>
              </div>
              <div class="editar align_center">
                <i class="material-icons" style="font-size:30px;">remove_red_eye</i>
              </div>
            </div>
          </div>
          <div class="divisor_vc">

          </div>
          <div class="container_itens">
          <?php
          $sql = "SELECT * FROM tbl_veiculo AS v

                INNER JOIN tbl_veiculo_parceiro AS vp ON vp.id_veiculo = v.id_veiculo

                INNER JOIN tbl_parceiro AS p ON p.id_parceiro = vp.id_parceiro

                INNER JOIN tbl_usuario AS u ON u.id_usuario = p.id_usuario

                WHERE u.id_usuario =".$id_usuario;
                $select = mysql_query($sql);
            while ($rsVP = mysql_fetch_array($select))
            {
           ?>
            <div class="container_sla">
              <div class="item_visu align_center preenche_t_15">
                <?php echo($rsVP['ano_fabricacao']) ?>
              </div>
              <div class="item_visu align_center preenche_t_15">
                <?php echo($rsVP['placa']) ?>
              </div>
              <div class="item_visu align_center preenche_t_15">
                <?php echo($rsVP['quilometro_rodado']) ?>
              </div>
              <div class="item_visu">
                <div class="excluir_visu preenche_t_10 align_center">
                  <a href="consultar_veiculo_parceiro.php?escolha=excluir&id=<?php echo($rsVP['id_veiculo']);?>">
                    <i class="material-icons" style="font-size:30px;">delete_forever</i>
                  </a>
                </div>
                <div class="editar_visu preenche_t_10 align_center">
                  <a href="consultar_veiculo_parceiro.php?escolha=editar&id=<?php echo($rsVP['id_veiculo']);?>">
                    <i class="material-icons" style="font-size:30px;">remove_red_eye</i>
                  </a>
                </div>
              </div>
            </div>

          <?php
           }
           ?>
          </div>
          <div class="bt_retornar">
            <a href="cms_adm_parceiro.php" style="text-decoration:none">
              <img class="img_retorno" src="../pictures/adm_parceiro/retornar.png" width"20" alt="">
            </a>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
