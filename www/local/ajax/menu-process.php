<?
namespace Biga\Iiko\Models;
use Bitrix\Main\Loader;
//use Bg\Deliverypizza;
use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
   define("NO_KEEP_STATISTIC", true);
    define("NO_AGENT_CHECK", true);
    define('PUBLIC_AJAX_MODE', true);
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    $_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
    $APPLICATION->ShowIncludeStat = false;
	
	
	$id = !empty($_REQUEST['id'])?$_REQUEST['id']:null;
	$action = !empty($_REQUEST['action'])?$_REQUEST['action']:null;
	
	if($action == 'getitems'){
		
		$_iiko = new \Biga\Iiko\Models\Iiko();	
		$_iiko->getMenu();	
		$aGroups = $_iiko->getGroup($id);


		if(count($aGroups)>0){
			
			ob_start();
			include $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/biga.iiko/admin/view/exmenu/tpl/tree__root.tpl";
			$html = ob_get_contents();
			ob_end_clean();
			
			$hTree = '';
			foreach($aGroups as $v){
				$h = str_replace('#ID#',$v['id'],$html);
				$h = str_replace('#NAME#',$v['name'],$h);
				$hTree .= $h;
			}
		
		}else{
			
			$aItems = $_iiko->getItems($id);
			$hTree = '';
			if(count($aItems)>0){
				ob_start();
				include $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/biga.iiko/admin/view/exmenu/tpl/tree__elements.tpl";
				$html = ob_get_contents();
				ob_end_clean();
				
				$hTree = '';
				foreach($aItems as $v){
					$h = str_replace('#ID#',$v['id'],$html);
					$h = str_replace('#NAME#',$v['name'],$h);
					$hTree .= $h;
				}
			}
		}
/*		
        ob_start();	
        print_r($aGroups);  
        echo $hTree;  
        $debug = ob_get_contents();
        ob_end_clean();
        $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/logs/ex-getHtml.logs', 'w+');
        fwrite($fp, $debug);
        fclose($fp);
*/
	
		$arResult = array('status'=>true,'html'=>$hTree);
		
	}elseif($action == 'getdetail'){
		
		$_iiko = new \Biga\Iiko\Models\Iiko();	
		$_iiko->getMenu();
		$aDetail = $_iiko->getDetail($id);
		
		
		
		$arResult = array('status'=>true,'html'=>$hTree);
	}else{
		$arResult = array('status'=>false,'msg'=>'Нет такой команды');
	}
	
	echo json_encode($arResult);
?>