.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _realurl:

RealUrl - Nice Urls
=======================

If you use RealUrl (Version 2+) you can add in your realurl_conf.php in postVarSets the following configuration::

    'postVarSets' => array(
        '_DEFAULT' => array(
            'veranstaltung' => array(
                array(
                    'GETvar' => 'tx_tgmgce_main[index]',
                    'userFunc' => 'TGM\TgmGce\Utility\RealUrlGceUtility->getTitle'
                )
            ),
            'controller' => array(
                array(
                    'GETvar' => 'tx_tgmgce_main[action]',
                    'noMatch' => 'bypass'
                ),
                array(
                    'GETvar' => 'tx_tgmgce_main[controller]',
                    'noMatch' => 'bypass'
                )
            ),
        ),
    ),
