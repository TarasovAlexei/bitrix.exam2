<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(

		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("PRODUCTS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		
		"PROP_CODE" => array(
			"NAME" => GetMessage("PROP_CODE"),
			"TYPE" => "STRING",
		),

		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		/*
		"CACHE_FILTER" => array(
			"NAME" => GetMessage("CACHE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_GROUPS" => array(
			"NAME" => GetMessage("CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),*/
	),
);