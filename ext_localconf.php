<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/cache/frontend/class.t3lib_cache_frontend_variablefrontend.php']['set'][$_EXTKEY] =
        \Qbus\SkipPageIsBeingGenerated\Hooks\SetPageCacheHook::class . '->set';

