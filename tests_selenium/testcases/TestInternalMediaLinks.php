<?php
require_once dirname(__FILE__) . '/../../../../tests/tests_halo/SeleniumTestCase_Base.php';


class TestInternalMediaLinks extends SeleniumTestCase_Base
{

  protected function setUp() {
    parent::setUp();
    $this->linkWikitext = "[[Media:Upload.png|Upload.png]]";
    $this->linkElementLocator = "css=a[title=\"Upload.png\"][_fck_mw_filename=\"Upload.png\"][_fck_mw_type=\"media\"]";
    $this->elementNotPresentMsg = "Element not present: <a class=\"new\" title=\"Upload.png\" _fck_mw_type=\"media\" _fck_mw_filename=\"Upload.png\" href=\"Upload.png\">Upload.png</a>";
    $this->wikitextNotPresenMsg = "Wikitext not equal to [[Media:Upload.png|Upload.png]]";
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