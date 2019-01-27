<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/cache/frontend/class.t3lib_cache_frontend_variablefrontend.php']['set']['skip_page_is_being_generated'] =
        \Qbus\SkipPageIsBeingGenerated\Hooks\SetPageCacheHook::class . '->set';
