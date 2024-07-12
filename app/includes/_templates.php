<?php

function getHtmlProduct(array $product): string
{
    return '<li>' . $product['article_name'] . '  vendu au prix de ' . $product['purchase_price'] . '</li>';
}
