<?
AddEventHandler('main', 'OnEpilog', array("ExamHandlers", "Check404Error"));


class ExamHandlers
{

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

