<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,description,image,form,form_receiver_mail,name,surname,email,salutation,tel,street,zip,city,lon,lat,gruppe,country,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tgm_gce') . 'Resources/Public/Icons/calendar.png'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, image, form, form_receiver_mail, name, surname, email, salutation, tel, street, zip, city, country, lon, lat, gruppe, categories,',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, description;;;richtext:rte_transform[mode=ts_links], image, gruppe, --div--;LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.contact, salutation, name, surname, email, tel,  --div--;LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.location, street, zip, city, country, lon, lat,--div--;LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.form, form, form_receiver_mail ,--div--;LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.date,calendarize, calendarize_info, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime,'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_tgmgce_domain_model_events',
				'foreign_table_where' => 'AND tx_tgmgce_domain_model_events.pid=###CURRENT_PID### AND tx_tgmgce_domain_model_events.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'module' => array(
							'name' => 'wizard_rich_text_editor',
							'urlParameters' => array(
								'mode' => 'wizard',
								'act' => 'wizard_rte.php'
							)
						),
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
		),
		'image' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'image',
				array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
					),
					'foreign_types' => array(
						'0' => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						)
					),
					'maxitems' => 1
				),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'form' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.form',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.form.empty', ''),
					array('LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.form.standard', 'Standard')
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'form_receiver_mail' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.form_receiver_mail',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'surname' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.surname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'salutation' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.salutation',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'tel' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.tel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'street' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'zip' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.zip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
        'country' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.country',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => 'TGM\TgmGce\Backend\ItemsProcFuncs\Country->itemsProcFunc',
                'size' => 1,
                'maxitems' => 1,
            )
        ),
		'lon' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.lon',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lat' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.lat',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'gruppe' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:tgm_gce/Resources/Private/Language/locallang_db.xlf:tx_tgmgce_domain_model_events.gruppe',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
                'items' => [
                    ['no group',0]
                ],
				'foreign_table' => 'tx_tgmgce_domain_model_eventgroup',
				'minitems' => 0,
				'maxitems' => 99,
			),
		),
        'categories' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' =>  'cat',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'showHeader' => true,
                        'expandAll' => true,
                        'maxLevels' => 99,
                    ],
                ],
                'MM' => 'sys_category_record_mm',
                'MM_match_fields' => [
                    'fieldname' => 'categories',
                    'tablenames' => 'tx_tgmgce_domain_model_events',
                ],
                'MM_opposite_field' => 'items',
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 99,
            ]
        ],
		
	),
);