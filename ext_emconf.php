<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Disable the "Page is being generated" message',
    'description' => 'Invalidates the timestamp of the "Page is being generated" message so that the TSFE always displays the actual page content.',
    'category' => '',
    'author' => 'Benjamin Franzke',
    'author_email' => 'bfr@qbus.de',
    'author_company' => 'Qbus Werbeagentur GmbH',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.1.7',
    'constraints' => array(
        'depends' => array(
            'typo3' => '6.2.14-9.5.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
    'autoload' => array(
        'psr-4' => array(
            'Qbus\\SkipPageIsBeingGenerated\\' => 'Classes',
        ),
    ),
);
