<?php
/**
 * Pager rendering driver
 * 
 * PHP versions 4 and 5
 *
 * LICENSE:
 * 
 * Copyright (c) 1997-2006, Andrew Nagy <asnagy@webitecture.org>,
 *                          Olivier Guilyardi <olivier@samalyse.com>,
 *                          Mark Wiesemann <wiesemann@php.net>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *    * Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *    * Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the 
 *      documentation and/or other materials provided with the distribution.
 *    * The names of the authors may not be used to endorse or promote products 
 *      derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * CSV file id: $Id: Pager.php,v 1.18 2006/12/22 12:28:39 wiesemann Exp $
 * 
 * @version  $Revision: 1.18 $
 * @package  Structures_DataGrid_Renderer_Pager
 * @category Structures
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 */

require_once 'Structures/DataGrid/Renderer.php';
require_once 'Pager/Pager.php';

/**
 * Pager rendering driver
 *
 * This driver provides generic paging.
 * 
 * This driver has full container support. You can use the
 * Structures_DataGrid::fill() method with it. 
 *
 * It buffers output, you can use Structures_DataGrid::getOutput()
 * 
 * SUPPORTED OPTIONS:
 *
 * - pagerOptions: (array)  Options passed to Pager::factory().
 *                          Basic defaults are: mode: Sliding, delta: 5, 
 *                          separator: "|", prevImg: "&lt;&lt;" (<<),
 *                          nextImg: "&gt;&gt;" (>>).
 *                          The extraVars and excludeVars options are 
 *                          populated according to the Renderer common 
 *                          extraVars and excludeVars options. You may also
 *                          specify some variables to be added or excluded
 *                          here.
 *                          The totalItems, perPage, urlVar, and currentPage 
 *                          options are set accordingly to the data statistics
 *                          reported by the DataGrid and DataSource. You may 
 *                          overload these values here if you know what you 
 *                          are doing.
 * - columnAttributes:  (-) IGNORED
 *
 * SUPPORTED OPERATION MODES:
 *
 * - Container Support: yes
 * - Output Buffering:  yes
 * - Direct Rendering:  no
 * - Streaming:         no
 *
 * @version  $Revision: 1.18 $
 * @author   Olivier Guilyardi <olivier@samalyse.com>
 * @author   Mark Wiesemann <wiesemann@php.net>
 * @author   Andrew S. Nagy <asnagy@webitecture.org>
 * @access   public
 * @package  Structures_DataGrid_Renderer_Pager
 * @category Structures
 */
class Structures_DataGrid_Renderer_Pager extends Structures_DataGrid_Renderer
{
    /**
     * Rendering container
     * @var object Pager object
     * @access protected
     */
    var $_pager;
   
    /**
     * Constructor
     *
     * Set default options values
     *
     * @access  public
     */
    function Structures_DataGrid_Renderer_Pager()
    {
        parent::Structures_DataGrid_Renderer();
        $this->_addDefaultOptions(
            array(
                'pagerOptions' => array(
                    'mode'        => 'Sliding',
                    'delta'       => 5,
                    'separator'   => '|',
                    'prevImg'     => '&lt;&lt;',
                    'nextImg'     => '&gt;&gt;',
                    'totalItems'  => null, // dynamic; see init()
                    'perPage'     => null, // dynamic; see init()
                    'urlVar'      => null, // dynamic; see init()
                    'currentPage' => null, // dynamic; see init()
                    'extraVars'   => array(),
                    'excludeVars' => array(),
                ),
            )
        );
        $this->_setFeatures(
            array(
                'outputBuffering' => true,
            )
        );
    }
    
    /**
     * Attach an already instantiated Pager object
     *
     * @var     object  Pager object
     * @return  mixed   True or PEAR_Error
     * @access public
     */
    function setContainer(&$pager)
    {
        $this->_pager =& $pager;
        return true;
    }
    
    /**
     * Return the currently used Pager object
     *
     * @return object Pager (reference to) or PEAR_Error
     * @access public
     */
    function &getContainer()
    {
        isset($this->_pager) or $this->init();
        return $this->_pager;
    }
    
