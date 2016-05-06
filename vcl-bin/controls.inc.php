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
use_unit("graphics.inc.php");

/**
*
*/
define('alNone','alNone');
define('alTop','alTop');
define('alBottom','alBottom');
define('alLeft','alLeft');
define('alRight','alRight');
define('alClient','alClient');
define('alCustom','alCustom');

define('agNone','agNone');
define('agLeft','agLeft');
define('agCenter','agCenter');
define('agRight','agRight');

define('crPointer','crPointer');
define('crCrossHair','crCrossHair');
define('crText','crText');
define('crWait','crWait');
define('crDefault','crDefault');
define('crHelp','crHelp');
define('crEResize','crE-Resize');
define('crNEResize','crNE-Resize');
define('crNResize','crN-Resize');
define('crNWResize','crNW-Resize');
define('crWResize','crW-Resize');
define('crSWResize','crSW-Resize');
define('crSResize','crS-Resize');
define('crSEResize','crSE-Resize');
define('crAuto','crAuto');

/**
 * Control is the base class for all components that are visible at runtime.
 *
 * Controls are visual components, meaning the user can see them and possibly
 * interact with them at runtime. All controls have properties, methods, and events
 * that describe aspects of their appearance, such as the position of the control,
 * the cursor or hint associated with the control, methods to paint or move the control,
 * and events that respond to user actions.
 *
 * Control has many protected properties and methods that are used or published by its descendants.
 */
class Control extends Component
{
        protected $_caption="";
        protected $_parent=null;
        protected $_popupmenu=null;
        protected $_controlstyle=array();
        protected $_left=0;
        protected $_visible=1;
        protected $_top=0;
        protected $_width=null;
        protected $_height=null;
        protected $_color="";
        protected $_parentcolor=1;
        protected $_enabled=1;
        protected $_hint="";
        protected $_designcolor="";
        protected $_align=alNone;
        protected $_alignment=agNone;
        protected $_onbeforeshow=null;
        protected $_onaftershow=null;
        protected $_onshow=null;
        protected $_cursor="";
        protected $_showhint=0;
        protected $_parentshowhint=1;

        protected $_font=null;

        protected $_islayer=0;
        protected $_parentfont=1;

        private $_doparentreset = true;

        protected $_jsonactivate=null;
        protected $_jsondeactivate=null;
        protected $_jsonbeforecopy=null;
        protected $_jsonbeforecut=null;
        protected $_jsonbeforedeactivate=null;
        protected $_jsonbeforeeditfocus=null;
        protected $_jsonbeforepaste=null;
        protected $_jsonblur=null;
        protected $_jsonchange=null;
        protected $_jsonclick=null;
        protected $_jsoncontextmenu=null;
        protected $_jsoncontrolselect=null;
        protected $_jsoncopy=null;
        protected $_jsoncut=null;
        protected $_jsondblclick=null;
        protected $_jsondrag=null;
        protected $_jsondragenter=null;
        protected $_jsondragleave=null;
        protected $_jsondragover=null;
        protected $_jsondragstart=null;
        protected $_jsondrop=null;
        protected $_jsonfilterchange=null;
        protected $_jsonfocus=null;
        protected $_jsonhelp=null;
        protected $_jsonkeydown=null;
        protected $_jsonkeypress=null;
        protected $_jsonkeyup=null;
        protected $_jsonlosecapture=null;
        protected $_jsonmousedown=null;
        protected $_jsonmouseup=null;
        protected $_jsonmouseenter=null;
        protected $_jsonmouseleave=null;
        protected $_jsonmousemove=null;
        protected $_jsonmouseout=null;
        protected $_jsonmouseover=null;
        protected $_jsonpaste=null;
        protected $_jsonpropertychange=null;
        protected $_jsonreadystatechange=null;
        protected $_jsonresize=null;
        protected $_jsonresizeend=null;
        protected $_jsonresizestart=null;
        protected $_jsonselectstart=null;


        /**
        * Fires when the object is set as the active element.
        *
        * This event is fired when the user click an element, other than the active element of the document,
        * or use the keyboard to move focus from the active element to another element.
        * Also can be fired if the script invokes the setActive method on an element,
        * when the element is not the active element.
        *
        * @return mixed
        */
        protected function readjsOnActivate                () { return $this->_jsonactivate; }

        /**
        * Fires when the activeElement is changed from the current object to another object in the parent document.
        *
        * This event is fired when the user click an element, other than the active element of the document,
        * or use the keyboard to move focus from the active element to another element.
        * Also can be fired if the script invokes the setActive method on an element,
        * when the element is not the active element.
        *
        * @return mixed
        */
        protected function readjsOnDeActivate              () { return $this->_jsondeactivate; }

        /**
        * Fires on the source object before the selection is copied to the system clipboard.
        *
        * Is fired if the user right-click to display the shortcut menu and select Copy or
        * presses CTRL+C.
        *
        * @return mixed
        */
        protected function readjsOnBeforeCopy              () { return $this->_jsonbeforecopy; }

        /**
        * Fires on the source object before the selection is deleted from the document.
        *
        * Is fired if the user right-click to display the shortcut menu and select Cut or
        * presses CTRL+X.
        *
        * @return mixed
        */
        protected function readjsOnBeforeCut               () { return $this->_jsonbeforecut; }

        /**
        * Fires immediately before the activeElement is changed from the current object to another object in the parent document.
        *
        * This event is fired when the user click an element, other than the active element of the document,
        * or use the keyboard to move focus from the active element to another element.
        * Also can be fired if the script invokes the setActive method on an element,
        * when the element is not the active element.
        *
        * @return mixed
        */
        protected function readjsOnBeforeDeactivate        () { return $this->_jsonbeforedeactivate; }

        /**
        * Fires before an object contained in an editable element enters a UI-activated state or when an editable
        * container object is control selected.
        *
        * To invoke this event, press the ENTER key or click an object when it has focus or double-click an object.
        * The onbeforeeditfocus event differs from the onfocus event. The onbeforeeditfocus event fires before an
        * object enters a UI-activated state, whereas the onfocus event fires when an object has focus.
        *
        * @return mixed
        */
        protected function readjsOnBeforeEditfocus         () { return $this->_jsonbeforeeditfocus; }

        /**
        * Fires on the target object before the selection is pasted from the system clipboard to the document.
        *
        * Is fired if the user right-click to display the shortcut menu and select Paste or
        * presses CTRL+V.
        *
        * @return mixed
        */
        protected function readjsOnBeforePaste             () { return $this->_jsonbeforepaste; }

        /**
        * Fires when the object loses the input focus.
        *
        * The onblur event fires on the original object before the onfocus or
        * onclick event fires on the object that is receiving focus. Where applicable,
        * the onblur event fires after the onchange event.
        *
        * Use the focus events to determine when to prepare an object to receive
        * or validate input from the user.
        *
        * @return mixed
        */
        protected function readjsOnBlur                    () { return $this->_jsonblur; }

        /**
        * Fires when the contents of the object or selection have changed.
        *
        * This event is fired when the contents are committed and not while the
        * value is changing. For example, on a text box, this event is not fired
        * while the user is typing, but rather when the user commits the change
        * by leaving the text box that has focus. In addition, this event is
        * executed before the code specified by onblur when the control is also
        * losing the focus.
        *
        * @return mixed
        */
        protected function readjsOnChange                  () { return $this->_jsonchange; }

        /**
        * Fires when the user clicks the left mouse button on the object.
        *
        * If the user clicks the left mouse button, the onclick event for an
        * object occurs only if the mouse pointer is over the object and an
        * onmousedown and an onmouseup event occur in that order. For example,
        * if the user clicks the mouse on the object but moves the mouse pointer
        * away from the object before releasing, no onclick event occurs.
        *
        * @return mixed
        */
        protected function readjsOnClick                   () { return $this->_jsonclick; }

        /**
        * Fires when the user clicks the right mouse button in the client area, opening
        * the context menu.
        *
        * @return mixed
        */
        protected function readjsOnContextMenu             () { return $this->_jsoncontextmenu; }

        /**
        * Fires when the user is about to make a control selection of the object.
        *
        * This event fires before the element is selected, so inspecting the
        * selection object gives no information about the element to be selected.
        *
        * @return mixed
        */
        protected function readjsOnControlSelect           () { return $this->_jsoncontrolselect; }

        /**
        * Fires on the source element when the user copies the object or selection, adding it to the system clipboard.
        *
        * Is fired if the user right-click to display the shortcut menu and select Copy or
        * presses CTRL+C.
        *
        * @return mixed
        */
        protected function readjsOnCopy                    () { return $this->_jsoncopy; }

        /**
        * Fires on the source element when the object or selection is removed from the document and added to the system clipboard.
        *
        * Is fired if the user right-click to display the shortcut menu and select Cut or
        * presses CTRL+X.
        *
        * @return mixed
        */
        protected function readjsOnCut                     () { return $this->_jsoncut; }

        /**
        * Fires when the user double-clicks the object.
        *
        * The order of events leading to the ondblclick event is onmousedown,
        * onmouseup, onclick, onmouseup, and then ondblclick.
        *
        * @return mixed
        */
        protected function readjsOnDblClick                () { return $this->_jsondblclick; }

        /**
        * Fires on the source object continuously during a drag operation.
        *
        * This event fires on the source object after the ondragstart event. The
        * ondrag event fires throughout the drag operation, whether the selection
        * being dragged is over the drag source, a valid target, or an invalid target.
        *
        * @return mixed
        */
        protected function readjsOnDrag                    () { return $this->_jsondrag; }

        /**
        * Fires on the target element when the user drags the object to a valid drop target.
        *
        * You can handle the ondragenter event on the source or on the target object.
        * Of the target events, it is the first to fire during a drag operation.
        *
        * @return mixed
        */

        protected function readjsOnDragEnter               () { return $this->_jsondragenter; }

        /**
        * Fires on the target object when the user moves the mouse out of a valid drop target during a drag operation.
        * @return mixed
        */
        protected function readjsOnDragLeave               () { return $this->_jsondragleave; }

        /**
        * Fires on the target element continuously while the user drags the object
        * over a valid drop target.
        *
        * The ondragover event fires on the target object after the ondragenter
        * event has fired.
        *
        * @return mixed
        */
        protected function readjsOnDragOver                () { return $this->_jsondragover; }

