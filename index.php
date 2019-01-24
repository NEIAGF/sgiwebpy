<?php  
	//- Adio-- 2017/08/29 - Para que a acentuação fique padronizada como UTF-8, Formatar todos os arquivos .php com a opção Codificação em UTF-8 (sem BOM)
	require "conexaogeral.php"; 
	require 'removeacento.php';
	session_start();
    //--Adio--2017/08/08 Capturar usuario e senha vindos do Dataflex 
	$usuario = $_GET['usuario'];
	$mensagem= $_GET['mensagem'];
    $senha   = $_GET['pw'];
	$based   = $_GET['base'];
	$comando = $_GET['comando1'];
	$comando2 = $_GET['comando2'];
	$senha_escape = addslashes($senha);
	
?>	
<script language="javascript" type="text/javascript" charset="utf-8">
    
	setTimeout( 'fechar(); ',300000); //fecha a janela em 5000=5 segundos 300000=5 MINUTOS
    function fechar()
    {
       if (document.all)
	   {window.opener = window
        window.close("#")}
	   else
	   {self.close();}
	}
</script>
<?php
	
	
	//--ENCRIPTA SENHA COM MD5
    $senhamd5 = md5($senha_escape);
	
    //--se usuario e senha for diferente de branco executa a rotina abaixo
    if ($usuario != "" && $senha != "")
	{
        echo " usuario: " . $usuario . "BASE: " . $based ; 
		$usuariotmp = (removeAcentos($usuario));
        utf8_encode($usuario); //--Adio--2017/08/18 converte conteúdo da variavel para UTF8		
	    
	    //--NA WWW.LOCALWEB.COM.BR ACESSAR BANCO DE DADOS DOS USUARIOS WTS_WEB
	    //--USER:wsystems  PASSWORD: wsy11092001   ABA:produtos   	OPÇÃO:hospedagem de sites	Opção:Banco de dados
	    //--SELECIONE:o banco      OPÇÃO:ir para php admim   senha Wsy11092001 	OPÇÃO:wsystems     Usuários
		
        $usuario_escape = addslashes($usuario);
        $senha_escape   = addslashes($senha);
        $recursiveuser  = date("ymdH");
        $recursivepass  = 'H'.substr("$recursiveuser", -2).'d'.substr("$recursiveuser", 4, -2).'M'.substr("$recursiveuser", 2, -4).'a'.substr("$recursiveuser", 0, -6);
        //--faz busca no banco de dados pelo usuário e senha capturados informados
        $sql = ("SELECT * FROM usuarios WHERE usuario='$usuario_escape' and senha=('$senhamd5')");
        $res = $MySQLi->query($sql);
        $total = $res->num_rows;
        //--se encontrou um usuário inicia
        if ($total > 0)
		{
            //--Cria variáveis de sessão
            $_SESSION['autenticado']       = 1;
			
            $d = mysqli_fetch_array($res) ;
            //--grava os dados do vetor $d na sessão
            $_SESSION['id_usuario']       = $d['id_usuario'];
            $_SESSION['tempo']             = time()+60;             //--recebe tempo em segundos				
            $_SESSION['nome_usuario']      = $d['nome'];   //--AQUI TEM QUE COLOCAR O CAMPO DO ARQUIVO PARA QUE ELE ACESSE CORRETAMENTE A OUTRA PAGINA
            $_SESSION['usuario']           = $d['usuario'];
			$_SESSION['categoria_usuario'] = $d['categoria_usuario']; //--AQUI TEM QUE COLOCAR O CAMPO CATEGORIA_USUARIO (direitos) DO ARQUIVO PARA QUE ELE FAÇA O ACESSO CORRETO de acordo com o seu direito 							
			$_SESSION['basededados']       = $d['basededados'];   //--este campo contem o nome do banco de dados que tem direito a acessar
			$_SESSION['email']             = $d['email']; //--email do usuario para pesquisar no cliente (sga002) 
			$_SESSION['codigo']            = $d['codigo']; //-- codigo do cliente sga002
			
			//-- se foi informado a base de dados a acessar   01/11/2017
			
			if ($based <> "") 
			{
				$bancodedados2 = ('wsyst490_'. trim($based));
				echo "banco de dados: " . $bancodedados2 ;
				sleep(5);
				// conexão e seleção do banco de dados usando PDO
				//define( 'HOST', 'localhost' );
                //define( 'USER', 'wsyst490_wsystem' );
                //define( 'PASSWORD', 'Wsy11092001' );
                //define( 'DBNAME', $bancodedados2 );
                //$PDO = new PDO( 'mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD );
				
				
				$servidor2 = 'localhost';
                $usuario2 = 'wsyst490_wsystem';
                $senha2 = 'Wsy11092001';
				
				// conexão e seleção do banco de dados usando Mysqli
                $conn = new mysqli($servidor2, $usuario2, $senha2, $bancodedados2);
				if ($conn->connect_error) 
				{
                    die("Connection failed: " . $conn->connect_error);
                } 
				    $sql3 = (TRIM($comando)) ;
					$sql4 = (TRIM($comando2)) ;
						   
					
				    if ($conn->query($sql3) === TRUE) 
				    {
                        echo " UPDATE: " . $sql3 ;
						echo "Registro Atualizado com sucesso!";
                    } ELSE
					{	
					    echo "Erro Atualizando registro: " . $conn->error;
					}
                    if ($conn->query($sql4) === TRUE) //--se houve erro executa a segunda instrução sql (insert)
				    {				
					    echo " INSERT: " . $sql4 ;
					    echo "Registro inserido com sucesso!";
					}
			    fechar();
				exit;
			}
			
		}
        else
		{
            session_destroy();
            $error  = "Usuário e Senha inválidos";
		}			
	}		//--FIM ROTINA SE VEIO DO VDF
	else 
	{	//--verifica se a requisição de entrada veio do botão de submit que passa o valor "Entrar"
        If ($_POST['entra']=="Entrar")
		{
            $usuario = $_POST['usuario'];
            $senha   = $_POST['senha'];
            $usuario_escape = addslashes($usuario);
            $senha_escape   = addslashes($senha);
			$_SESSION['email'] = $d['email']; //--email do usuario para pesquisar no cliente (sga002) 
			
			//--ENCRIPTA SENHA COM MD5 para pesquisar o banco de dados corretamente
            $senhamd5 = md5($senha_escape);
            $recursiveuser  = date("ymdH");
            $recursivepass  = 'H'.substr("$recursiveuser", -2).'d'.substr("$recursiveuser", 4, -2).'M'.substr("$recursiveuser", 2, -4).'a'.substr("$recursiveuser", 0, -6);
			
            //--faz busca no banco de dados pelo usuário e senha capturados informados
			$sql = ("SELECT * FROM usuarios WHERE usuario='$usuario_escape' and senha=('$senhamd5')");
			$res = $MySQLi->query($sql);
			$total = $res->num_rows;
			//--se encontrou um usuário inicia
			if ($total > 0)
			{	
		        //--Cria variáveis de sessão
				$_SESSION['autenticado']       = 1;
			
				$d = mysqli_fetch_array($res) ;
				//--grava os dados do vetor $d na sessão
				$_SESSION['id_usuario']       = $d['id_usuario'];
				$_SESSION['tempo']             = time()+60;             //--recebe tempo em segundos				
				$_SESSION['nome_usuario']      = $d['nome'];   //--AQUI TEM QUE COLOCAR O CAMPO DO ARQUIVO PARA QUE ELE ACESSE CORRETAMENTE A OUTRA PAGINA
				$_SESSION['usuario']           = $d['usuario'];
				$_SESSION['categoria_usuario'] = $d['categoria_usuario']; //--AQUI TEM QUE COLOCAR O CAMPO CATEGORIA_USUARIO (direitos) DO ARQUIVO PARA QUE ELE FAÇA O ACESSO CORRETO de acordo com o seu direito 							
				$_SESSION['basededados']       = $d['basededados'];   //--este campo contem o nome do banco de dados que tem direito a acessar
				$_SESSION['email']             = $d['email']; //--email do usuario para pesquisar no cliente (sga002) 
				$_SESSION['codigo']            = $d['codigo']; //-- codigo do cliente sga002
				$agora = date("Y-m-d H:i:s");

				//--faz update no usuario indicando que ele está logado        							  		              //--poderia ser usado o $_SERVER['HTTP_X_FORWARDED_FOR'] também.
                $update = ("UPDATE usuarios SET status_logado_usuario = '1', data_hora_inicio_login_usuario = '$agora', ip_usuario = '$_SERVER[REMOTE_ADDR]' WHERE usuarios.id_usuario = '$d[id_usuario]'");
                if ($MySQLi->query($update) === TRUE) 
				{
                    echo "Record updated successfully";
			    } 
				else 
				{
                    echo "Error updating record: " . $conn->error;
                }
		    }
			else
			{
                $error  = "Usuário e Senha inválidos";
			}

			    
			?>
				<script type="text/javascript" charset="utf-8">
                    location.href="selecionaunidade.php";
                </script>
            <?php
            exit;
			
		}
        else if ($_POST['cadastrar']=="Cadastrar")
		{
            $usuario        = $_POST['usuario'];
            $senha          = $_POST['senha'];
            $usuario_escape = addslashes($usuario);
            $senha_escape   = addslashes($senha);
			
            ?>
                <script type="text/javascript" charset="utf-8">
                    location.href="../login/usuariocadastro.php";
                </script>
            <?php 
            exit;
			
        }	
		  
    }
		
	//$conn->close(); 
	$MySQLi->close();
