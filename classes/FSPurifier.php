<?php
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
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
 * @copyright  Nothing interactive 2013  <https://www.nothing.ch/>
 * @author     Lukas Walliser <xari@nothing.ch>
 * @license http://opensource.org/licenses/lgpl-3.0.html
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Class FSPurifier - The filesystem purifier
 * Converts file and folder names when created,uploaded or edited by users
 *
 * @copyright  Nothing interactive 2013  <https://www.nothing.ch/>
 * @author     Lukas Walliser <xari@nothing.ch>
 */
class FSPurifier extends \Backend {

    /**
     * Here you can find the RegularExpression that is used to filter the user inputs.
     * This is a whitelist of unreserved chars so all characters that can be found in it are currently legal.
     *
     * unreserved: upper and lower case letters, decimal digits and
     * "-" | "_" | "." | "!" | "~" | "*" | "'" | "(" | ")"
     */
    const white_list = '/[^a-zA-Z0-9-_\.\!\~\*\'\(\)]/';

    /**
     * Validates the input of uploaded files names
     * Allowed symbols are a-z, A-Z, 0-9, _ and .
     *
     * @param $files     - The upload name
     * */
    public function validateFile($files) {
        foreach($files as $path) {
            if (file_exists(TL_ROOT . '/' . $path)) {
                // Remove unwanted Symbols from the filename
                $fileName = preg_replace(self::white_list, '_', basename($path));
                //Rename the file
                if (basename($path) != $fileName) {
                    rename(TL_ROOT . '/' . $path, TL_ROOT . '/' . dirname($path) . '/' . $fileName);
                    // Inform user
                    \Message::addNew(sprintf($GLOBALS['TL_LANG']['MSC']['warningOnFileUpload'], basename($path),$fileName));
                }
            }
        }
    }

    /**
     * Validates the input of new folder- and filenames
     * Allowed symbols are a-z, A-Z, 0-9, _ and .
     *
     * @param $filename     - The input name
     * @return mixed        - The new updated name
     */
    public function validateInput($filename) {
        $result = preg_replace(self::white_list, '_', $filename);
        // Inform user
        if ($filename != $result) {
            \Message::addNew(sprintf($GLOBALS['TL_LANG']['MSC']['warningOnFileRename'], $filename, $result));
        }
        return $result;
    }
}