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

namespace Magento\Sitemap\Test\Constraint;

use Mtf\Constraint\AbstractConstraint;
use Magento\Sitemap\Test\Page\Adminhtml\SitemapIndex;
use Magento\Sitemap\Test\Fixture\Sitemap;

/**
 * Class AssertSitemapSuccessGenerateMessage
 */
class AssertSitemapSuccessGenerateMessage extends AbstractConstraint
{
    const SUCCESS_GENERATE_MESSAGE = 'The sitemap "%s" has been generated.';

    /**
     * Constraint severeness
     *
     * @var string
     */
    protected $severeness = 'low';

    /**
     * Assert that success message is displayed after sitemap generate
     *
     * @param SitemapIndex $sitemapPage
     * @param Sitemap $sitemap
     * @return void
     */
    public function processAssert(
        SitemapIndex $sitemapPage,
        Sitemap $sitemap
    ) {
        $actualMessage = $sitemapPage->getMessagesBlock()->getSuccessMessages();
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_GENERATE_MESSAGE, $sitemap->getSitemapFilename()),
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . sprintf(self::SUCCESS_GENERATE_MESSAGE, $sitemap->getSitemapFilename())
            . "\nActual: " . $actualMessage
        );
    }

    /**
     * Text of success create sitemap assert.
     *
     * @return string
     */
    public function toString()
    {
        return 'Sitemap success generate message is present.';
    }
}