        /**
        * Fires on the source object when the user starts to drag a text selection
        * or selected object.
        *
        * The ondragstart event is the first to fire when the user starts to drag
        * the mouse.
        *
        * @return mixed
        */
        protected function readjsOnDragStart               () { return $this->_jsondragstart; }

        /**
        * Fires on the target object when the mouse button is released during a
        * drag-and-drop operation.
        *
        * The ondrop event fires before the ondragleave and ondragend events.
        *
        * @return mixed
        */
        protected function readjsOnDrop                    () { return $this->_jsondrop; }

        /**
        * Fires when a visual filter changes state or completes a transition.
        *
        * @return mixed
        */
        protected function readjsOnFilterChange            () { return $this->_jsonfilterchange; }

        /**
        * Fires when the object receives focus.
        *
        * When one object loses activation and another object becomes the activeElement,
        * the onfocus event fires on the object becoming the activeElement only
        * after the onblur event fires on the object losing activation. Use the
        * focus events to determine when to prepare an object to receive input from
        * the user.
        *
        * @return mixed
        */
        protected function readjsOnFocus                   () { return $this->_jsonfocus; }

        /**
        * Fires when the user presses the F1 key while the browser is the active window.
        * @return mixed
        */
        protected function readjsOnHelp                    () { return $this->_jsonhelp; }

        /**
        * Fires when the user presses a key.
        *
        * This event is specifically fired when the key is pressed down and is repeated
        * multiple times until the key is released.
        *
        * @return mixed
        */
        protected function readjsOnKeyDown                 () { return $this->_jsonkeydown; }

        /**
        * Fires when the user presses an alphanumeric key.
        *
        * This event can be used to detect key presses of standard keys, if you
        * need to process other keys (like cursor keys), use jsOnKeyDown.
        *
        * @return mixed
        */
        protected function readjsOnKeyPress                () { return $this->_jsonkeypress; }

        /**
        * Fires when the user releases a key.
        *
        * This event is fired whenever a key pressed is released, both for keypress and
        * keydown events.
        *
        * @return mixed
        */
        protected function readjsOnKeyUp                   () { return $this->_jsonkeyup; }
        /**
        * Fires when the object loses the mouse capture.
        * @return mixed
        */
        protected function readjsOnLoseCapture             () { return $this->_jsonlosecapture; }

        /**
        * Fires when the user clicks the object with either mouse button.
        *
        * Use this event to detect when the mouse is pressed on an element, you
        * can use the button property of the event to determine which mouse button
        * is clicked.
        *
        * @return mixed
        */
        protected function readjsOnMouseDown               () { return $this->_jsonmousedown; }

        /**
        * Fires when the user releases a mouse button while the mouse is over the object.
        *
        * When any mouse button stops from being pressed over an element, this event is
        * fired, you can use the button property to determine which mouse button
        * is clicked.
        *
        * @return mixed
        */
        protected function readjsOnMouseUp                 () { return $this->_jsonmouseup; }

        /**
        * Fires when the user moves the mouse pointer into the object.
        *
        * The event fires only if the mouse pointer is outside the boundaries of
        * the object and the user moves the mouse pointer inside the boundaries
        * of the object.
        *
        * @return mixed
        */
        protected function readjsOnMouseEnter              () { return $this->_jsonmouseenter; }

        /**
        * Fires when the user moves the mouse pointer outside the boundaries of the object.
        *
        * The event fires only if the mouse pointer is inside the boundaries of
        * the object and the user moves the mouse pointer outside the boundaries
        * of the object.
        *
        * @return mixed
        */
        protected function readjsOnMouseLeave              () { return $this->_jsonmouseleave; }

        /**
        * Fires when the user moves the mouse over the object.
        *
        * If the user presses a mouse button, use the button property to
        * determine which button was pressed.
        *
        * @return mixed
        */
        protected function readjsOnMouseMove               () { return $this->_jsonmousemove; }

        /**
        * Fires when the user moves the mouse pointer outside the boundaries of the object.
        *
        * When the user moves the mouse over an object, one onmouseover event occurs,
        * followed by one or more onmousemove events as the user moves the mouse
        * pointer within the object. One onmouseout event occurs when the user
        * moves the mouse pointer out of the object.
        *
        * @return mixed
        */
        protected function readjsOnMouseOut                () { return $this->_jsonmouseout; }

        /**
        * Fires when the user moves the mouse pointer into the object.
        *
        * The event occurs when the user moves the mouse pointer into the object,
        * and it does not repeat unless the user moves the mouse pointer out of
        * the object and then back into it.
        *
        * @return mixed
        */
        protected function readjsOnMouseOver               () { return $this->_jsonmouseover; }

        /**
        * Fires on the target object when the user pastes data, transferring the
        * data from the system clipboard to the document.
        *
        * @return mixed
        */
        protected function readjsOnPaste                   () { return $this->_jsonpaste; }

        /**
        * Fires when a property changes on the object.
        *
        * The onpropertychange event fires when properties of an object, expando,
        * or style sub-object change. To retrieve the name of the changed property,
        * use the event object's propertyName property.
        *
        * @return mixed
        */
        protected function readjsOnPropertyChange          () { return $this->_jsonpropertychange; }

        /**
        * Fires when the state of the object has changed.
        *
        * You can use the readyState property to query the current state of the
        * element when the onreadystatechange event fires.
        *
        * @return mixed
        */
        protected function readjsOnReadyStateChange        () { return $this->_jsonreadystatechange; }

        /**
        * Fires when the size of the object is about to change.
        *
        * The onresize event fires for block and inline objects with layout,
        * even if document or CSS (cascading style sheets) property values are changed.
        *
        * @return mixed
        */
        protected function readjsOnResize                  () { return $this->_jsonresize; }

        /**
        * Fires when the user finishes changing the dimensions of the object in
        * a control selection.
        *
        * Only content editable objects can be included in a control selection.
        *
        * @return mixed
        */
        protected function readjsOnResizeEnd               () { return $this->_jsonresizeend; }

        /**
        * Fires when the user begins to change the dimensions of the object in a
        * control selection
        *
        * Only content editable objects can be included in a control selection.
        *
        * @return mixed
        */
        protected function readjsOnResizeStart             () { return $this->_jsonresizestart; }

        /**
        * Fires when the object is being selected
        *
        * The object at the beginning of the selection fires the event.
        *
        * @return mixed
        */
        protected function readjsOnSelectStart             () { return $this->_jsonselectstart; }

        protected function writejsOnActivate($value)                { $this->_jsonactivate=$value; }
        protected function writejsOnDeActivate($value)              { $this->_jsondeactivate=$value; }
        protected function writejsOnBeforeCopy($value)              { $this->_jsonbeforecopy=$value; }
        protected function writejsOnBeforeCut($value)               { $this->_jsonbeforecut=$value; }
        protected function writejsOnBeforeDeactivate($value)        { $this->_jsonbeforedeactivate=$value; }
        protected function writejsOnBeforeEditfocus($value)         { $this->_jsonbeforeeditfocus=$value; }
        protected function writejsOnBeforePaste($value)             { $this->_jsonbeforepaste=$value; }
        protected function writejsOnBlur($value)                    { $this->_jsonblur=$value; }
        protected function writejsOnChange($value)                  { $this->_jsonchange=$value; }
        protected function writejsOnClick($value)                   { $this->_jsonclick=$value; }
        protected function writejsOnContextMenu($value)             { $this->_jsoncontextmenu=$value; }
        protected function writejsOnControlSelect($value)           { $this->_jsoncontrolselect=$value; }
        protected function writejsOnCopy($value)                    { $this->_jsoncopy=$value; }
        protected function writejsOnCut($value)                     { $this->_jsoncut=$value; }
        protected function writejsOnDblClick($value)                { $this->_jsondblclick=$value; }
        protected function writejsOnDrag($value)                    { $this->_jsondrag=$value; }
        protected function writejsOnDragEnter($value)               { $this->_jsondragenter=$value; }
        protected function writejsOnDragLeave($value)               { $this->_jsondragleave=$value; }
        protected function writejsOnDragOver($value)                { $this->_jsondragover=$value; }
        protected function writejsOnDragStart($value)               { $this->_jsondragstart=$value; }
        protected function writejsOnDrop($value)                    { $this->_jsondrop=$value; }
        protected function writejsOnFilterChange($value)            { $this->_jsonfilterchange=$value; }
        protected function writejsOnFocus($value)                   { $this->_jsonfocus=$value; }
        protected function writejsOnHelp($value)                    { $this->_jsonhelp=$value; }
        protected function writejsOnKeyDown($value)                 { $this->_jsonkeydown=$value; }
        protected function writejsOnKeyPress($value)                { $this->_jsonkeypress=$value; }
        protected function writejsOnKeyUp($value)                   { $this->_jsonkeyup=$value; }
        protected function writejsOnLoseCapture($value)             { $this->_jsonlosecapture=$value; }
        protected function writejsOnMouseDown($value)               { $this->_jsonmousedown=$value; }
        protected function writejsOnMouseUp($value)                 { $this->_jsonmouseup=$value; }
        protected function writejsOnMouseEnter($value)              { $this->_jsonmouseenter=$value; }
        protected function writejsOnMouseLeave($value)              { $this->_jsonmouseleave=$value; }
        protected function writejsOnMouseMove($value)               { $this->_jsonmousemove=$value; }
        protected function writejsOnMouseOut($value)                { $this->_jsonmouseout=$value; }
        protected function writejsOnMouseOver($value)               { $this->_jsonmouseover=$value; }
        protected function writejsOnPaste($value)                   { $this->_jsonpaste=$value; }
        protected function writejsOnPropertyChange($value)          { $this->_jsonpropertychange=$value; }
        protected function writejsOnReadyStateChange($value)        { $this->_jsonreadystatechange=$value; }
        protected function writejsOnResize($value)                  { $this->_jsonresize=$value; }
        protected function writejsOnResizeEnd($value)               { $this->_jsonresizeend=$value; }
        protected function writejsOnResizeStart($value)             { $this->_jsonresizestart=$value; }
        protected function writejsOnSelectStart($value)             { $this->_jsonselectstart=$value; }

