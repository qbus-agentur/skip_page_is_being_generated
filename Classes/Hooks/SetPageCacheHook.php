<?php
namespace Qbus\DisablePageIsBeingGenerated\Hooks;

use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

/**
 * SetPageCacheHook
 *
 * @author Benjamin Franzke <bfr@qbus.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SetPageCacheHook
{
    /**
     * @param array             $params
     * @param FrontendInterface $frontend
     */
    public function set(&$params, $frontend)
    {
        if ($frontend->getIdentifier() !== 'cache_pages') {
            return;
        }

        if (isset($params['variable']['temp_content']) && $params['variable']['temp_content']) {
            /* We can't prevent temp_content ('Page is being generated') from going into cache.
             * But lifetime '-1' will immediately invalidate the temporary cache entry,
             * which is enough, so that it is never used. */
            $params['lifetime'] = -1;
        }
    }
}