    /**
     * Instantiate the Pager container if needed, and set it up
     * 
     * @access protected
     */
    function init()
    {
        $options = array();
      
        // Setting core pager options. Users can overwrite these
        if (is_null($this->_options['pagerOptions']['totalItems'])) {
            $options['totalItems'] = $this->_totalRecordsNum;
        }
        
        if (is_null($this->_options['pagerOptions']['perPage'])) {
            $options['perPage'] = is_null($this->_pageLimit) 
                                ? $this->_totalRecordsNum 
                                : $this->_pageLimit;
        }
        
        if (is_null($this->_options['pagerOptions']['urlVar'])) {
            $options['urlVar'] = $this->_requestPrefix . 'page';
        }
        
        if (is_null($this->_options['pagerOptions']['currentPage'])) {
            $options['currentPage'] = $this->_page;
        }
        
            
        if (!isset($this->_pager)) {
            // No external container, Then we set our defaults.
            $options = array_merge($this->_options['pagerOptions'],$options);
            
            $options['excludeVars'] = array_merge($this->_options['excludeVars'],
                                                  $options['excludeVars']);    
            
            $options['extraVars'] = array_merge($this->_options['extraVars'],
                                                $options['extraVars']);    
            
            $this->_pager =& Pager::factory($options);
        } else {
            // There is an external container. We try to be less intrusive as 
            // possible. We need to set the core options anyway.
            $options = array_merge($this->_pager->getOptions(), $options);

            // FIXME: does not forward get arguments

            $options['excludeVars'] = array_merge($this->_options['excludeVars'],
                                                  $options['excludeVars']);    
            
            $options['extraVars'] = array_merge($this->_options['extraVars'],
                                                $options['extraVars']);    
            
            $this->_pager->setOptions($options);
        }
    }
    
    /**
     * Retrieve links from the Pager object
     *
     * @return string HTML links
     * @access protected
     */
    function flatten()
    {
        return $this->_pager->links;
    }

    /**
     * Helper methods for drivers that automatically load this driver
     *
     * This is (or has been...) used by the HTMLTable and Smarty driver
     * 
     * @param object $renderer External driver
     * @param array  $pagerOptions pager options
     * @return void
     * @access public
     */
    function setupAs(&$renderer, $pagerOptions)
    {
        $this->setLimit($renderer->_page, $renderer->_pageLimit, 
                        $renderer->_totalRecordsNum);
        $this->setRequestPrefix($renderer->_requestPrefix);
        $options['pagerOptions'] = array_merge($this->_options['pagerOptions'], 
                                               $pagerOptions);
        $options['excludeVars'] = $renderer->_options['excludeVars'];
        $options['extraVars'] = $renderer->_options['extraVars'];
        $this->setOptions($options);
    }

    /**
     * Set multiple options
     *
     * @param   mixed   $options    An associative array of the form:
     *                              array("option_name" => "option_value",...)
     * @access  public
     */
    function setOptions($options)
    {
        /* This method is overloaded here because array_merge() needs to be called
         * over the "pagerOptions" option. Otherwise, if the user only provide a few
         * pager options, built-in defaults generally get overwritten.
         *
         * setOptions() is a public method, so it can be overloaded. But, because
         * the $_options method is considered read-only, this method does not write 
         * into this property directly. It calls parent::setOptions() instead.
         */
        if (isset($options['pagerOptions'])) {
            $options['pagerOptions'] = array_merge($this->_options['pagerOptions'], 
                                                    $options['pagerOptions']);
            if (isset($this->_pager)) {
                $this->_pager->setOptions($options['pagerOptions']);
            }
        }
        parent::setOptions($options);
    }

    /**
     * Set a single option
     *
     * @param   string  $name       Option name
     * @param   mixed   $value      Option value
     * @access  public
     */
    function setOption($name, $value)
    {
        // see notes in setOptions()
        if ($name == 'pagerOptions') {
            $value = array_merge($this->_options['pagerOptions'],$value);
            if (isset($this->_pager)) {
                $this->_pager->setOptions($value);
            }
        }
        parent::setOption($name,$value);
    }

    /**
     * Rebuild the pager links
     * 
     * This is useful because the pager options may change after it gets
     * instantiated.
     * 
     * @access  protected
     * @return  void
     */
    function buildBody()
    {
        $this->_pager->build();
    }
}

/* vim: set expandtab tabstop=4 shiftwidth=4: */
?>
