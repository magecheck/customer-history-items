<?php

/**
 * MageCheck
 * Customer History Items Purchase History Tab
 *
 * @author Chiriac Victor
 * @since 15.03.2018
 * @category   MageCheck
 * @package    MageCheck_CustomerHistoryItems
 * @copyright  Copyright (c) 2017-2018 Mage Check (http://www.magecheck.com/)
 */

namespace MageCheck\CustomerHistoryItems\Block\Adminhtml\Edit\Tab;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Ui\Component\Layout\Tabs\TabInterface;

/**
 * Customer account form block
 */
class History extends \Magento\Backend\Block\Template implements TabInterface
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Customer Items');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Customer Items');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        if ($this->getCustomerId())
        {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden() 
    {
        if ($this->getCustomerId())
        {
            return false;
        }
        return true;
    }

    /**
     * Tab class getter
     *
     * @return string
     */
    public function getTabClass()
    {
        return '';
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl()
    {
        return $this->getUrl('history/*/history', ['_current' => true]);
    }

    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded()
    {
        return true;
    }

}
