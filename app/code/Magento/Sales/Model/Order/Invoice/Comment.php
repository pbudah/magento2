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
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Sales\Model\Order\Invoice;

/**
 * @method \Magento\Sales\Model\Resource\Order\Invoice\Comment _getResource()
 * @method \Magento\Sales\Model\Resource\Order\Invoice\Comment getResource()
 * @method int getParentId()
 * @method \Magento\Sales\Model\Order\Invoice\Comment setParentId(int $value)
 * @method int getIsCustomerNotified()
 * @method \Magento\Sales\Model\Order\Invoice\Comment setIsCustomerNotified(int $value)
 * @method int getIsVisibleOnFront()
 * @method \Magento\Sales\Model\Order\Invoice\Comment setIsVisibleOnFront(int $value)
 * @method string getComment()
 * @method \Magento\Sales\Model\Order\Invoice\Comment setComment(string $value)
 * @method string getCreatedAt()
 * @method \Magento\Sales\Model\Order\Invoice\Comment setCreatedAt(string $value)
 */
class Comment extends \Magento\Sales\Model\AbstractModel
{
    /**
     * Invoice instance
     *
     * @var \Magento\Sales\Model\Order\Invoice
     */
    protected $_invoice;

    /**
     * @var \Magento\Framework\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param \Magento\Framework\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\Resource\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\Db $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Magento\Framework\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\Resource\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\Db $resourceCollection = null,
        array $data = array()
    ) {
        parent::__construct($context, $registry, $localeDate, $dateTime, $resource, $resourceCollection, $data);
        $this->_storeManager = $storeManager;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magento\Sales\Model\Resource\Order\Invoice\Comment');
    }

    /**
     * Declare invoice instance
     *
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function setInvoice(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $this->_invoice = $invoice;
        return $this;
    }

    /**
     * Retrieve invoice instance
     *
     * @return \Magento\Sales\Model\Order\Invoice
     */
    public function getInvoice()
    {
        return $this->_invoice;
    }

    /**
     * Get store object
     *
     * @return \Magento\Store\Model\Store
     */
    public function getStore()
    {
        if ($this->getInvoice()) {
            return $this->getInvoice()->getStore();
        }
        return $this->_storeManager->getStore();
    }

    /**
     * Before object save
     *
     * @return $this
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();

        if (!$this->getParentId() && $this->getInvoice()) {
            $this->setParentId($this->getInvoice()->getId());
        }

        return $this;
    }
}
