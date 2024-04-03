<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
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

/**
 * Extend tl_article
 */

$GLOBALS['TL_DCA']['tl_faq']['config']['onsubmit_callback'][] = array('tl_faq_rating','insert');
$GLOBALS['TL_DCA']['tl_faq']['config']['ondelete_callback'][] = array('tl_faq_rating','delete');

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_faq']['palettes']['__selector__'][] = 'addRating';
$GLOBALS['TL_DCA']['tl_faq']['palettes']['default'] = ($GLOBALS['TL_DCA']['tl_faq']['palettes']['default'] ?? null).';{rating_legend:hide},addRating';

/**
 * Add subpalettes to tl_article
 */
$GLOBALS['TL_DCA']['tl_faq']['subpalettes']['addRating']  = 'rateit_position';

// Fields
$GLOBALS['TL_DCA']['tl_faq']['fields']['addRating'] = array
(
  'label'						=> &$GLOBALS['TL_LANG']['tl_faq']['addRating'],
  'exclude'						=> true,
  'inputType'					=> 'checkbox',
  'sql' 							=> "char(1) NOT NULL default ''",
  'eval'             		=> array('tl_class'=>'w50 m12', 'submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_faq']['fields']['rateit_position'] = array
(
  'label'                  => &$GLOBALS['TL_LANG']['tl_faq']['rateit_position'],
  'default'                => 'before',
  'exclude'                => true,
  'inputType'              => 'select',
  'options'                => array('after', 'before'),
  'reference'              => &$GLOBALS['TL_LANG']['tl_faq'],
  'sql' 							=> "varchar(6) NOT NULL default ''",
  'eval'                   => array('mandatory'=>true, 'tl_class'=>'w50')
);

class tl_faq_rating extends DcaHelper {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	public function insert(\DC_Table $dc) {
      return $this->insertOrUpdateRatingKey($dc, 'faq', $dc->activeRecord->question);
	}

	public function delete(\DC_Table $dc)
	{
      return $this->deleteRatingKey($dc, 'faq');
	}
}
?>
