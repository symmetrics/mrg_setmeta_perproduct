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
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @author    Torsten Walluhn <tw@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

/**
 * This observer model generates meta data from product name and categories
 *
 * @category  Symmetrics
 * @package   Symmetrics_SetMeta
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @author    Yauhen Yakimovich <yy@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
class Symmetrics_SetMeta_Model_Observer extends Varien_Object
{
    /**
     * @var int $_storeId Current store id
     */
    private $_storeId = null;

    /**
     * Get store id from request
     *
     * @return string store id
     */
    protected function _getStoreId()
    {
        if ($this->_storeId == null) {
            $request = Mage::app()->getRequest();
            $this->_storeId = $request->getParam('store');
        }

        return $this->_storeId;
    }

    /**
     * Get SKU from request
     *
     * @return string SKU
     */
    protected function _getSku()
    {
        $request = Mage::app()->getRequest();
        $productParams = $request->getParam('product');
        if (isset($productParams['sku'])) {
            return $productParams['sku'];
        }

        return false;
    }

    /**
     * Update meta tags on product save
     *
     * @param Varien_Event_Observer $observer event observer object
     *
     * @return void
     */
    public function handleProductSaveAfter($observer)
    {
        // take product instance from event argument
        $product = $observer->getEvent()->getProduct();

        // assert product instance and type
        if (!$product instanceof Mage_Catalog_Model_Product || !$product->getId()) {
            throw new Exception('product not set');
        }

        // load a new product instance, using SKU from request or product id from event
        $product = $this->_getProduct($product->getId());

        // if we need to generate meta content, do so and update the product
        if ($product->getGenerateMeta() == 1) {
            $this->_updateMetaData($product);
        }
    }

    /**
     * Is called for mass editing of products
     *
     * @return void
     */
    public function handleProductMassEdit()
    {
        // take product id list from session
        $productsIds = Mage::getSingleton('adminhtml/session')->getProductIds();

        // ignore non-array values
        if (!is_array($productsIds)) {
            return;
        }

        // take $attributesData from request
        $attributesData = Mage::app()->getRequest()->getParam('attributes');

        // check if we need to generate and update meta tags
        if (!(isset($attributesData['generate_meta']) && $attributesData['generate_meta'] == 1)) {
            return;
        }

        // obtain collection of products by store id and product ids
        $products = Mage::getResourceModel('catalog/product_collection')
            ->setStoreId($this->_getStoreId())
            ->addAttributeToSelect('name')
            ->addIdFilter($productsIds)
            ->load();

        // update meta data for all of them
        foreach ($products as $product) {
            $this->_updateMetaData($product);
        }
    }

    /**
     * Get product by loading a new one. If there is an SKU specified in request,
     * then we use it, else we load product by supplied product id
     *
     * @param int $productId product id
     *
     * @return object product instance
     */
    protected function _getProduct($productId)
    {
        // have SKU in request?
        $productSku = $this->_getSku();
        if ($productSku !== false) {
            // load product by SKU and store ID from request data
            $product = $this->_loadProductBySku($productSku);
        } else {
            // otherwise just load it by supplied product id
            $product = $this->_loadProductById($productId);
        }

        return $product;
    }

    /**
     * Obtain product instance by SKU and store id
     *
     * @param string $sku SKU
     *
     * @return object product instance
     */
    protected function _loadProductBySku($sku)
    {
        $productId = Mage::getSingleton('catalog/product')
            ->getIdBySku($sku);
        $product = $this->_loadProductById($productId);

        return $product;
    }

    /**
     * Obtain product instance by product id and store id
     *
     * @param int $productId product id
     *
     * @return object product instance
     */
    protected function _loadProductById($productId)
    {
        $product = Mage::getModel('catalog/product')
            ->setStoreId($this->_getStoreId())
            ->load($productId);

        return $product;
    }

    /**
     * Load product, generate meta data and store it in the product
     *
     * @param object $product product instance
     *
     * @return void
     */
    protected function _updateMetaData($product)
    {
        $productName = $product->getName();
        $categoryArray = $this->_getCategoryNames($product);

        // compute meta content by prepending product name
        array_unshift($categoryArray, $productName);
        $metaContent = implode(', ', $categoryArray);

        $product->setStoreId($this->_getStoreId())
            ->setMetaTitle($productName)
            ->setMetaKeyword($metaContent)
            ->setMetaDescription($metaContent)
            ->setGenerateMeta(0);

        $product->save();
    }

    /**
     * Get category names of the product
     *
     * @param object $product product instance
     *
     * @return array of category names
     */
    protected function _getCategoryNames($product)
    {
        $categories = $product->getCategoryIds();

        $categoryArray = array();
        foreach ($categories as $categoryId) {
            $categoryArray[] = $this->_getCategoryName($categoryId);
        }

        return $categoryArray;
    }

    /**
     * Gets the category name by category id and store id
     *
     * @param string $categoryId category id
     *
     * @return string name
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