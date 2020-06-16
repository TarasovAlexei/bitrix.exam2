<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(

		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("PRODUCTS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		
		"ALTER_IBLOCK_ID" => array(
			"NAME" => GetMessage("ALTER_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		
		"CODE_ALTER" => array(
			"NAME" => GetMessage("CODE_ALTER"),
			"TYPE" => "STRING",
		),

		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),

	),
);