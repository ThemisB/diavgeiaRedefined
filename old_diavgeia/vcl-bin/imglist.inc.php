<?php
/**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2008 qadram software S.L. <support@qadram.com>
*
*  Checkout AUTHORS file for more information on the developers
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
*  USA
*
*/

use_unit("classes.inc.php");

/**
 * A component that holds a list of image paths.

 * This component doesn't work exactly like the VCL for Windows TImageList
 * because in web applications, images are usually paths to the image files, so
 * this is a repository for that kind of lists
 *
 * Use the Images property to specify which images this component holds. That property
 * is an array.
 *
 */
class ImageList extends Component
{
        protected $_images=array();

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
        * Array of images this ImageList hold.
        *
        * You can use the array to iterate
        * throught it or to get an specific image path by it's index
        *
        * @return array
        */
        function getImages() { return $this->_images;   }
        function setImages($value) { $this->_images=$value; }
        function defaultImages() { return array();   }

        /**
        * Returns an image from the array specified by $index, the index must
        * exists, if not, false is returned
        *
        * @return string
        */
        function readImage($index)
        {
                //TODO: Check this with numeric keys as it fails
                if (isset($this->_images[$index])) return($this->_images[$index]);
                else
                {
                        reset($this->_images);
                        while(list($key, $val)=each($this->_images))
                        {
                                if ($key==$index) return($val);
                        }
                        return false;
                }
        }

        /**
        * Returns an image from the array, by an ID
        *
        * @param integer $index Index of the image to get
        * @param boolean $preformat If true, the path returned will be preformated
        * @return string
        */
        function readImageByID($index, $preformat)
        {
                $image="";
                if (isset($this->_images))
                {
                        reset($this->_images);
                        while ((list($k, $img) = each($this->_images)) && $image == "")
                        {
                                if ($k == $index)
                                {
                                        $image = $img;
                                }
                        }
                }

                if ($image != "")
                {
                        $image = str_replace("%VCL_HTTP_PATH%", VCL_HTTP_PATH, $image);
                }

                if ($preformat == 1)
                {
                        if (($image == "") || ($image == null))
                        { $image = "null"; }
                        else
                        { $image = "\"" . $image . "\""; }
                }

                return $image;
        }
}


?>