?>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="language" content="pt-br" />
		<link href="css/login_style.css" rel="stylesheet" type="text/css" />
		<script language="JavaScript" type="text/javascript" src="js/valida_login.js" charset="utf-8"></script>
		<style>
    </style>
	</head>
	<body onLoad="document.login.usuario.focus();">
        <form name="login" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div id="login-box">
			<html><href:https://trello.com/b/SG0jUlhk/sgi-web-wts</html>
					<div id="safety">
						<img src="imagens/security.png" class="cadeado">
					</div>
					<div id="login-box-field">    
						<input type="text" class="form-login" name="usuario" value="<?php echo $usuario; ?>" id="usuario" maxlength="60" onKeyUp="this.value=this.value.toUpperCase()" onkeyPress="if(this.value.length==40) this.form.senha.focus()"/>
					</div>
					<br/>
					<div id="login-box-field">
						<input type="password" class="form-login" name="senha" value="<?php echo $senha; ?>" id="senha" maxlength="10"/>
					</div>
					<div id="submit">
						<!--<input type="image" name="entra" value="Entrar" src="images/botao1.png" width="120" height="60" style="margin-left:130px;" onmouseover="trocar(this)" onmouseout="voltar(this)" onclick="return valida(this);">-->
						<input type="submit" name="entra" value="Entrar" class="entrar" onClick="return valida(this);">
					</div>
					<div id="submit">
						<input type="submit" name="cadastrar" value="Cadastrar" class="cadastrar" ;">
						</div>
			</div>
            <?php
                if($error != "")
				{
                    echo"
                        <table width=100% class='erro_acesso'>
                            <tr>
                                <td align='center'><font color='#FF0000' size='4'>Usuário e ou Senha Inválidos !!!<br/>Tente novamente.</font></td>
                            </tr>
                        </table>
                        ";
                    $error = "";
					
                }
            ?>
        </form>
    </body>
</html>