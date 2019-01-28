<?php
namespace Qbus\SkipPageIsBeingGenerated\Tests\Unit;

use Qbus\SkipPageIsBeingGenerated\Hooks\SetPageCacheHook;
use TYPO3\CMS\Core\Cache\Backend\RedisBackend;
use TYPO3\CMS\Core\Cache\Backend\BackendInterface;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
//use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * SetPageCacheHookTest
 *
 * @author Benjamin Franzke <bfr@qbus.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SetPageCacheHookTest extends UnitTestCase
{
    /**
     * @var ObjectProphecy
     */
    protected $cacheFrontendProphecy;

    /**
     * @var ObjectProphecy
     */
    protected $cacheBackendProphecy;

    /**
     * @var params
     */

    /**
     * @var SetPageCacheHook
     */
    protected $hook;

    /**
     * @var string
     */
    protected $entryIdentifier;

    /**
     * @var array|bool
     */
    protected $variable;

    /**
     * @var int
     */
    protected $lifetime;

    public function setUp()
    {
        $cacheBackendProphecy = $this->prophesize();
        $cacheBackendProphecy->willImplement(BackendInterface::class);

        $cacheFrontendProphecy = $this->prophesize();
        $cacheFrontendProphecy->willImplement(FrontendInterface::class);
        $cacheFrontendProphecy->getIdentifier()->willReturn('cache_pages');
        $cacheFrontendProphecy->getBackend()->will(function () use ($cacheBackendProphecy) {
            return $cacheBackendProphecy->reveal();
        });

        $this->cacheBackendProphecy = $cacheBackendProphecy;
        $this->cacheFrontendProphecy = $cacheFrontendProphecy;
        $this->hook = new SetpageCacheHook;

        $this->entryIdentifier = md5('foo');
        $this->lifetime = 30;
        $this->variable = [
            'foo' => 'bar',
            'temp_content' => true,
        ];
        $tags = [];

        $this->params = [
            'entryIdentifier' => &$this->entryIdentifier,
            'variable' => &$this->variable,
            'lifetime' => &$this->lifetime,
            'tags' => &$tags,
        ];
    }

    public function testSetInvalidatesLifetime()
    {
        $this->hook->set($this->params, $this->cacheFrontendProphecy->reveal());

        $this->assertEquals(-1, $this->lifetime);
    }

    public function testSetInvalidatesLifetimeForRedis()
    {
        $this->cacheBackendProphecy->willExtend(RedisBackend::class);

        $this->hook->set($this->params, $this->cacheFrontendProphecy->reveal());

        $this->assertEquals(1, $this->lifetime);
        $this->assertFalse($this->variable);
    }

    public function testSetDoesNothingForNonTemporaryPageCache()
    {
        unset($this->variable['temp_content']);

        $this->hook->set($this->params, $this->cacheFrontendProphecy->reveal());

        $this->assertEquals(30, $this->lifetime);
    }

    public function testSetDoesNothingForNonPageCache()
    {
        $this->cacheFrontendProphecy->getIdentifier()->willReturn('cache_pagesection');

        $this->hook->set($this->params, $this->cacheFrontendProphecy->reveal());

        $this->assertEquals(30, $this->lifetime);
    }

    public function testSetDoesNothingForRedirectsPageCache()
    {
        $this->entryIdentifier = 'redirects';

        $this->hook->set($this->params, $this->cacheFrontendProphecy->reveal());

        $this->assertEquals(30, $this->lifetime);
    }

    public function testSetDoesNothingForTitleTagPageCache()
    {
        $this->entryIdentifier .= '-titleTag-record';

        $this->hook->set($this->params, $this->cacheFrontendProphecy->reveal());

        $this->assertEquals(30, $this->lifetime);
    }

    public function testSetDoesNothingForMetatagPageCache()
    {
        $this->entryIdentifier .= '-metatag-html5';

        $this->hook->set($this->params, $this->cacheFrontendProphecy->reveal());

        $this->assertEquals(30, $this->lifetime);
    }
}
