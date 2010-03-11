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
 * This class is overwritten to modify the javascript routine for saving a product
 * it isnt very clean written, mostly due to copy & paste from the magento core
 *
 * @category  Symmetrics
 * @package   Symmetrics_SetMeta
 * @author    Symmetrics GmbH <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @copyright 2009 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
class Symmetrics_SetMeta_Block_Catalog_Product_Edit  extends Mage_Adminhtml_Block_Catalog_Product_Edit
{
    /**
     * modify the change button to execute own javasacript function
     *
     * @return Symmetrics_SetMeta_Block_Catalog_Product_Edit
     */
    protected function _prepareLayout()
    {
        if (!$this->getRequest()->getParam('popup')) {
            $this->setChild('back_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'     => Mage::helper('catalog')->__('Back'),
                        'onclick'   => 'setLocation(\''.$this->getUrl('*/*/', array('store'=>$this->getRequest()->getParam('store', 0))).'\')',
                        'class' => 'back'
                    ))
            );
        } else {
            $this->setChild('back_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'     => Mage::helper('catalog')->__('Close Window'),
                        'onclick'   => 'window.close()',
                        'class' => 'cancel'
                    ))
            );
        }

        if (!$this->getProduct()->isReadonly()) {
            $this->setChild('reset_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'     => Mage::helper('catalog')->__('Reset'),
                        'onclick'   => 'setLocation(\''.$this->getUrl('*/*/*', array('_current'=>true)).'\')'
                    ))
            );

            $this->setChild('save_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'     => Mage::helper('catalog')->__('Save'),
                        'onclick'   => 'getCategories(\''.$this->getProduct()->getId().'\'); productForm.submit()',
                        'class' => 'save'
                    ))
            );
        }

        if (!$this->getRequest()->getParam('popup')) {
            if (!$this->getProduct()->isReadonly()) {
                $this->setChild('save_and_edit_button',
                    $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label'     => Mage::helper('catalog')->__('Save And Continue Edit'),
                            'onclick'   => 'getCategories(\''.$this->getProduct()->getId().'\'); saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
                            'class' => 'save'
                        ))
                );
            }
            if ($this->getProduct()->isDeleteable()) {
                $this->setChild('delete_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label'     => Mage::helper('catalog')->__('Delete'),
                            'onclick'   => 'confirmSetLocation(\''.Mage::helper('catalog')->__('Are you sure?').'\', \''.$this->getDeleteUrl().'\')',
                            'class'  => 'delete'
                        ))
                );
            }

            if ($this->getProduct()->isDuplicable()) {
                $this->setChild('duplicate_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'     => Mage::helper('catalog')->__('Duplicate'),
                        'onclick'   => 'setLocation(\''.$this->getDuplicateUrl().'\')',
                        'class'  => 'add'
                    ))
                );
            }
        }
        return Mage_Adminhtml_Block_Widget::_prepareLayout();
    }
}