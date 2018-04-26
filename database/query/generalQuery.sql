SELECT * FROM tbl_veiculo_parceiro;

SELECT * FROM tbl_veiculo;

SELECT * FROM tbl_imagem_veiculo_parceiro;

SELECT * FROM tbl_cor;

SELECT * FROM tbl_tipo_veiculo;

SELECT * FROM tbl_modelo_veiculo;

SELECT * FROM tbl_fabricante;

SELECT * FROM tbl_parceiro;

SELECT 

/* tbl_imagem_veiculo_parceiro */
img_vei_parc.* ,

/* tbl_veiculo_parceiro */
vei_parc.id_parceiro,

/* tbl_parceiro */
parc.nome_fantasia,
parc.razao_social

FROM tbl_imagem_veiculo_parceiro AS img_vei_parc 

/* tbl_veiculo_parceiro */
INNER JOIN tbl_veiculo_parceiro AS vei_parc
ON vei_parc.id_veiculo_parceiro = img_vei_parc.id_veiculo_parceiro

/* tbl_parceiro */
INNER JOIN tbl_parceiro AS parc
ON parc.id_parceiro = vei_parc.id_parceiro;