        function defaultjsOnActivate                () { return null; }
        function defaultjsOnDeActivate              () { return null; }
        function defaultjsOnBeforeCopy              () { return null; }
        function defaultjsOnBeforeCut               () { return null; }
        function defaultjsOnBeforeDeactivate        () { return null; }
        function defaultjsOnBeforeEditfocus         () { return null; }
        function defaultjsOnBeforePaste             () { return null; }
        function defaultjsOnBlur                    () { return null; }
        function defaultjsOnChange                  () { return null; }
        function defaultjsOnClick                   () { return null; }
        function defaultjsOnContextMenu             () { return null; }
        function defaultjsOnControlSelect           () { return null; }
        function defaultjsOnCopy                    () { return null; }
        function defaultjsOnCut                     () { return null; }
        function defaultjsOnDblClick                () { return null; }
        function defaultjsOnDrag                    () { return null; }
        function defaultjsOnDragEnter               () { return null; }
        function defaultjsOnDragLeave               () { return null; }
        function defaultjsOnDragOver                () { return null; }
        function defaultjsOnDragStart               () { return null; }
        function defaultjsOnDrop                    () { return null; }
        function defaultjsOnFilterChange            () { return null; }
        function defaultjsOnFocus                   () { return null; }
        function defaultjsOnHelp                    () { return null; }
        function defaultjsOnKeyDown                 () { return null; }
        function defaultjsOnKeyPress                () { return null; }
        function defaultjsOnKeyUp                   () { return null; }
        function defaultjsOnLoseCapture             () { return null; }
        function defaultjsOnMouseDown               () { return null; }
        function defaultjsOnMouseUp                 () { return null; }
        function defaultjsOnMouseEnter              () { return null; }
        function defaultjsOnMouseLeave              () { return null; }
        function defaultjsOnMouseMove               () { return null; }
        function defaultjsOnMouseOut                () { return null; }
        function defaultjsOnMouseOver               () { return null; }
        function defaultjsOnPaste                   () { return null; }
        function defaultjsOnPropertyChange          () { return null; }
        function defaultjsOnReadyStateChange        () { return null; }
        function defaultjsOnResize                  () { return null; }
        function defaultjsOnResizeEnd               () { return null; }
        function defaultjsOnResizeStart             () { return null; }
        function defaultjsOnSelectStart             () { return null; }

        protected $_style="";

        /**
        * Use this property to attach a css style to the control.
        *
        * CSS style to be used when rendering the component, the style must be
        * included in a .css file referenced by the Page component. You can use
        * OnShowHeader to write the code to include the stylesheet or use the
        * StyleSheet component. Using the StyleSheet component you will be able
        * to see the style rendered in design-time, and this property will be shown
        * as a drop-down with the styles available in the linked stylesheet
        *
        * @see StyleSheet
        *
        * @return string
        */
        function readStyle() { return $this->_style; }
        function writeStyle($value) { $this->_style=$value; }
        function defaultStyle() { return ""; }

        protected $_adjusttolayout="0";

        /**
        * A helper property for Layouts to know if the component should adjust to the layout or not
        *
        * If true, the control should adjust to the selected layout. This property
        * can be used by a Layout component to render the component it contains.
        *
        * @see FocusControl::readLayout()
        *
        * @return boolean
        */
        function readAdjustToLayout() { return $this->_adjusttolayout; }
        function writeAdjustToLayout($value) { $this->_adjusttolayout=$value; }
        function defaultAdjustToLayout() { return "0"; }

    protected $_autosize=0;

    /**
    * Determines if the control is going to adjust itself to the parent size
    *
    * This property can be used by component developers to generate code that
    * adjusts to the size of the parent cell/div/etc. It's useful for templated
    * forms.
    *
    * @return boolean
    */
    function readAutosize() { return $this->_autosize; }
    function writeAutosize($value) { $this->_autosize=$value; }
    function defaultAutosize() { return 0; }


    protected $_divwrap=1;

    /**
    * Specifies if the control must be wrapped by a div or not
    *
    * Use this property to specify if the control must be wrapped by a div
    * or not. The usage of this property is leave to the component developer discretion.
    *
    * @return boolean
    */
    function readDivWrap() { return $this->_divwrap; }
    function writeDivWrap($value) { $this->_divwrap=$value; }
    function defaultDivWrap() { return 1; }



        protected $_attributes=array();

        /**
        * A property for tag based controls to allow component user to add attributes
        * to the tag
        *
        * This is an array property you can use to specify, for tag based controls,
        * some extra attributes to be included in the tag generation.
        *
        * @return array
        */
        function readAttributes() { return $this->_attributes; }
        function writeAttributes($value) { $this->_attributes=$value; }
        function defaultAttributes() { return array(); }

        protected $_hidden=0;

        /**
        * This property, when true, allows controls to generate all code, but
        * don't show the control on the browser.
        *
        * You can use this property to specify the control should not be shown
        * on the browser, but the code for it will be generated, this is useful
        * if you want to use javascript code to make the control visible.
        *
        * @see readVisible()
        *
        * @return boolean
        */
        function readHidden() { return $this->_hidden; }
        function writeHidden($value) { $this->_hidden=$value; }
        function defaultHidden() { return 0; }

        /**
        * Normalizes the css style class name
        *
        * Return the normalized CSS style without the starting dot if any.
        *
        * @see readStyle()
        *
        * @return string
        */
        function readStyleClass()
        {
            if ($this->_style!="")
            {
                $res=$this->_style;
                if ($res[0]=='.') $res=substr($res,1);
                return($res);
            }
            else return("");
        }



