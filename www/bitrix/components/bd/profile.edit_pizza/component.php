<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
Loader::includeModule('bd.deliverypizza');
use Bd\Deliverypizza;
global $USER;
if(isset($_POST['USER'])){
	$id_ = $_POST['USER']['ID'];
	$fields = $_POST['USER'];
	$fields['PHONE'] = preg_replace('/\D/', '', $fields['PHONE']);
	unset($fields['USER']['ID']);
	Deliverypizza\Entity\UserTable::update($id_,$fields);
	if($_POST['ADDRESS']){
		foreach($_POST['ADDRESS'] as $key => $addr){
			if($addr['TO_DELETE']==1){
				Deliverypizza\Entity\AddressTable::delete($key);
			}else{
				unset($addr['TO_DELETE']);
				if (!isset($addr['IS_PRIVATE']))
					$addr['IS_PRIVATE'] = 'N';
				Deliverypizza\Entity\AddressTable::update($key,$addr);
			}
		}
	}
	if($_POST['NEW_ADDRESS']){

		foreach($_POST['NEW_ADDRESS']['NAME'] as $key => $addr){

			if (!empty($_POST['NEW_ADDRESS']['NAME'][$key]) && $_POST['NEW_ADDRESS']['TO_DELETE'][$key] == 0) {
				$fields = array();
				$fields['USER_ID'] = $USER->GetID();
				$fields['SITE_ID'] = SITE_ID;
				$fields['NAME'] = $_POST['NEW_ADDRESS']['NAME'][$key];
				if(isset($_POST['NEW_ADDRESS']['DISTRICT_ID']))
					$fields['DISTRICT_ID'] = $_POST['NEW_ADDRESS']['DISTRICT_ID'][$key];
				$fields['STREET'] = $_POST['NEW_ADDRESS']['STREET'][$key];
				$fields['HOUSE'] = $_POST['NEW_ADDRESS']['HOUSE'][$key];
				$fields['APARTMENT'] = $_POST['NEW_ADDRESS']['APARTMENT'][$key];
				if (!isset($_POST['NEW_ADDRESS']['IS_PRIVATE'][$key])) {
					$fields['IS_PRIVATE'] = 'N';
				} else {
					$fields['IS_PRIVATE'] = 'Y';
				}
				Deliverypizza\Entity\AddressTable::add($fields);
			}
		}
	}
	
}
$user = Deliverypizza\Entity\UserTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID())))->fetch();
$address = Deliverypizza\Entity\AddressTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID())))->fetchAll();
$arResult['USER'] = $user;
$arResult['USER']['ADDRESSES'] = $address;

$arSelect = Array("ID", "NAME", "PROPERTY_DELIVERY_COST", "PROPERTY_FREE_DELIVERY");
$arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID_DESTRICT"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, Array("nPageSize" => 100), $arSelect);
while ($ob = $res->GetNext()) {
	$arResult["DESTRICT"][] = array(
		"ID" => $ob['ID'],
		"NAME" => $ob['NAME'],
		"DELIVERY_PRICE" => $ob['PROPERTY_DELIVERY_COST_VALUE'],
		"FREE_DELIVERY" => $ob['PROPERTY_FREE_DELIVERY_VALUE']
	);
}

$this->IncludeComponentTemplate();