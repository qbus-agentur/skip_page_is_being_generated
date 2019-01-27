<?php
namespace Qbus\SkipPageIsBeingGenerated\Hooks;

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

        // TYPO3 v9 added none-page content to cache_pages, ignore those.
        $ignoredIdentifiers = [
            'redirects',
            '-titleTag-',
            '-metatag-',
        ];
        foreach ($ignoredIdentifiers as $ignored) {
            if (strpos($params['entryIdentifier'], $ignored) !== false) {
                return;
            }
        }

        if (isset($params['variable']['temp_content']) && $params['variable']['temp_content']) {
            /* We can't prevent temp_content ('Page is being generated') from going into cache.
             * But lifetime '-1' will immediately invalidate the temporary cache entry,
             * which is enough, so that it is never used. */
            $params['lifetime'] = -1;

            if ($frontend->getBackend() instanceof \TYPO3\CMS\Core\Cache\Backend\RedisBackend) {
                /* The redis backend does not allow lifetime of -1, use 1 as a workaround.
                 * That means the temporary record will be stored to cache, but as we set the
                 * 'variable' to false, it is interpreted as unset in TSFE:
                 * https://github.com/TYPO3/TYPO3.CMS/blob/8.5.1/typo3/sysext/frontend/Classes/Controller/TypoScriptFrontendController.php#L2352 */
                $params['lifetime'] = 1;
                /* We may move `'variable' = false` out this if in a non-bugfix release,
                 * but for now we leave it here to make sure we do not break things. */
                $params['variable'] = false;
            }
        }
    }
}