        /**
         * Constructor for the class
         *
         * @param $aowner The owner component for this class
         *
         */
        function __construct($aowner=null)
        {
                $this->_font=new Font();
                $this->_font->_control=$this;

                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function loaded()
        {
                parent::loaded();
                $this->writePopupMenu($this->_popupmenu);
        }

        /**
         * Determines whether a control can be shown or not.
         *
         * A control can be shown if it has no parent and its Visible property is true.
         *
         * If it has a parent:
         *
         * -if parent has Layer handling properties, checks Visible property if Parent can be shown and Layer matches with the Activelayer.
         *
         * -else, checks the visible property and if the parent can be shown.
         *
         * @see getVisible(), readParent()
         *
         * @return boolean True if the control can be shown, false otherwise
         */
        function canShow()
        {
                if ($this->_parent!=null)
                {
                        //TODO: This must check for parents having ActiveLayer property, not only CustomPanel descendants
                        if ($this->_parent->inheritsFrom('CustomPanel'))
                        {
                                return(($this->_visible) && ($this->_parent->canShow()) && ((string)$this->_layer==(string)$this->_parent->ActiveLayer));
                        }
                        else
                        {
                                return(($this->_visible) && ($this->_parent->canShow()));
                        }
                }
                else return($this->_visible);
        }

        /**
         * Returns a string with all assigned javascript events, ready to be added to a control tag.
         *
         * Returns assigned javascript events as attributes for the tag. This function
         * is useful to get the tags to assign javascript events to the right code.
         *
         * @see dumpJsEvents(),
         *
         * @return string
         */
        function readJsEvents()
        {
                $result="";

                if ($this->_jsonactivate!=null)  { $event=$this->_jsonactivate;  $result.=" onactivate=\"return $event(event)\" "; }
                if ($this->_jsondeactivate!=null)  { $event=$this->_jsondeactivate;  $result.=" ondeactivate=\"return $event(event)\" "; }
                if ($this->_jsonbeforecopy!=null)  { $event=$this->_jsonbeforecopy;  $result.=" onbeforecopy=\"return $event(event)\" "; }
                if ($this->_jsonbeforecut!=null)  { $event=$this->_jsonbeforecut;  $result.=" onbeforecut=\"return $event(event)\" "; }
                if ($this->_jsonbeforedeactivate!=null)  { $event=$this->_jsonbeforedeactivate;  $result.=" onbeforedeactivate=\"return $event(event)\" "; }
                if ($this->_jsonbeforeeditfocus!=null)  { $event=$this->_jsonbeforeeditfocus;  $result.=" onbeforeeditfocus=\"return $event(event)\" "; }
                if ($this->_jsonbeforepaste!=null)  { $event=$this->_jsonbeforepaste;  $result.=" onbeforepaste=\"return $event(event)\" "; }
                if ($this->_jsonblur!=null)  { $event=$this->_jsonblur;  $result.=" onblur=\"return $event(event)\" "; }
                if ($this->_jsonchange!=null)  { $event=$this->_jsonchange;  $result.=" onchange=\"return $event(event)\" "; }
                if ($this->_jsonclick!=null)  { $event=$this->_jsonclick;  $result.=" onclick=\"return $event(event)\" "; }
                if ($this->_jsoncontextmenu!=null)  { $event=$this->_jsoncontextmenu;  $result.=" oncontextmenu=\"return $event(event)\" "; }
                if ($this->_jsoncontrolselect!=null)  { $event=$this->_jsoncontrolselect;  $result.=" oncontrolselect=\"return $event(event)\" "; }
                if ($this->_jsoncopy!=null)  { $event=$this->_jsoncopy;  $result.=" oncopy=\"return $event(event)\" "; }
                if ($this->_jsoncut!=null)  { $event=$this->_jsoncut;  $result.=" oncut=\"return $event(event)\" "; }
                if ($this->_jsondblclick!=null)  { $event=$this->_jsondblclick;  $result.=" ondblclick=\"return $event(event)\" "; }
                if ($this->_jsondrag!=null)  { $event=$this->_jsondrag;  $result.=" ondrag=\"return $event(event)\" "; }
                if ($this->_jsondragenter!=null)  { $event=$this->_jsondragenter;  $result.=" ondragenter=\"return $event(event)\" "; }
                if ($this->_jsondragleave!=null)  { $event=$this->_jsondragleave;  $result.=" ondragleave=\"return $event(event)\" "; }
                if ($this->_jsondragover!=null)  { $event=$this->_jsondragover;  $result.=" ondragover=\"return $event(event)\" "; }
                if ($this->_jsondragstart!=null)  { $event=$this->_jsondragstart;  $result.=" ondragstart=\"return $event(event)\" "; }
                if ($this->_jsondrop!=null)  { $event=$this->_jsondrop;  $result.=" ondrop=\"return $event(event)\" "; }
                if ($this->_jsonfilterchange!=null)  { $event=$this->_jsonfilterchange;  $result.=" onfilterchange=\"return $event(event)\" "; }
                if ($this->_jsonfocus!=null)  { $event=$this->_jsonfocus;  $result.=" onfocus=\"return $event(event)\" "; }
                if ($this->_jsonhelp!=null)  { $event=$this->_jsonhelp;  $result.=" onhelp=\"return $event(event)\" "; }
                if ($this->_jsonkeydown!=null)  { $event=$this->_jsonkeydown;  $result.=" onkeydown=\"return $event(event)\" "; }
                if ($this->_jsonkeypress!=null)  { $event=$this->_jsonkeypress;  $result.=" onkeypress=\"return $event(event)\" "; }
                if ($this->_jsonkeyup!=null)  { $event=$this->_jsonkeyup;  $result.=" onkeyup=\"return $event(event)\" "; }
                if ($this->_jsonlosecapture!=null)  { $event=$this->_jsonlosecapture;  $result.=" onlosecapture=\"return $event(event)\" "; }
                if ($this->_jsonmousedown!=null)  { $event=$this->_jsonmousedown;  $result.=" onmousedown=\"return $event(event)\" "; }
                // Adds the popup mouse up handler. (The real mouseup event is wrapped by this event.)
                if ($this->_enabled == 1 && $this->_popupmenu != null && !$this->inheritsFrom("QWidget"))
                {
                        $event="{$this->_name}Popup";  $result.=" onmouseup=\"return $event(event)\" ";
                }
                else
                {
                        if ($this->_jsonmouseup!=null)  { $event=$this->_jsonmouseup;  $result.=" onmouseup=\"return $event(event)\" "; }
                }
                if ($this->_jsonmouseenter!=null)  { $event=$this->_jsonmouseenter;  $result.=" onmouseenter=\"return $event(event)\" "; }
                if ($this->_jsonmouseleave!=null)  { $event=$this->_jsonmouseleave;  $result.=" onmouseleave=\"return $event(event)\" "; }
                if ($this->_jsonmousemove!=null)  { $event=$this->_jsonmousemove;  $result.=" onmousemove=\"return $event(event)\" "; }
                if ($this->_jsonmouseout!=null)  { $event=$this->_jsonmouseout;  $result.=" onmouseout=\"return $event(event)\" "; }
                if ($this->_jsonmouseover!=null)  { $event=$this->_jsonmouseover;  $result.=" onmouseover=\"return $event(event)\" "; }
                if ($this->_jsonpaste!=null)  { $event=$this->_jsonpaste;  $result.=" onpaste=\"return $event(event)\" "; }
                if ($this->_jsonpropertychange!=null)  { $event=$this->_jsonpropertychange;  $result.=" onpropertychange=\"return $event(event)\" "; }
                if ($this->_jsonreadystatechange!=null)  { $event=$this->_jsonreadystatechange;  $result.=" onreadystatechange=\"return $event(event)\" "; }
                if ($this->_jsonresize!=null)  { $event=$this->_jsonresize;  $result.=" onresize=\"return $event(event)\" "; }
                if ($this->_jsonresizeend!=null)  { $event=$this->_jsonresizeend;  $result.=" onresizeend=\"return $event(event)\" "; }
                if ($this->_jsonresizestart!=null)  { $event=$this->_jsonresizestart;  $result.=" onresizestart=\"return $event(event)\" "; }
                if ($this->_jsonselectstart!=null)  { $event=$this->_jsonselectstart;  $result.=" onselectstart=\"return $event(event)\" "; }

                return($result);
        }

        /**
         * Dumps all assigned javascript events code.
         *
         * Dumps Javascript events. This method is called by the Page component
         * to dump in the <head> section of the document all the javascript
         * functions containing the code the user has written. Control class dumps
         * the standard HTML javascript events. You can override it to dump yours.
         *
         * Don't forget to call the parent:: method if you want the standard ones
         * to get dumped.
         *
         * @see dumpJSEvent()
         *
         */
        function dumpJsEvents()
        {
                $this->dumpJSEvent($this->_jsonactivate);
                $this->dumpJSEvent($this->_jsondeactivate);
                $this->dumpJSEvent($this->_jsonbeforecopy);
                $this->dumpJSEvent($this->_jsonbeforecut);
                $this->dumpJSEvent($this->_jsonbeforedeactivate);
                $this->dumpJSEvent($this->_jsonbeforeeditfocus);
                $this->dumpJSEvent($this->_jsonbeforepaste);
                $this->dumpJSEvent($this->_jsonblur);
                $this->dumpJSEvent($this->_jsonchange);
                $this->dumpJSEvent($this->_jsonclick);
                $this->dumpJSEvent($this->_jsoncontextmenu);
                $this->dumpJSEvent($this->_jsoncontrolselect);
                $this->dumpJSEvent($this->_jsoncopy);
                $this->dumpJSEvent($this->_jsoncut);
                $this->dumpJSEvent($this->_jsondblclick);
                $this->dumpJSEvent($this->_jsondrag);
                $this->dumpJSEvent($this->_jsondragenter);
                $this->dumpJSEvent($this->_jsondragleave);
                $this->dumpJSEvent($this->_jsondragover);
                $this->dumpJSEvent($this->_jsondragstart);
                $this->dumpJSEvent($this->_jsondrop);
                $this->dumpJSEvent($this->_jsonfilterchange);
                $this->dumpJSEvent($this->_jsonfocus);
                $this->dumpJSEvent($this->_jsonhelp);
                $this->dumpJSEvent($this->_jsonkeydown);
                $this->dumpJSEvent($this->_jsonkeypress);
                $this->dumpJSEvent($this->_jsonkeyup);
                $this->dumpJSEvent($this->_jsonlosecapture);
                $this->dumpJSEvent($this->_jsonmousedown);
                $this->dumpJSEvent($this->_jsonmouseup);
                $this->dumpJSEvent($this->_jsonmouseenter);
                $this->dumpJSEvent($this->_jsonmouseleave);
                $this->dumpJSEvent($this->_jsonmousemove);
                $this->dumpJSEvent($this->_jsonmouseout);
                $this->dumpJSEvent($this->_jsonmouseover);
                $this->dumpJSEvent($this->_jsonpaste);
                $this->dumpJSEvent($this->_jsonpropertychange);
                $this->dumpJSEvent($this->_jsonreadystatechange);
                $this->dumpJSEvent($this->_jsonresize);
                $this->dumpJSEvent($this->_jsonresizeend);
                $this->dumpJSEvent($this->_jsonresizestart);
                $this->dumpJSEvent($this->_jsonselectstart);
        }

        /**
         * Dumps all required javascript code for the component.
         *
         * Dumps Javascript code required for this component to work. This instance
         * includes a call to dumpJSEvents to create all the javascript functions
         * required to make javascript events to work.
         *
         * This method is also responsible for dumping the javascript code to make the
         * Popup property work.
         *
         * If you are a component developer, this is the right method to override to
         * dump all javascript your component needs.
         *
         * @see dumpJsEvents(), readEnabled()
         *
         */
        function dumpJavascript()
        {
                $this->dumpJsEvents();

                if ($this->_enabled == 1 && $this->_popupmenu != null && !$this->inheritsFrom("QWidget"))
                {
                        echo "function {$this->_name}Popup(event)\n";
                        echo "{\n";
                        // Adds a wrapper so the mouseup event still gets called.
                        if ($this->_jsonmouseup != null)
                        {
                                // Verifies it really exists.
                                echo "  if (typeof($this->_jsonmouseup) == 'function') $this->_jsonmouseup(event);\n";
                        }
                        echo "  var rightclick;\n";
                        echo "  if (!event) var event = window.event;\n";
                        echo "  if (event.which) rightclick = (event.which == 3);\n";
                        echo "  else if (event.button) rightclick = (event.button == 2);\n";

                        echo "  if (rightclick)\n";
                        echo "  {\n";
                        echo "     Show{$this->_popupmenu->Name}(event, 0);\n";
                        echo "  }\n";

                        // Allows the event to be handled by others.
                        echo "  return true;\n";
                        echo "}\n";
                }
        }

        /**
        * Dumps the component header code.
        *
        * This method is called by the Page component to dump the code for each
        * component that requires to be on the header of the HTML document.
        *
        * @see Control::readControlState()
        *
        */
        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();

                // Dumps only the style sheet at design-time if the style sheet is used by the sub-classed control.
                if (($this->ControlState & csDesigning) == csDesigning && isset($this->_controlstyle['csRenderAlso']) && $this->_controlstyle['csRenderAlso'] == 'StyleSheet')
                {
                        if ($this->owner!=null)
                        {
                                $components=$this->owner->components->items;
                                reset($components);
                                while (list($k,$v)=each($components))
                                {
                                        if ($v->inheritsFrom('StyleSheet'))
                                        {
                                            $v->dumpHeaderCode();
                                        }
                                }
                        }
                }
        }

        /**
        * If control has any Hint, then returns the hint in attribute format for the tag.
        *
        * This function returns the attribute for the hint that can be included
        * in any tag. The attribute's name is "title".

        * If the hint is defined and can be shown a is string with the attribute, otherwise an empty string.
        *
        * @see readShowHint()
        *
        * @return string
        */
        protected function getHintAttribute()
        {
                $hint = "";
                //TODO: Check here for alt also
                if ($this->_hint != "")
                {
                        $hintspecial = htmlspecialchars($this->_hint, ENT_QUOTES);
                        if ($this->_showhint)
                        {
                                $hint = "title=\"$hintspecial\"";
                        }
                }
                return $hint;
        }


        function beginCache($type)
        {
        	$result=false;
			if (($this->ControlState & csDesigning) != csDesigning)
            {
        	if ($this->_cached==true)
            {
            	if ($this->owner!=null)
            	{
                	if ($this->owner->inheritsFrom('Page'))
                    {
                    	if ($this->owner->Cache!=null)
                    	{
                        	return($this->owner->Cache->startCache($this, $type));
                        }
                    }
                    else if ($this->inheritsFrom('Page'))
                    {
                    	if ($this->Cache!=null)
                    	{
                        	return($this->Cache->startCache($this, $type));
                        }
                    }
                }
            }
            }
            return($result);
        }

