<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Upload Múltiplo de arquivos</title>
    </head>
    <body>
        <h1>Upload Múltiplo de Arquivos com PHP</h1>
         
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="arquivos[]" multiple>
            <br>
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>
<?php
// diretório de destino do arquivo
define('DEST_DIR', __DIR__ . '/arquivos');
 
if (isset($_FILES['arquivos']) && !empty($_FILES['arquivos']['name']))
{
    // se o "name" estiver vazio, é porque nenhum arquivo foi enviado
     
    // cria uma variável para facilitar
    $arquivos = $_FILES['arquivos'];
 
    // total de arquivos enviados
    $total = count($arquivos['name']);
 
    for ($i = 0; $i < $total; $i++)
    {
        // podemos acessar os dados de cada arquivo desta forma:
        // - $arquivos['name'][$i]
        // - $arquivos['tmp_name'][$i]
        // - $arquivos['size'][$i]
        // - $arquivos['error'][$i]
        // - $arquivos['type'][$i]
         
        if (!move_uploaded_file($arquivos['tmp_name'][$i], DEST_DIR . '/' . $arquivos['name'][$i]))
        {
            echo "Erro ao enviar o arquivo: " . $arquivos['name'][$i];
        }
    }
 
    echo "Arquivos enviados com sucesso";
	sleep(3) ;
	echo "                             ";
	
}