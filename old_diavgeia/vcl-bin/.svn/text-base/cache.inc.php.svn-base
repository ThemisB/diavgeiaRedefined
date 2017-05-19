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

    class Cache extends Component
    {
      /**
      * Start caching output, will be called just before start dumping content
      * to the output.
      *
      * This method should use $control and $cachetype to create a unique identifier
      * for the cache storage and should start the caching process. If content is not
      * cached, should return false to allow the caller know should produce the content.
      *
      * If the identifier already exists, meaning the content has been already cached,
      * then should dump out the cached content and return true.
      *
      * @param object $control Control to be cached
      * @param string $cachetype A prefix to specify what kind of contents are going to be cached
      *
      * @return boolean True if the content was already cached
      */
      function startCache($control, $cachetype)
      {
      }

      /**
      * Finish the caching process
      */
      function endCache()
      {
      }
    }
?>