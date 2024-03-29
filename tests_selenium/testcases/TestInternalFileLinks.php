<?php
require_once dirname(__FILE__) . '/../../../../tests/tests_halo/SeleniumTestCase_Base.php';


class TestInternalFileLinks extends SeleniumTestCase_Base
{

  protected function setUp() {
    parent::setUp();
    $this->linkWikitext = "[[File:Upload.png|Upload.png]]";
    $this->linkElementLocator = "css=img[alt=\"Upload.png\"][_fck_mw_filename=\"Upload.png\"]";
    $this->elementNotPresentMsg = "Element not present: <img alt=\"Upload.png\" _fck_mw_filename=\"Upload.png\">";
    $this->wikitextNotPresenMsg = "Wikitext not equal to [[File:Upload.png|Upload.png]]";
  }

  public function testLinks() {
    $this->login();
    $this->open("/mediawiki/index.php?title=Testlink&action=edit");
    $this->type("id=wpTextbox1", $this->linkWikitext);
    $this->click("id=wpSave");
    $this->waitForPageToLoad("30000");
    $this->click("id=ca-edit");
    $this->waitForPageToLoad("30000");
    for ($second = 0;; $second++) {
      if ($second >= 60)
        $this->fail($this->elementNotPresentMsg);
      try {
        if ($this->isElementPresent($this->linkElementLocator))
          break;
      } catch (Exception $e) {

      }
      sleep(1);
    }

    $this->click("id=toggle_wpTextbox1");
    $this->assertEquals($this->linkWikitext, $this->getValue("id=wpTextbox1"), $this->wikitextNotPresenMsg);
    $this->click("id=toggle_wpTextbox1");
    try {
      $this->assertTrue($this->isElementPresent($this->linkElementLocator), $this->elementNotPresentMsg);
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
      array_push($this->verificationErrors, $e->toString());
    }
    $this->click("id=toggle_wpTextbox1");
    $this->assertEquals($this->linkWikitext, $this->getValue("id=wpTextbox1"), $this->wikitextNotPresenMsg);
  }
}
?>