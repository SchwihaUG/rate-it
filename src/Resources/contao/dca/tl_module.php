<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  cgo IT, 2013
 * @author     Carsten Götzinger (info@cgo-it.de)
 * @package    rateit
 * @license    GNU/LGPL
 * @filesource
 */

 use cgoIT\rateit\DcaHelper;

$GLOBALS['TL_DCA']['tl_module']['config']['onsubmit_callback'][] = array('tl_module_rateit','insert');
$GLOBALS['TL_DCA']['tl_module']['config']['ondelete_callback'][] = array('tl_module_rateit','delete');

/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['rateit'] = '{title_legend},name,rateit_title,type;{rateit_legend},rateit_active;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['rateit_top_ratings'] = '{title_legend},name,headline,type;{rateit_legend},rateit_types,rateit_toptype,rateit_count,rateit_template;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['articleList'] = ($GLOBALS['TL_DCA']['tl_module']['palettes']['articleList'] ?? null).';{rateit_legend},rateit_active';

/**
 * fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['rateit_title'] = array
(
  'label'                 => &$GLOBALS['TL_LANG']['tl_module']['rateit_title'],
  'default'               => '',
  'exclude'               => true,
  'inputType'             => 'text',
  'sql' 						  => "varchar(255) NOT NULL default ''",
  'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rateit_active'] = array
(
  'label'					  => &$GLOBALS['TL_LANG']['tl_module']['rateit_active'],
  'exclude'					  => true,
  'inputType'				  => 'checkbox',
  'sql' 						  => "char(1) NOT NULL default ''",
  'eval'                  => array('tl_class'=>'w50 m12')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rateit_types'] = array
(
  'label'						=> &$GLOBALS['TL_LANG']['tl_module']['rateit_types'],
  'exclude'						=> true,
  'inputType'					=> 'checkboxWizard',
  'options'                => array('page', 'article', 'ce', 'module', 'news', 'faq', 'galpic', 'news4ward'),
  'eval'                   => array('multiple'=>true, 'mandatory'=>true),
  'reference'              => &$GLOBALS['TL_LANG']['tl_module']['rateit_types'],
  'sql'                    => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rateit_toptype'] = array
(
  'label'						=> &$GLOBALS['TL_LANG']['tl_module']['rateit_toptype'],
  'exclude'						=> true,
  'default'                => 'best',
  'inputType'					=> 'select',
  'options'                => array('best', 'most'),
  'eval'                   => array('mandatory'=>true, 'tl_class'=>'w50'),
  'reference'              => &$GLOBALS['TL_LANG']['tl_module']['rateit_toptype'],
  'sql'                    => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rateit_count'] = array
(
  'label'                 => &$GLOBALS['TL_LANG']['tl_module']['rateit_count'],
  'default'               => '10',
  'exclude'               => true,
  'inputType'             => 'text',
  'eval'                  => array('mandatory'=>true, 'maxlength'=>3, 'rgxp'=>'digit', 'tl_class'=>'w50'),
  'sql'                   => "varchar(3) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rateit_template'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_module']['rateit_template'],
  'default'                 => 'mod_rateit_top_ratings',
  'exclude'                 => true,
  'inputType'               => 'select',
  'options_callback'        => array('tl_module_rateit', 'getRateItTopModuleTemplates'),
  'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
  'sql'                     => "varchar(255) NOT NULL default ''"
);

/**
 * Class tl_module_rateit
 */
class tl_module_rateit extends DcaHelper {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	public function insert(\DC_Table $dc) {
      return $this->insertOrUpdateRatingKey($dc, 'module', $dc->activeRecord->rateit_title);
	}

	public function delete(\DC_Table $dc)
	{
      return $this->deleteRatingKey($dc, 'module');
	}

	public function getRateItTopModuleTemplates(\DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('mod_rateit_top', $intPid);
	}
}
?>
