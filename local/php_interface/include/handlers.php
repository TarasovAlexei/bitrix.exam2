<?
AddEventHandler('main', 'OnEpilog', array("ExamHandlers", "Check404Error"));
AddEventHandler("main", "OnBeforeEventAdd", array("ExamHandlers", "OnBeforeEventAddHandler"));
AddEventHandler("main", "OnBuildGlobalMenu", array("ExamHandlers", "OnBuildGlobalMenuHandler"));


class ExamHandlers
{   
    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields){
        if($event == 'FEEDBACK_FORM'){
            global $USER;
            if($USER->isAuthorized()){
                $arFields['AUTHOR'] = 'Пользователь авторизован: ' . $arUser['ID'] . ' ('. $arUser['LOGIN'] .') '
                . $arUser['NAME'] . ', данные из формы: ' . $arFields["AUTHOR"];
            }
            else{
                $arFields['AUTHOR'] = 'Пользователь не авторизован, данные из формы: ' . $arFields["AUTHOR"];
            }

            CEventLog::Add(array(
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "MY_TYPE_LOG",
            "MODULE_ID" => "main",
            "ITEM_ID" => $arFields['ID'],
            "DESCRIPTION" => "Замена данных в отсылаемом письме – " . $arFields['AUTHOR'],
            );
        }
    }

    // ex2-94
	function Check404Error(){
		if (defined('ERROR_404') && ERROR_404 == 'Y') {

		CEventLog::Add(
			array(
				"SEVERITY" 		=> "INFO",
				"AUDIT_TYPE_ID" => "ERROR_404",
				"MODULE_ID" 	=> "main",
				"DESCRIPTION" 	=> $APPLICATION->GetCurPage(),
			)
		);
		}
	}

    // ex2-95
    function OnBuildGlobalMenuHandler(&$aGlobalMenu, &$aModuleMenu){
        global $USER;
        $userGroups = \CUser::GetUserGroupList($USER->GetId());
        $contentGroupID = \CGroup::GetList (
            $by = "c_sort",
            $order = "asc",
            array("STRING_ID" => 'content_editor'))->Fetch()['ID'];
        while ($group = $userGroups->Fetch()) {
            if ($group['GROUP_ID'] == 1) {
                $isAdmin = true;
            };
            if ($group['GROUP_ID'] == $contentGroupID) {
                $isManager = true;
            }
        }
        if ($isAdmin != true && $isManager == true) {
            foreach ($aModuleMenu as $key => $item) {
                if ($item['items_id'] == 'menu_iblock_/news') {
                    $aModuleMenu = [$item];
                    foreach ($item['items'] as $childItem) {
                        if ($childItem['items_id'] == 'menu_iblock_/news/1') {
                            $aModuleMenu[0]['items'] = [$childItem];
                            break;
                        }
                    }
                    break;
                }
            }
            $aGlobalMenu = ['global_menu_content' => $aGlobalMenu['global_menu_content']];
        }
    }


}

