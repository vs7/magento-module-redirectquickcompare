<?php

class VS7_RedirectQuickCompare_Model_Observer
{
    public function redirectFromQuick($observer)
    {
        $headers = $observer->getEvent()->getControllerAction()->getResponse()->getHeaders();
        if (!empty($headers)) {
            foreach ($headers as $header) {
                if ($header['name'] == 'Location') {
                    $redirectUrl = $header['value'];
                    break;
                }
            }
            $quickViewPath = 'catalog_category/viewQuick';
            if (strpos($redirectUrl, $quickViewPath) !== false) {
                $productId = $observer->getEvent()->getControllerAction()->getRequest()->getParam('product');
                $product = Mage::getModel('catalog/product')->load($productId);
                $url = $product->getProductUrl();
                $response = Mage::app()->getFrontController()->getResponse();
                $response->setRedirect($url);
            }
        }
    }
}