        function endCache()
        {
			if (($this->ControlState & csDesigning) != csDesigning)
            {
        	if ($this->_cached==true)
            {
            	if ($this->owner!=null)
            	{
                	if ($this->owner->inheritsFrom('Page'))
                    {
                    	if ($this->owner->Cache!=null)
                    	{
                        	$this->owner->Cache->endCache();
                        }
                    }
                    else if ($this->inheritsFrom('Page'))
                    {
                    	if ($this->Cache!=null)
                    	{
                        	$this->Cache->endCache();
                        }
                    }
                }
            }
            }
        }

        /**
         * Dumps the code for the control to the output.
         *
         * Shows control contents. You can use this method to show the contents of
         * the control, optionally, by setting $return_contents to true. You can get the
         * contents of the control returned  instead of having it dumped to the output.
         *
         * This method also checks if the global var has $output_enabled. You can globally
         * disable output of controls by setting that var to false.
         *
         * This method is also responsible to call beforeshow and aftershow events
         *
         * @see $output_enabled, callEvent(), readOnBeforeShow(), dumpContents(), readOnAfterShow()
         *
         * @param boolean $return_contents return contents as string or dumps to output
         * @return mixed If $return_contents is true, it will return the control contents, void otherwise
         */
        function show($return_contents=false)
        {
                acl_addresource($this);
                if (!$this->inheritsFrom('Page'))
                {
                  if (!acl_isallowed($this->className().'::'.$this->Name, "Show")) return;
                }

                global $output_enabled;

                if ($output_enabled)
                {
                        $this->callEvent('onbeforeshow',array());
                        //A call to show, will dump out control code
                        if ($return_contents) ob_start();

                        if (!$this->beginCache('contents'))
                        {
	                        $this->dumpContents();
                        	$this->endCache();
                        }

                        if ($return_contents)
                        {
                                $contents=ob_get_contents();
                                ob_end_clean();
                        }
                        $this->callEvent('onaftershow',array());

                        if ($return_contents)
                        {
                                return($contents);
                        }
                }
        }

    protected $_cached="0";

    function getCached() { return $this->_cached; }
    function setCached($value) { $this->_cached=$value; }
    function defaultCached() { return "0"; }



        /**
         * Dumps all children components.
         *
         * This method iterates through all the children list,
         * dumping all of them to the output using the show method.
         *
         * @see readParent()
         *
         */
        function dumpChildren()
        {

        }

        /**
         * Dumps the control contents.
         *
         * Inherit and fill this method with the code your control must generate.
         * This is one of the main methods in the VCL for PHP
         * as it is responsible for generating the code for the controls. When developing
         * components, you should override this method and write your component code here.
         *
         * <code>
         * <?php
         *      function dumpContents()
         *      {
         *          echo "<table width=\"100%\"><tr><td>Hello, my component!</td></tr></table>";
         *      }
         * ?>
         * </code>
         *
         * @see show(), getVisible()
         *
         */
        function dumpContents()
        {
                //Inherits and fills this method to show your control.
        }


        /**
        * Adds or replaces the JS event attribute with the wrapper.
        *
        * The wrapper is used to notify the PHP script that an event occured. The
        * script then may fire an event itself (for example OnClick of a button).
        *
        * @see getJSWrapperFunctionName(), readJSWrapperSubmitEventValue(), readJSWrapperSubmitEventValue()
        *
        *
        * @param string $events A string that is empty or contains already
        *                       existing JS event-handlers. This string passed
        *                       by reference.
        * @param string $event String representation of the event (ex. $this->_onclick;)
        * @param string $jsEvent String representation of the JS event (ex. $this->_jsonclick;)
        * @param string $jsEventAttr Name of attribute for the JS event (ex. "onclick")
        */
        protected function addJSWrapperToEvents(&$events, $event, $jsEvent, $jsEventAttr)
        {
                if ($event != null)
                {
                        $wrapperEvent = $this->getJSWrapperFunctionName($event);
                        $submitEventValue = $this->readJSWrapperSubmitEventValue($event);
                        $hiddenfield = $this->readJSWrapperHiddenFieldName();
//                        $hiddenfield = ($this->owner != null) ? "document.forms[0].$hiddenfield" : "null";
                        $hiddenfield = ($this->owner != null) ? "findObj('$hiddenfield')" : "null";
                        if ($jsEvent != null)
                        {
                                $events = str_replace("$jsEventAttr=\"return $jsEvent(event)\"",
                                                      "$jsEventAttr=\"return $wrapperEvent(event, $hiddenfield, '$submitEventValue', $jsEvent)\"",
                                                      $events);
                        }
                        else
                        {
                                $events .= " $jsEventAttr=\"return $wrapperEvent(event, $hiddenfield, '$submitEventValue')\" ";
                        }
                }
        }

        /**
        * Gets the function name of a JS event wrapper.
        *
        * This method can be used to
        * generate a normalized function name for a wrapper. Wrappers are often used
        * to make a process before or after a javascript event is fired.
        *
        * @see addJSWrapperToEvents(), readJSWrapperSubmitEventValue(), readJSWrapperSubmitEventValue()
        *
        * @param string $event String representation of the event (ex. $this->_onclick;)
        * @return string Name of the function
        */
        protected function getJSWrapperFunctionName($event)
        {
                $res = ($event != null) ? $event."Wrapper" : "";
                return $res;
        }

        /**
        * JS wrapper function that forwards a JS event to the PHP script by
        * submitting the HTML form.
        *
        * It is the responsiblity of the component to add this function to the
        * <javascript> section in the HTML header. Usually this is done in the
        * dumpJavascript() function of the component.
        *
        *
        * @see addJSWrapperToEvents(), readJSWrapperSubmitEventValue(), readJSWrapperSubmitEventValue()
        *
        * @param string $event String representation of the event (ex. $this->_onclick;)
        * @return string Returns the whole JS wrapper function for the $event.
        */
        protected function getJSWrapperFunction($event)
        {
                $res = "";
                if ($event != null)
                {
                        $funcName = $this->getJSWrapperFunctionName($event);

                        $res .= "function $funcName(event, hiddenfield, submitvalue, wrappedfunc)\n";
                        $res .= "{\n\n";
                        $res .= "var event = event || window.event;\n";

                        $res .= "submit1=true;\n";
                        $res .= "submit2=true;\n";

                        // Calls the user defined JS function first if it exists.
                        $res .= "if (typeof(wrappedfunc) == 'function') submit1=wrappedfunc(event);\n";

                        // Sets the hidden field value so later you will know which event was fired.
                        $res .= "hiddenfield.value = submitvalue;\n";

                        $res .= "form = hiddenfield.form;\n";

                        // Submits the form.
                        $res .= "if ((form) && (form.onsubmit) && (typeof(form.onsubmit) == 'function')) submit2=form.onsubmit();\n";
                        $res .= "if ((submit1) && (submit2)) form.submit();\n";

                        // Makes sure the event handler of the element does not handle
                        // the JS event again. (This might happen with a submit button.)
                        $res .= "return false;\n";

                        $res .= "\n}\n";
                        $res .= "\n";
                }
                return $res;
        }

        /**
        * Gets the name of the hidden field used to submit the value for the event
        * that was fired.
        *
        * There should be one hidden field for each component that can forward
        * JS events to the PHP script. It is the responsiblity of the component to
        * add this field.
        *
        * @see addJSWrapperToEvents(), readJSWrapperSubmitEventValue(), readJSWrapperSubmitEventValue()
        *
        * @return string Name of the hidden field
        */
        public function readJSWrapperHiddenFieldName()
        {
                return "{$this->_name}SubmitEvent";
        }

        /**
        * Sets the value to the hidden field when the specific JS event was fired and
        * the wrapper function was called.
        *
        * See getJSWrapperFunction()where the value gets set to the hidden field.
        * It is also used in the component to check if the defined $event has been
        * fired on the page. This should be done in the init() function of the
        * component.
        *
        *
        * @see addJSWrapperToEvents(), readJSWrapperSubmitEventValue(), readJSWrapperHiddenFieldName()
        *
        * @param string $event String representation of the event (ex. $this->_onclick;)
        * @return string The value that will be set in the hidden input.
        */
        public function readJSWrapperSubmitEventValue($event)
        {
                return "{$this->_name}_$event";
        }

        /**
        * Performs a parent reset if true.
        * @return boolean
        */
        function readDoParentReset() { return $this->_doparentreset; }

        /**
         * Specifies a text string that identifies the control to the user.
         *
         * Use Caption to specify the text string that labels the control.
         *
         * Caption property which is defined in the Control class. If used by the
         * control, is in sync with the Name when the control is first dropped
         * on the designer. The usage of this property depends on the component,
         * for example, Caption for Button components is the text inside the button
         * while for Page components, is the title of the HTML document.
         *
         * Note: Controls that display text use either the Caption property or the
         * Text property to specify the text value. Which property is used depends on the
         * type of control. In general, Caption is used for text that appears as a window title
         * or label, while Text is used for text that appears as the content of a control.
         *
         * @return string
         */
        protected function readCaption() { return $this->_caption; }
        protected function writeCaption($value) { $this->_caption=$value; }
        function defaultCaption() { return ""; }

        /**
         * Specifies the main color of the control.
         *
         * Color property, defined in Control class, usually define the main color
         * for the component, it's responsability of the component developer to
         * use the property to generate the appropiate code and reflect the color setting.
         * This property follows the HTML/CSS color specification, for example:
         * #FF0000 -> red color or can also be "red"
         *
         * If a control's ParentColor property is true, then changing the Color
         * property of the control's parent automatically changes the Color property of the
         * control. When the value of the Color property is changed, the control's ParentColor
         * property is automatically set to false.
         *
         * @link http://www.w3.org/TR/REC-CSS2/syndata.html#color-units
         * @see readParentColor()
         * @example ParentProperties/parentproperties.php How parent properties work
         *
         * @return string
         */
        protected function readColor() { return $this->_color;     }
        protected function writeColor($value)
        {
                if ($this->_color!=$value)
                {
                        $this->_color=$value;
                        if (($this->_controlstate & csLoading) != csLoading)
                        {
                                // Updates the children.
                                if ($this->methodExists("updateChildrenColors"))
                                {
                                        $this->updateChildrenColors();
                                }

                                // Checks if the ParentColor property can be reset.
                                if ($this->_doparentreset)
                                {
                                        $this->_parentcolor=0;
                                }
                        }
                }
        }
        function defaultColor() { return "";     }

