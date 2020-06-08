<?php 
foreach($arResult['NEWS'] as $vol){
        foreach($vol['PRODUCTS'] as $product){
        	$str[] = $product['PROPERTY_PRICE_VALUE'];
	}
}
$arResult['MIN_PRICE'] = min($str);
$arResult['MAX_PRICE'] = max($str);
$this->__component->SetResultCacheKeys(['MIN_PRICE', 'MAX_PRICE']);
