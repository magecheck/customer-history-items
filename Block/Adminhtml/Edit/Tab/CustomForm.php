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

class CustomForm extends \Magento\Framework\View\Element\Template {

    const template = "MageCheck_CustomerHistoryItems::form.phtml";

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, array $data = []
    ) {
        parent::__construct($context, $data);
        $this->setTemplate(self::template);
    }

    /**
     * Get form action URL for POST booking request
     *
     * @return string
     */
    public function getFormAction() {
        return false;
    }

}