        /**
        * Controls whether the control responds to mouse, keyboard, and timer events.
        *
        * Use Enabled to change the availability of the control to the user. To disable a
        * control, set Enabled to false. Disabled controls appear dimmed. If Enabled is false,
        * the control ignores mouse, keyboard, and timer events.
        *
        * To re-enable a control, set Enabled to true. The control is no longer dimmed, and the
        * user can use the control.
        *
        * Disabled controls must not react to user interaction and must show a different color or aspect
        * to specify that to the user. Do not confuse this with ReadOnly properties,
        * as ReadOnly controls may allow the user to copy information. Disabled controls
        * do not allow any operations with it.
        *
        * @see readVisible()
        *
        * @return boolean
        */
        protected function readEnabled() { return $this->_enabled; }
        protected function writeEnabled($value) { $this->_enabled=$value; }
        function defaultEnabled() { return 1; }

        /**
        * Identifies the pop-up menu associated with the control.
        *
        * Assign a value to PopupMenu to make a pop-up menu appear when the user
        * selects the control and clicks the right mouse button.
        *
        * The value for this property must be a PopupMenu component. If you are working
        * on the IDE you will get a drop-down on the Object Inspector with valid values
        * for it.
        *
        * @return PopupMenu
        */
        protected function readPopupMenu() { return $this->_popupmenu; }
        protected function writePopupMenu($value) { $this->_popupmenu= $this->fixupProperty($value); }
        function defaultPopupmenu() { return null; }

        /**
        * Determines where a control looks for its color information.
        *
        * To have a control use the same color as its parent control,
        * set ParentColor to true. If ParentColor is false,
        * the control uses its own Color property.
        *
        * Set ParentColor to true for all controls in order to ensure that all the
        * controls on a form have a uniform appearance. For example, if ParentColor is
        * true for all controls in a form, changing the background color of the form
        * to gray causes all the controls on the form to also have a gray background.
        *
        * When the value of a control's Color property changes, ParentColor becomes false automatically.
        *
        * @see readColor()
        * @example ParentProperties/parentproperties.php How parent properties work
        *
        * @return boolean
        */
        protected function readParentColor() { return $this->_parentcolor; }
        protected function writeParentColor($value)
        {
                if ($this->_parentcolor!=$value && $this->_doparentreset)
                {
                        $this->_parentcolor=$value;
                        // Only changes the color if parentcolor is set to true;
                        // otherwise leaves it as it is.
                        if ($this->_parentcolor == 1)
                        {
                                if ($this->_parent!=null)
                                {
                                        // Sets the color through writeColor() so child controls are also updated.
                                        $this->writeColor($this->_parent->_color);
                                }
                                else
                                {
                                        $this->_color="";
                                }
                                //Set again the value, as writeColor may change it
                                $this->_parentcolor=$value;
                        }
                }
        }
        function defaultParentColor() { return true;     }

        /**
        * Determines the Font to be used when generating this control.
        *
        * This property is an object property, so you can individually set specific
        * attributes for it, for example, Font->Color.
        *
        * In the IDE, this property shows a list of all properties of Font class so you
        * can set them individually
        *
        * Checks the Style property also, as that property also influences the aspect of the
        * Control.
        *
        * @see readParentFont()
        * @example ParentProperties/parentproperties.php How parent properties work
        *
        * @return Font
        */
        protected function readFont() { return $this->_font;       }
        protected function writeFont($value)
        {
                if (is_object($value))
                {
                        $this->_font=$value;

                        if (($this->ControlState & csLoading) != csLoading)
                        {
                                // Updates the children.
                                if ($this->methodExists("updateChildrenFonts"))
                                {
                                        $this->updateChildrenFonts();
                                }

                                // Checks if the ParentFont property can be reset.
                                if ($this->_doparentreset)
                                {
                                        $this->_parentfont=0;
                                }
                        }
                }
        }

        /**
        * Specifies if this control is a Layer instead of being integrated into the document.
        *
        * If true, control will be generated into a div tag and won't visible when the
        * application is executed. You will need to use Javascript events to show it.
        *
        * This is useful for creating hover areas. For example, on a Panel containing controls,
        * if IsLayer is true, you can write javascript code on the OnMouseOver javascript event
        * of a Button to show that layer so you get a nice effect.
        *
        * @see readVisible()
        *
        * @return boolean
        */
        protected function readIsLayer() { return $this->_islayer; }
        protected function writeIsLayer($value) { $this->_islayer=$value; }
        function defaultIsLayer() { return 0; }

        /**
        * Determines where a control looks for its font information.
        *
        * To have a control use the same font as its parent control,
        * set ParentFont to true. If ParentFont is false,
        * the control uses its own Font property.
        *
        * Many controls default ParentFont to true so that all the controls in a
        * form or other container present a uniform appearance. When the value of a
        * control's Font property changes, ParentFont becomes false automatically.
        *
        * When ParentFont is true for a form, the form uses the default font.
        *
        * @see readFont()
        * @example ParentProperties/parentproperties.php How parent properties work
        *
        * @return boolean
        */
        protected function readParentFont() { return $this->_parentfont; }
        protected function writeParentFont($value)
        {
                if ($this->_parentfont!=$value && $this->_doparentreset)
                {
                        $this->_parentfont=$value;

                        // Only changes the font if parentfont is set to true;
                        // otherwise leaves it as it is.
                        if ($this->_parentfont == 1)
                        {
                                if ($this->_parent!=null)
                                {
                                        // Does not allow you to update ParentFont while assigning
                                        // the parent font to this control. Otherwise, the
                                        // Font::modified() function will try to set $this->ParentFont to false
                                        // because the font has changed.
                                        $this->_doparentreset = false;

                                        $this->Parent->Font->assignTo($this->Font);

                                        $this->_parentfont = 1;
                                        $this->_doparentreset = true;
                                }
                        }
                }
        }
        function defaultParentFont() { return 1; }



        //Public properties

        protected $_layer=0;

        /**
        * Determines the layer in which this control is going to be rendered.
        *
        * This property must match with the ActiveLayer property of the parent control
        * for the component to be shown. It allows you to create stacked interfaces and
        * then switch the active stack by changing ActiveLayer.
        *
        * If parent control does not implement ActiveLayer, you do not have to worry about
        * this property.
        *
        * @see FocusControl::readActiveLayer()
        *
        * @return mixed
        */
        function getLayer() { return $this->_layer; }
        function setLayer($value) { $this->_layer=$value; }
        function defaultLayer() { return 0; }

        /**
        * Determines how the control aligns within its container (parent control).
        *
        * In the current implementation, is only used in a few controls. The goal is
        * to replicate the Align model present in VCL for Windows in VCL for PHP.
        *
        * @return enum
        */
        function readAlign() { return $this->_align;     }
        function writeAlign($value) { $this->_align=$value; }
        function defaultAlign() { return alNone;     }

        //TODO: Check if alignment,color and designcolor must be here or not
        /**
        * Specifies the alignment to be used by the control, it depends on the control
        * on how to use this property to show information.
        *
        * For example, Label uses it to align the text to show. If you are a component developer, you can
        * implement this property and use it to change the alignment of information.
        *
        * @return enum
        */
        function readAlignment() { return $this->_alignment;     }
        function writeAlignment($value) { $this->_alignment=$value; }
        function defaultAlignment() { return agNone;     }


        /**
        * Specifies a color to use by the control at design time.
        *
        * This is a property a component developer can use to simplify the design of controls. The goal is that
        * this property is only used at design-time. For example, Label control uses it to allow
        * you set a background color which will only be visible at design-time, so you can freely
        * set the Font color and still see the contents.
        *
        * @see readColor(), Control::readControlState()
        *
        * @return string
        */
        function readDesignColor() { return $this->_designcolor;     }
        function writeDesignColor($value) { $this->_designcolor=$value; }
        function defaultDesignColor() { return "";     }

        /**
        * Determines whether the control displays a Help Hint
        * when the mouse pointer rests momentarily on the control.
        *
        * The Help Hint is the value of the Hint property, which is displayed in a
        * box just beneath the control. Use ShowHint to determine whether a Help Hint appears for the control.
        *
        * To enable Help Hint for a particular control, the application ShowHint property
        * must be true and either:
        *
        * the controls own ShowHint property must be true, or
        *
        * the controls ParentShowHint property must be true and its parent's ShowHint property must be true.
        *
        * For example, imagine a check box within a group box. If the ShowHint property of the group box is
        * true and the ParentShowHint property of the check box is true, but the ShowHint property of the
        * check box is false, the check box still displays its Help Hint.
        *
        * Changing the ShowHint value automatically sets the ParentShowHint property to false.
        * Also checks the Hint property, which specifies the text to be shown.
        *
        * @see readHint(), readParentShowHint()
        * @example ParentProperties/parentproperties.php How parent properties work
        *
        * @return boolean
        */
        function readShowHint() { return $this->_showhint;     }
        function writeShowHint($value)
        {
                if ($value!=$this->_showhint)
                {
                        $this->_showhint=$value;

                        if (($this->ControlState & csLoading) != csLoading)
                        {
                                // Updates the children.
                                if ($this->methodExists("updateChildrenShowHints"))
                                {
                                        $this->updateChildrenShowHints();
                                }

                                if ($this->_doparentreset)
                                {
                                        $this->_parentshowhint=0;
                                }
                        }
                }

        }
        function defaultShowHint() { return 0;     }

