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
namespace Magento\Sales\Controller\Adminhtml\Order;

use Magento\Framework\App\Filesystem\DirectoryList;
use \Magento\Framework\App\ResponseInterface;
use \Magento\Backend\App\Action;

class Pdfcreditmemos extends \Magento\Sales\Controller\Adminhtml\Order
{
    /**
     * Print credit memos for selected orders
     *
     * @return ResponseInterface|void
     */
    public function execute()
    {
        $orderIds = $this->getRequest()->getPost('order_ids');
        $flag = false;
        if (!empty($orderIds)) {
            foreach ($orderIds as $orderId) {
                $creditmemos = $this->_objectManager->create(
                    'Magento\Sales\Model\Resource\Order\Creditmemo\Collection'
                )->setOrderFilter(
                    $orderId
                )->load();
                if ($creditmemos->getSize()) {
                    $flag = true;
                    if (!isset($pdf)) {
                        $pdf = $this->_objectManager->create(
                            'Magento\Sales\Model\Order\Pdf\Creditmemo'
                        )->getPdf(
                            $creditmemos
                        );
                    } else {
                        $pages = $this->_objectManager->create(
                            'Magento\Sales\Model\Order\Pdf\Creditmemo'
                        )->getPdf(
                            $creditmemos
                        );
                        $pdf->pages = array_merge($pdf->pages, $pages->pages);
                    }
                }
            }
            if ($flag) {
                return $this->_fileFactory->create(
                    'creditmemo' . $this->_objectManager->get(
                        'Magento\Framework\Stdlib\DateTime\DateTime'
                    )->date(
                        'Y-m-d_H-i-s'
                    ) . '.pdf',
                    $pdf->render(),
                    DirectoryList::VAR_DIR,
                    'application/pdf'
                );
            } else {
                $this->messageManager->addError(__('There are no printable documents related to selected orders.'));
                $this->_redirect('sales/*/');
            }
        }
        $this->_redirect('sales/*/');
    }
}
