<?php
include 'db.php';
/**
    * Função para fazer upload de arquivos
    * @author Rafael Wendel Pinheiro
    * @param File $arquivo Arquivo a ser salvo no servidor
    * @param String $pasta Local onde o arquivo será salvo
    * @param Array $tipos Extensões permitidas para o arquivo
    * @param String $nome Nome do arquivo. Null para manter o nome original
    * @return array
*/
function uploadFile($arquivo, $pasta,$nome, $tipos){
    if(isset($arquivo)){
        $infos = explode(".", $arquivo["name"]);

        $tipoArquivo = $infos[count($infos) - 1];
        $tipoPermitido = false;
        foreach($tipos as $tipo){
            if(strtolower($tipoArquivo) == strtolower($tipo)){
                $tipoPermitido = true;
            }
        }
        if(!$tipoPermitido){
            $retorno["erro"] = "Tipo não permitido";
		}else{
            if(move_uploaded_file($arquivo['tmp_name'], $pasta .'/'. $nome)){
                $retorno["caminho"] = $pasta .'/'. $nome;
				chmod ($pasta .'/'. $nome, 0755);
				//chown($pasta .'/'. $nome, 'nobody');
				
            }
            else{
                $retorno["erro"] = "Erro ao fazer upload";
            }
        }
    }
    else{
        $retorno["erro"] = "Arquivo nao setado";
    }
    return $retorno;
}