        /**
        * Determines where a control looks to find out if its Help Hint
        * should be shown.
        *
        * Use ParentShowHint to ensure that all the controls on a form
        * either uniformly show their Help Hints or uniformly do not show them.
        *
        * If ParentShowHint is true, the control uses the ShowHint property
        * value of its parent. If ParentShowHint is false, the control uses
        * the value of its own ShowHint property.
        *
        * To provide Help Hints for only selected controls on a form,
        * set the ShowHint property to true for those controls that should have
        * Help Hints. ParentShowHint becomes false automatically.
        *
        * Note:   Enable or disable all Help Hints for the entire application
        *         using the ShowHint property of the application object.
        *
        * @see readShowHint()
        * @example ParentProperties/parentproperties.php How parent properties work
        *
        * @return boolean
        */
        function readParentShowHint() { return $this->_parentshowhint;     }
        function writeParentShowHint($value)
        {
                if ($this->_parentshowhint!=$value && $this->_doparentreset)
                {
                        $this->_parentshowhint=$value;
                        // Only changes the showhint if parentshowhint is set to true;
                        // otherwise leaves it as it is
                        if ($this->_parentshowhint == 1)
                        {
                                if ($this->_parent!=null)
                                {
                                        //$this->_showhint=$this->_parent->_showhint;
                                        $this->writeShowHint($this->_parent->_showhint);

                                        //Set again the value, as writeColor may change it
                                        $this->_parentshowhint=$value;
                                }
                                else
                                {
                                        $this->_showhint=0;
                                }
                        }
                }
        }
        function defaultParentShowHint() { return 1; }

        /**
        * Updates all properties that use the parent property as source.
        *
        * You don't need to call this method, is called by Control to update all properties
        * that have a Parent relative.
        *
        * These include ShowHint, Color and Font.
        *
        * @see readParentFont(), readParentShowHint(), readParentColor()
        * @example ParentProperties/parentproperties.php How parent properties work
        */
        function updateParentProperties()
        {
                if (($this->_controlstate & csLoading) != csLoading)
                {
                    $this->updateParentFont();
                    $this->updateParentColor();
                    $this->updateParentShowHint();
                }
        }

        /**
        * If ParentFont == true the parent's font is assigned to this control.
        *
        * @see readParentFont()
        * @example ParentProperties/parentproperties.php How parent properties work
        */
        function updateParentFont()
        {
                if ($this->_parent!=null)
                {
                        if (is_object($this->_parent))
                        {
                                $this->_doparentreset = false;
                                if ($this->_parentfont)
                                {
                                    $this->_parent->_font->assignTo($this->Font);
                                }
                                $this->_doparentreset = true;
                        }
                }
        }

        /**
        * If ParentColor == true the parent's color is assigned to this control.
        *
        * @see readParentColor()
        * @example ParentProperties/parentproperties.php How parent properties work
        */
        function updateParentColor()
        {
                if ($this->_parent!=null)
                {
                        if (is_object($this->_parent))
                        {
                                $this->_doparentreset = false;
                                if ($this->_parentcolor)
                                {
                                    $this->writeColor($this->_parent->_color);
                                }
                                $this->_doparentreset = true;
                        }
                }
        }

        /**
        * If ParentShowHint == true the parent's showhint is assigned to this control.
        *
        * @see readParentShowHint()
        * @example ParentProperties/parentproperties.php How parent properties work
        */
        function updateParentShowHint()
        {
                if ($this->_parent!=null)
                {
                        if (is_object($this->_parent))
                        {
                                $this->_doparentreset = false;
                                if ($this->_parentshowhint) $this->writeShowHint($this->_parent->_showhint);
                                $this->_doparentreset = true;
                        }
                }
        }


        /**
        * Determines whether the component appears on the browser.
        *
        * This property determines if the control is visible at run-time or not. Use it to
        * hide this control when generating the page. Note: The
        * behaviour can be different than in VCL for Windows. Since the control
        * uses javascript to get rendered, you might not be able to access it using javascript
        * as the code won't be generated.
        *
        * If you want to get a control code on the browser but not being visible, you should use javascript
        * to hide the control.
        *
        * @see readEnabled()
        *
        * @return boolean
        */
        function readVisible() { return $this->_visible; }
        function writeVisible($value) { $this->_visible=$value; }
        function defaultVisible() { return 1; }

        /**
        * Indicates the parent of the control.
        *
        * Use the Parent property to get or set the parent of this control.
        * The parent of a control is the control that contains the control.
        * For example, if an application includes three radio buttons in a group
        * box, the group box is the parent of the three radio buttons, and the
        * radio buttons are the child controls of the group box.
        *
        * To serve as a parent, a control must be an instance of a descendant of FocusControl.
        *
        * When creating a new control at runtime, assign a Parent property value for
        * the new control. Usually, this is a form, panel, group box, or some control
        * that is designed to contain another. Changing the parent of a control moves
        * the control on the browser so that it is displayed within the new parent.
        * When the parent control moves, the child moves with the parent.
        *
        * @see readOwner()
        * @example ParentProperties/parentproperties.php How parent properties work
        *
        * @return FocusControl
        */
        function readParent() { return $this->_parent; }
        function writeParent($value)
        {
                //Removes this component from the previous parent, if any.
                if (is_object($this->_parent)) $this->_parent->controls->remove($this);

                //Store
                $this->_parent=$value;

                //Adds this component to the parent's control list
                if (is_object($this->_parent))
                {
                        $this->_parent->controls->add($this);

                        $this->updateParentProperties();
                }
        }

        /**
        * An array which holds the control style, with settings for the IDE.
        *
        * Valid settings are:
        *
        * csAcceptsControls - Indicates to the IDE this control accepts children controls inside.
        *
        * csImageContent - Indicates to the IDE the content dumped by this component is image binary data.
        *
        * csSlowRedraw - Indicates to the IDE this component uses javascript and needs more time to get repainted.
        *
        * csVerySlowRedraw - Indicates to the IDE this component uses javascript and needs a lot more time to get repainted.
        *
        * csRenderOwner - Indicates to the IDE to render the Owner along with the control.
        *
        * csDesignEncoding - Indicates to the IDE to use a different encoding for the HTML produced by the component.
        *
        * csRenderAlso - Indicates to the IDE to also render components of a specific class.
        *
        * csTopOffset - Indicates to the IDE to capture the control image from different coordinates.
        *
        * csLeftOffset - Indicates to the IDE to capture the control image from different coordinates.
        *
        * csTemplateOutput - Indicates this component produces output valid for a template
        *
        * @return array
        */
        function readControlStyle() { return($this->_controlstyle); }
        function writeControlStyle($value)
        {
                $pieces=explode("=",$value);
                //$pieces=split("=",$value); //split is deprecated
                $this->_controlstyle[$pieces[0]]=$pieces[1];
        }

        //Here update parent-children properties, after all have been read from the session
        function init()
        {
                parent::init();
                        // Updates the parent properties after loading to ensure all properties
                        // were read from the stream and set.
                        // At the moment of writeParent(), the control does not have
                        // the properties initialized because it is the first property set.

                        // Updates all controls that accept controls inside themselves, but does not update the
                        // root (usually Page) control.
                        if ((isset($this->_controlstyle["csAcceptsControls"])) && ($this->_controlstyle["csAcceptsControls"] == "1" && $this->_parent != null))
                        {
                                // Checks if the parent control will not update this container;
                                // if $this->_parentcolor == 1, then it will be updated by the parent
                                // (and also all children) of this control.
                                if ($this->_parentcolor == 0)
                                {
                                        if ($this->methodExists("updateChildrenColors"))
                                        {
                                                // Checks if there are any children that have $this->_parentcolor == 1.
                                                // If there are, updates them.
                                                $this->updateChildrenColors();
                                        }
                                }
                                // // Checks if the ParentColor property can be reset.
                                if ($this->_parentfont == 0)
                                {
                                        if ($this->methodExists("updateChildrenFonts"))
                                        {
                                                $this->updateChildrenFonts();
                                        }
                                }
                                // // Checks if the ParentColor property can be reset.
                                if ($this->_parentshowhint == 0)
                                {
                                        if ($this->methodExists("updateChildrenShowHints"))
                                        {
                                                $this->updateChildrenShowHints();
                                        }
                                }
                        }
                        // Puts the Page (parent == null) at the end of the if-statement because it is called only once.
                        else if ($this->_parent == null && $this->methodExists("updateChildrenParentProperties"))
                        {
                                $this->updateChildrenParentProperties();
                        }
        }


        /**
        * Uses the Left property to determine where the left side of the control
        * begins, or to reposition the left side of the control.
        *
        * If the control is contained in another control, the Left and Top
        * properties are relative to the parent control. If the control is
        * contained directly by the form, the property values are relative to
        * the form. For forms, the value of the Left property is always 0.
        *
        * @see getTop()
        * @return int
        */
        function getLeft() { return $this->_left; }
        function setLeft($value) { $this->_left=$value; }
        function defaultLeft() { return 0; }

        /**
        * Uses Top to locate the top of the control, or reposition the control to
        * a different Y coordinate.
        *
        * The Top property, like the Left property,
        * is the position of the control relative to its container. Thus, if a
        * control is contained in a Panel, the Left and Top properties are
        * relative to the panel. If the control is contained directly by the
        * form, it is relative to the form. For forms, the value of the Top
        * property is always 0
        *
        * @see getLeft()
        * @return int
        */
        function getTop() { return $this->_top; }
        function setTop($value) { $this->_top=$value; }
        function defaultTop() { return 0; }

        /**
        * Specifies the horizontal size of the control or form in pixels.
        *
        * Use the Width property to read or change the width of the control.
        *
        * @see getHeight()
        * @return int
        */
        function getWidth() { return $this->_width; }
        function setWidth($value) { $this->_width=$value; }
        function defaultWidth() { return 0; }

        /**
        * Specifies the vertical size of the control or form in pixels.
        *
        * Use the Height property to read or change the height of the control.
        *
        * @see getWidth()
        * @return int
        */
        function getHeight() { return $this->_height; }
        function setHeight($value) { $this->_height=$value; }
        function defaultHeight() { return 0; }

