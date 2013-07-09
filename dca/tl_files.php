<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *
 * PHP version 5
 * @copyright  Nothing Interactive 2013 <https://www.nothing.ch/>
 * @author     Lukas Walliser <xari@nothing.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Add callback to field name of tl_files
 */
$GLOBALS['TL_DCA']['tl_files']['fields']['name']['save_callback'] = array (
    array('FSPurifier', 'validateInput')
);