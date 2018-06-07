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

namespace MageCheck\CustomerHistoryItems\Controller\Adminhtml\Index;

class History extends \Magento\Customer\Controller\Adminhtml\Index
{

    protected $_template = 'MageCheck_CustomerHistoryItems::grid.phtml';
    
    /**
     * Customer compare grid
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->initCurrentCustomer();
        return $this->resultLayoutFactory->create();
    }

}
