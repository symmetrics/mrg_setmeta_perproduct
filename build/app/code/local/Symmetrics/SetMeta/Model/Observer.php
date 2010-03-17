<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Symmetrics
 * @package   Symmetrics_SetMeta
 * @author    Symmetrics GmbH <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @copyright 2010 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

/**
 * This model generates meta data from product name and categories
 *
 * @category  Symmetrics
 * @package   Symmetrics_SetMeta
 * @author    Symmetrics GmbH <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @copyright 2010 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
class Symmetrics_SetMeta_Model_Observer extends Varien_Object
{
    /**
     * Is called for mass editing products
     * 
     * @param Varien_Event_Observer $observer event observer object
     * 
     * @return void
     */
    public function massEdit($observer)
    {
        $productsIds = Mage::getSingleton('adminhtml/session')->getProductIds();
        $request = Mage::app()->getRequest();
        $storeId = $request->getParam('store');
        $attributesData = $request->getParam('attributes');
        if (isset($attributesData['generate_meta']) && $attributesData['generate_meta'] == 1) {
            if(!is_array($productsIds)) {
                $productsIds = array(0);
            }
        
            $products = Mage::getResourceModel('catalog/product_collection')
                ->setStoreId($storeId)
                ->addIdFilter($productsIds)
                ->load();
            foreach ($products as $product) {
                $this->generateMetaData($product->getId(), $storeId);
            }
        }
    }
    
    /**
     * product is saved - update meta tags
     * 
     * @param Varien_Event_Observer $observer event observer object
     * 
     * @return void
     */
    public function edit($observer)
    {
        $storeId = Mage::app()->getRequest()->getParam('store');
        $product = $observer->getEvent()->getProduct();
        if ($product->getGenerateMeta() == 1) {
            $this->generateMetaData($product->getId(), $storeId);
        }
    }
    
    /**
     * load product and generate meta data
     * 
     * @param int $productId Product Id
     * @param int $storeId   Store Id
     * 
     * @return void
     */
    public function generateMetaData($productId, $storeId)
    {
        $product = Mage::getModel('catalog/product')
            ->setStoreId($storeId)
            ->load($productId);
        if (!$product instanceof Mage_Catalog_Model_Product || !$product->getId()) {
            throw new Exception('product couldnt be loaded.');
        }
        $productId = $product->getId();
        
        $categories = $product->getCategoryIds();
        // load category names
        foreach ($categories as $categoryId) {
            $categoryArray[] = $this->_getCategoryName($categoryId);
        }
        $productName = $product->getName();
        // prepend product name
        array_unshift($categoryArray, $productName);
        $metaContent = implode(', ', $categoryArray);
        $product->setMetaKeyword($metaContent)
            ->setMetaTitle($productName)
            ->setMetaDescription($metaContent)
            ->setGenerateMeta(0);
        $product->save();
    }
    
    /**
     * Gets the category name by ID
     * 
     * @param string $categoryId ID of the category
     * 
     * @return string
     */
    protected function _getCategoryName($categoryId)
    {
        $storeId = Mage::app()->getRequest()->getParam('store');
        $categoryObject = Mage::getModel('catalog/category')
            ->setStoreId($storeId)
            ->load($categoryId);
        $categoryName = $categoryObject->getName();
        return $categoryName;
    }
}