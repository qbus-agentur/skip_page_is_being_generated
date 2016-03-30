<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Disable the 'Page is being generated' message',
    'description' => '',
    'category' => '',
    'author' => '',
    'author_email' => 'benjaminfranzke@googlemail.com',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '',
    'constraints' => array(
        'depends' => array(
            'typo3' => '6.2.0-7.6.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
    'autoload' => array(
        'psr-4' => array(
            'Qbus\\DisablePageIsBeingGenerated\\' => 'Classes',
        ),
    ),
);
