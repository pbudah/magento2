<?php
/**
 *
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
namespace Magento\Persistent\Model\Observer;

class RemovePersistentCookie
{
    /**
     * Customer session
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * Persistent session
     *
     * @var \Magento\Persistent\Helper\Session
     */
    protected $_persistentSession = null;

    /**
     * Persistent data
     *
     * @var \Magento\Persistent\Helper\Data
     */
    protected $_persistentData = null;

    /**
     * @var \Magento\Persistent\Model\QuoteManager
     */
    protected $quoteManager;

    /**
     * @param \Magento\Persistent\Helper\Session $persistentSession
     * @param \Magento\Persistent\Helper\Data $persistentData
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Persistent\Model\QuoteManager $quoteManager
     */
    public function __construct(
        \Magento\Persistent\Helper\Session $persistentSession,
        \Magento\Persistent\Helper\Data $persistentData,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Persistent\Model\QuoteManager $quoteManager
    ) {
        $this->quoteManager = $quoteManager;
        $this->_persistentSession = $persistentSession;
        $this->_persistentData = $persistentData;
        $this->_customerSession = $customerSession;
    }

    /**
     * Unset persistent cookie and make customer's quote as a guest
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute($observer)
    {
        if (!$this->_persistentData->canProcess($observer) || !$this->_persistentSession->isPersistent()) {
            return;
        }

        $this->_persistentSession->getSession()->removePersistentCookie();

        if (!$this->_customerSession->isLoggedIn()) {
            $this->_customerSession->setCustomerId(null)->setCustomerGroupId(null);
        }

        $this->quoteManager->setGuest();
    }
}
