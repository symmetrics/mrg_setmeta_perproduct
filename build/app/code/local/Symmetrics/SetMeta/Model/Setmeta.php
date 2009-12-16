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
 * @copyright 2009 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
/**
 * This model returns the categories (description) of a specific product.
 *
 * @category  Symmetrics
 * @package   Symmetrics_SetMeta
 * @author    Symmetrics GmbH <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @copyright 2009 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
class Symmetrics_SetMeta_Model_SetMeta extends Varien_Object
{
    /**
     * Contains the product model object
     *
     * @var Mage_Catalog_Model_Product
     */
    protected $_product;
    
    /**
     * returns the categories of the product
     *
     * @param int $productId ID of the product
     *                       for which the categories shall be loaded
     *
     * @return array
     */
    public function getCategories($productId)
    {
        $storeId = Mage::app()->getStore()->getId();
        $this->_product = Mage::getModel('catalog/product')
            ->setStoreId($storeId)
            ->load($productId);
        $categories = $this->_product->getCategory_ids();
        $categories = explode(',', $categories);
        foreach ($categories as $categoryId) {
            $categoryArray[] = $this->_getCategoryName($categoryId);
        }        
        return $categoryArray;
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
        $storeId = Mage::app()->getStore()->getId();
        $categoryObject = Mage::getModel('catalog/category')
            ->setStoreId($storeId)
            ->load($categoryId);
        $categoryName = $categoryObject->getName();
        return $categoryName;
    }
}