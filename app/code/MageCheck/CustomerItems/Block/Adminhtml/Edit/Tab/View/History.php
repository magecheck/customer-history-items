<?php

/**
 * MageCheck
 * Customer Items Purchase History Tab
 *
 * @author Chiriac Victor
 * @since 15.03.2018
 * @category   MageCheck
 * @package    MageCheck_CustomerItems
 * @copyright  Copyright (c) 2017 Mage Check (http://www.magecheck.com/)
 */

namespace MageCheck\CustomerItems\Block\Adminhtml\Edit\Tab\View;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Framework\App\ResourceConnection;

/**
 * Adminhtml customer recent orders grid block
 */
class History extends \Magento\Backend\Block\Widget\Grid\Extended {

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $resource;

    //protected $_template='MageCheck_CustomerItems::grid.phtml';

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Sales\Model\Resource\Order\Grid\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Backend\Helper\Data $backendHelper, \Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory $collectionFactory, \Magento\Framework\Registry $coreRegistry, ResourceConnection $resource, array $data = []
    ) {

        $this->_coreRegistry = $coreRegistry;
        $this->_collectionFactory = $collectionFactory;
        $this->resource = $resource;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No items found'));
        $this->setTemplate("MageCheck_CustomerItems::grid.phtml");
        $this->setUseAjax(true);
    }

    /**
     * Initialize the orders grid.
     *
     * @return void
     */
    protected function _construct() {
        parent::_construct();
        $this->setDefaultSort('created_at', 'desc');
        $this->setSortable(true);
        $this->setPagerVisibility(true);
        $this->setFilterVisibility(true);
        $this->setEmptyText(true);
    }

    protected function _prepareGrid() {
        $this->setId('customeritems_view_compared_grid' . $this->getWebsiteId());
        parent::_prepareGrid();
    }

    /**
     * {@inheritdoc}
     */
    protected function _preparePage() {
        $this->getCollection()->setPageSize(5)->setCurPage(1);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareCollection() {
        $collection = $this->_collectionFactory->create();
        $collection->getSelect()
                ->join(array('orders' => $this->resource->getTableName('sales_order')), 'orders.entity_id = main_table.order_id', array('orders.customer_id as customer_id'));
        $collection->addFieldToFilter('customer_id', $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID));

        if ($this->getRequest()->getParam('from') && $this->getRequest()->getParam('to')) {
            $collection->getSelect()->where("main_table.created_at > '{$this->getRequest()->getParam('from')}' AND main_table.created_at < '{$this->getRequest()->getParam('to')}'");
        }

        $collection->getSelect()
                         ->columns('sku')
                         ->columns('name')
                         ->columns('SUM(main_table.qty_ordered) as qty_ordered')
                         ->columns('SUM(main_table.row_total_incl_tax) as total')
                         ->columns('COUNT(DISTINCT(orders.entity_id)) AS order_cnt')
                         ->group('main_table.item_id');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareColumns() {
        $this->addColumn('sku', ['header' => __('SKU'),'index' => 'sku','type' => 'string','width' => '100px']);
        $this->addColumn('name', ['header' => __('Name'),'index' => 'name']);
        $this->addColumn('order_cnt', ['header' => __('Number Of Orders'),'index' => 'order_cnt']);
        $this->addColumn('qty_ordered', ['header' => __('Qty Ordered'),'index' => 'qty_ordered']);
        $this->addColumn('total', ['header' => __('Total'),'index' => 'total']);

        return parent::_prepareColumns();
    }

    /**
     * Get headers visibility
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getHeadersVisibility() {
        return $this->getCollection()->getSize() >= 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getRowUrl($row) {
        return $this->getUrl('catalog/product/edit', ['id' => $row->getProductId()]);
    }

    /**
     * Return the Form with from and to filters
     * @return type
     */
    public function getCustomForm() {
        return $this->getLayout()->createBlock('MageCheck\CustomerItems\Block\Adminhtml\Edit\Tab\CustomForm')->toHtml();
    }

}