<?
AddEventHandler('main', 'OnEpilog', array("ExamHandlers", "Check404Error"));
AddEventHandler("main", "OnBeforeEventAdd", array("ExamHandlers", "OnBeforeEventAddHandler"));

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


}