        /**
        * Change the value of Cursor to provide feedback to the user when the
        * mouse pointer enters the control.
        *
        * The value of Cursor is one of the available cursors for the browser, in the IDE you have a drop-down
        * list to select a valid value for this property, which can be one of the following:
        *
        *
        * crPointer   - The cursor is a pointer that indicates a link.
        *
        * crCrossHair - A simple crosshair (e.g., short line segments resembling a "+" sign).
        *
        * crText      - Indicates text that may be selected. Often rendered as an I-bar.
        *
        * crWait      - Indicates that the program is busy and the user should wait. Often rendered as a watch or hourglass.
        *
        * crDefault   - The platform-dependent default cursor. Often rendered as an arrow.
        *
        * crHelp      - Help is available for the object under the cursor. Often rendered as a question mark or a balloon.
        *
        * crEResize   - Indicate that some edge is to be moved. For example, the 'se-resize' cursor is used when the movement starts from the south-east corner of the box.
        *
        * crNEResize  - Indicate that some edge is to be moved. For example, the 'se-resize' cursor is used when the movement starts from the south-east corner of the box.
        *
        * crNResize   - Indicate that some edge is to be moved. For example, the 'se-resize' cursor is used when the movement starts from the south-east corner of the box.
        *
        * crNWResize  - Indicate that some edge is to be moved. For example, the 'se-resize' cursor is used when the movement starts from the south-east corner of the box.
        *
        * crWResize   - Indicate that some edge is to be moved. For example, the 'se-resize' cursor is used when the movement starts from the south-east corner of the box.
        *
        * crSWResize  - Indicate that some edge is to be moved. For example, the 'se-resize' cursor is used when the movement starts from the south-east corner of the box.
        *
        * crSResize   - Indicate that some edge is to be moved. For example, the 'se-resize' cursor is used when the movement starts from the south-east corner of the box.
        *
        * crSEResize  - Indicate that some edge is to be moved. For example, the 'se-resize' cursor is used when the movement starts from the south-east corner of the box.
        *
        * crAuto      - The UA determines the cursor to display based on the current context.
        *
        * @return enum
        */
        function getCursor() { return $this->_cursor; }
        function setCursor($value) { $this->_cursor=$value; }
        function defaultCursor() { return ""; }

        /**
        * Specifies the text to show in a tooltip when the mouse is over the control for some time.
        *
        * Use the Hint property to provide a string of help text, either as a Help Hint
        * or as help text on a particular location such as a status bar.
        *
        * A Help Hint is a box containing help text that appears for a control when
        * the user moves the mouse pointer over the control and pauses momentarily.
        *
        * To set up Help Hints:
        *
        * Specify the Hint property of each control for which a Help Hint should appear.
        *
        * Set the ShowHint property of each appropriate control to true, or set the
        * ParentShowHint property of all controls to true and set the ShowHint
        * property of the form to true.
        *
        * @see readShowHint(), readParentShowHint()
        * @example ParentProperties/parentproperties.php How parent properties work
        * @return string
        */
        function getHint() { return $this->_hint; }
        function setHint($value) { $this->_hint=$value; }
        function defaultHint() { return ""; }


        /**
        * Fires the Event before showing the control.
        * @return mixed
        */
        function getOnBeforeShow() { return $this->_onbeforeshow; }
        function setOnBeforeShow($value) { $this->_onbeforeshow=$value; }
        function defaultOnBeforeShow() { return null; }

        /**
        * Fires the Event after showing the control.
        * @return mixed
        */
        function getOnAfterShow() { return $this->_onaftershow; }
        function setOnAfterShow($value) { $this->_onaftershow=$value; }
        function defaultOnAfterShow() { return null; }

        /**
        * Fires the Event at the same moment the control is shown. Some controls can
        * prevent the control from being shown when this event is attached.
        * @return mixed
        */
        function getOnShow() { return $this->_onshow; }
        function setOnShow($value) { $this->_onshow=$value; }
        function defaultOnShow() { return null; }
}

/**
 * Base class for controls with input focus.
 *
 * Inherit from this class if you expect your control to hold another controls as
 * it provides the Layout property, useful when generating the component code that contain
 * other controls.
 *
 */
class FocusControl extends Control
{
        protected $_layout=null;

        public    $controls;

        /**
        * If this control has any children that have ParentFont==true, then
        * this function will assign the same Font property to all children Font properties.
        * Note: This must be in FocusControl, not in Control, as it is here where the Controls property is defined.
        * @see updateChildrenColors(), updateChildrenShowHints(), updateChildrenParentProperties()
        */
        function updateChildrenFonts()
        {
                //Iterates through all child controls and assign the new font
                //to all that have ParentFont=true.
                reset($this->controls->items);
                while (list($k,$v) = each($this->controls->items))
                {
                        if ($v->ParentFont)
                        {
                                $v->updateParentFont();
                        }
                }
        }

        /**
        * Updates the colors for all the children if parentcolor is set.
        * @see updateChildrenFonts(), updateChildrenShowHints(), updateChildrenParentProperties()
        */
        function updateChildrenColors()
        {
                //Iterates through all child controls and assigns the new color
                //to all that have ParentColor=true.
                reset($this->controls->items);
                while (list($k,$v) = each($this->controls->items))
                {
                        if ($v->ParentColor)
                        {
                                $v->updateParentColor();
                        }
                }
        }

        /**
        * Updates the ShowHints properties for all children controls.
        * @see updateChildrenFonts(), updateChildrenColors(), updateChildrenParentProperties()
        */
        function updateChildrenShowHints()
        {
                //Iterates through all child controls and assigns the new showhint
                //to all that have ParentShowHint=true.
                reset($this->controls->items);
                while (list($k,$v) = each($this->controls->items))
                {
                        if ($v->ParentShowHint)
                        {
                                $v->updateParentShowHint();
                        }
                }
        }

        /**
        * Updates all necessary properties for any children that use property values from their parent.
        * Note: This must be in FocusControl, not in Control, as it is here where the Controls property is defined.
        * @see updateChildrenFonts(), updateChildrenColors(), updateChildrenShowHints()
        */
        function updateChildrenParentProperties()
        {
                //Iterates through all child controls and assigns the new font
                //to all that have ParentFont=true.
                reset($this->controls->items);
                while (list($k,$v) = each($this->controls->items))
                {
                        // First checks if it is really necessary to update the parent properties.
                        if ($v->ParentColor || $v->ParentFont || $v->ParentShowHint)
                        {
                                $v->updateParentProperties();
                        }
                }
        }


        function __construct($aowner=null)
        {
                //Creates the controls list.
                $this->controls=new Collection();

                //Calls inherited constructor.
                parent::__construct($aowner);

                $this->_layout=new Layout();
                $this->_layout->_control=$this;
        }

        /**
        * Returns the number of controls for which this control is the Parent.
        * Controls have a Controls property which is a Collection, and this method
        * returns the number of items on that list.
        *
        * @see $controls
        *
        * @return integer
        */
        function readControlCount() { return $this->controls->count(); }

        /**
        * Specifies the Layout this control uses to render its controls to the browser.
        * This property is a Layout object which uses the Controls property of the control
        * to dump components to the browser, depending on the type of Layout.
        *
        * @example Layouts/ColAndRowLayout/colandrowlayout.php Sample showing how to use a column and row layout
        * @example Layouts/ColAndRowLayout/colandrowlayout.xml.php Sample showing how to use a column and row layout (form)
        *
        * @return Layout
        */
        function readLayout() { return $this->_layout; }
        function writeLayout($value) { if (is_object($value)) $this->_layout=$value; }


        /**
        * Dumps all children iterating through the Controls property and calls the
        * show method of each one.
        * @see $controls
        *
        */
        function dumpChildren()
        {
                //Iterates through controls calling show for all of them.
                reset($this->controls->items);
                while (list($k,$v)=each($this->controls->items))
                {
                        $v->show();
                }

        }
}

/**
 * Base class for custom control.
 *
 * This class doesn't implement yet any property/method/event, we reserve this
 * stage in the class library to add more features in the future.
 *
 */
class CustomControl extends FocusControl
{
}

/**
 * Base class for controls with graphic capabilities.
 *
 * Right now it doesn't provide any specific properties/methods/events, we reserve
 * this ancestor for future use.
 */
class GraphicControl extends Control
{
}

/**
* CustomListControl is the base class for controls that display a list of items.
*
* It provides an abstract interface to implement for controls with a list of items.
*
*/
abstract class CustomListControl extends FocusControl
{
        protected $_itemindex = -1;

        /**
        * Returns the number of items in the list.
        * @return integer Number of items in the list.
        */
        abstract function readCount();

        /**
        * Returns the value of the ItemIndex property.
        * @return mixed Return the ItemIndex of the list.
        */
        abstract function readItemIndex();

        /**
        * Sets new ItemIndex value.
        * @param mixed $value Value of the new ItemIndex.
        */
        abstract function writeItemIndex($value);

        /**
        * Returns default ItemIndex.
        * @return mixed Returns default ItemIndex.
        */
        abstract function defaultItemIndex();

        /**
        * Adds an item to the list control.
        * @param mixed $item Value of item to add.
        * @param mixed $object Object to assign to the $item. is_object() is used to
        *                      test if $object is an object.
        * @param mixed $itemkey Key of the item in the array. Default key is used if null.
        * @return integer Return the number of items in the list.
        */
        abstract function AddItem($item, $object = null, $itemkey = null);

        /**
        * Deletes all of the items from the list control.
        */
        abstract function Clear();

        /**
        * Removes the selection, leaving all items unselected.
        */
        abstract function ClearSelection();
        //abstract function CopySelection($destination);
        //abstract function DeleteSelection();
        //abstract function MoveSelection($destination);

        /**
        * Selects all items or all text in the selected item.
        */
        abstract function SelectAll();
}

/**
* CustomMultiSelectListControl is the base class for controls that display a list of items and provide multiselection.
*
* It provides an abstract interface to implement for controls with a list of items in which user can select a range of items.
*
*/
abstract class CustomMultiSelectListControl extends CustomListControl
{
        protected $_multiselect = 0;

        /**
        * Returns the number of selected Items in the list.
        *
        * Use this property to get the number of selected items in the list.
        * Set MultiSelect to true if you want to allow user to select more than
        * one item.
        *
        * @return integer Returns how many items are selected in the list.
        */
        abstract function readSelCount();

        /**
        * Reads the value of the MultiSelect property.
        * @return bool Returns if the list is MultiSelect or not.
        */
        abstract function readMultiSelect();

        /**
        * Sets the value of the MultiSelect property.
        * @param bool $value Set MultiSelect to true or false.
        */
        abstract function writeMultiSelect($value);

        /**
        * Returns the default MultiSelect value.
        * @return bool Returns default MultiSelect value.
        */
        abstract function defaultMultiSelect();
}

?>