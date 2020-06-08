<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<ul>
<?foreach ($arResult['NEWS'] as $news):?>
<? 
$this->AddEditAction($news["ID"], $news["ITEMS"]["EDIT_LINK"], CIBlock::GetArrayByID($news["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($news["ID"], $news["ITEMS"]["EDIT_LINK"], CIBlock::GetArrayByID($news["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("NEWS_DELETE_CONFIRM")));
?>
<div id="<?=$this->GetEditAreaId($news["ID"]);?>">
<li>
    <b><?=$news['NAME']?></b> - <?=$news['ACTIVE_FROM']?> (<?=implode(', ', $news['SECTIONS'])?>)
    <ul>
        <?foreach ($news['PRODUCTS'] as $product):?>
            <li>
				<?=$product['NAME']?> - <?=$product['PROPERTY_PRICE_VALUE']?> - <?=$product['PROPERTY_MATERIAL_VALUE']?> -  <?=$product['PROPERTY_ARTNUMBER_VALUE']?>
            </li>
        <?endforeach;?>
    </ul>
</li>
</div>
<?endforeach;?>
</ul>
