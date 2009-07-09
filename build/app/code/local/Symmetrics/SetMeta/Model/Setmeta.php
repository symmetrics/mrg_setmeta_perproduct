<?php
/**
 * @category Symmetrics
 * @package Symmetrics_SetMeta
 * @author symmetrics gmbh <info@symmetrics.de>, Eric Reiche <er@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/*
 * This model returns the categories (description) of a specific product.
 */
class Symmetrics_SetMeta_Model_SetMeta extends Varien_Object
{
    /*
     * Contains the product model object
     */
    protected $_product;
    
    /*
     * returns the categories of the product
     * @var array
     */
    public function getCategories($productId)
    {
        $this->_product = Mage::getModel('catalog/product')
            ->setStoreId(
                Mage::app()
                    ->getStore()
                    ->getId()
            )
            ->load($productId);
        $categories = $this->_product->getCategory_ids();
        $categories = explode(',',$categories);
        foreach($categories as $categoryId) {
            $categoryArray[] = $this->_getCategoryName($categoryId);
        }        
        return ($categoryArray);
    }
    
    /*
     * Gets the category name by ID
     */
    protected function _getCategoryName($categoryId)
    {
        $categoryObject = Mage::getModel('catalog/category')
            ->setStoreId(
                Mage::app()
                    ->getStore()
                    ->getId()
            )
            ->load($categoryId);
        $categoryName = $categoryObject->getName();
        return $categoryName;
    }
}