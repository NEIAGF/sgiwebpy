// Set flag that this is a parent file.
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
$path = "/www.wsystems.com.br/public_html/";  //caminho da instalação do Joomla
define('JPATH_BASE', $path);
require_once JPATH_BASE . DS . 'includes' . DS . 'defines.php';
require_once JPATH_BASE . DS . 'includes' . DS . 'framework.php';

$app = JFactory::getApplication('site');
$app->initialise();
$session = JFactory::getSession();
$session_id = $session->get('user_id', 'empty');
var_dump($session_id);


//$mainframe =& JFactory::getApplication('site');
//$db = &JFactory::getDBO();
//$mainframe->initialise();
//$user =& JFactory::getUser( );

//echo $user->id;  //imprime id do usuário

//echo $user->name; //imprime nome do usuário







