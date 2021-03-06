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

namespace Magento\Backend\Test\Constraint;

use Magento\Backend\Test\Fixture\GlobalSearch;
use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertGlobalSearchCustomerName
 * Assert that customer name is present in search results
 */
class AssertGlobalSearchCustomerName extends AbstractConstraint
{
    /**
     * Constraint severeness
     *
     * @var string
     */
    protected $severeness = 'low';

    /**
     * Assert that customer name is present in search results
     *
     * @param Dashboard $dashboard
     * @param GlobalSearch $search
     * @return void
     */
    public function processAssert(Dashboard $dashboard, GlobalSearch $search)
    {
        $customer = $search->getDataFieldConfig('query')['source']->getEntity();
        $customerName = $customer->getFirstname() . " " . $customer->getLastname();
        $isVisibleInResult = $dashboard->getAdminPanelHeader()->isSearchResultVisible($customerName);
        \PHPUnit_Framework_Assert::assertTrue(
            $isVisibleInResult,
            'Customer name ' . $customerName . ' is absent in search results'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Customer name is present in search results';
    }
}
