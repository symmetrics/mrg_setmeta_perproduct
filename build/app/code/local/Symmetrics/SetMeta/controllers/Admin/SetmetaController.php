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
 * response with JSON data to the ajax request,
 * which requests the category data for a product
 *
 * @category  Symmetrics
 * @package   Symmetrics_SetMeta
 * @author    Symmetrics GmbH <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @copyright 2009 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

class Symmetrics_SetMeta_Admin_SetmetaController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * Calls the model which gets the categories (description) and send it as JSON
     *
     * @return void
     */
    public function indexAction()
    {
        if ($this->productId = (int)$this->getRequest()->getParam('id')) {
            $categories = Mage::getModel('setmeta/setmeta')
                ->getCategories($this->productId);
            $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Content-type', 'text/x-json', true)
                ->setHeader('Last-Modified', date('r'))
                ->setBody(Zend_Json::encode($categories));
        }
    }
}