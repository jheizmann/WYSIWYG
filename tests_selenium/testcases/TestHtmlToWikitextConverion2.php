<?php
/*
 * Copyright (C) ontoprise GmbH
 *
 * Vulcan Inc. (Seattle, WA) and ontoprise GmbH (Karlsruhe, Germany)
 * expressly waive any right to enforce any Intellectual Property
 * Rights in or to any enhancements made to this program.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program.If not, see <http://www.gnu.org/licenses/>.
 *
 */

require_once dirname(__FILE__) . '/../../../../tests/tests_halo/SeleniumTestCase_Base.php';

class TestHtmlToWikitextConverion2 extends SeleniumTestCase_Base
{
  public function testHtmlToWikiConversion()
  {
    $this->login();
    $this->open("/mediawiki/index.php?title=Testhtmltowiki&action=edit&mode=wysiwyg");
    $this->runScript("CKEDITOR.instances.wpTextbox1.setData('');");
    $this->setSpeed("2000");
    $this->runScript("CKEDITOR.instances.wpTextbox1.insertHtml('<span class=\"fck_mw_noinclude\" _fck_mw_tagname=\"noinclude\" _fck_mw_customtag = \" true \">not included text</span>')");
    $this->runScript("ToggleCKEditor('toggle','wpTextbox1');");
    $this->setSpeed("0");  
        
    try {
        $this->assertNotEquals("''", $this->getValue("id=wpTextbox1"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, "Conversion error: the resulting wikitext is empty");
    }
  }
}
?>
