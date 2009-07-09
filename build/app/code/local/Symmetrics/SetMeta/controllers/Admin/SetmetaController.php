<?php
/**
 * @category Symmetrics
 * @package Symmetrics_SetMeta
 * @author symmetrics gmbh <info@symmetrics.de>, Eric Reiche <er@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Symmetrics_SetMeta_Admin_SetmetaController extends Mage_Adminhtml_Controller_Action
{
    /*
     * Calls the model which gets the categories (description) and send it as JSON
     */
    public function indexAction()
    {
        if ($this->productId = (int) $this->getRequest()->getParam('id')) {
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