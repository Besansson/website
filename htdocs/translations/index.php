<?php
  include('../engine/engine.inc');
  include('translations.inc');

  $page = new Page;
  $page->addRssFeed('status-feed/', __('Translations Status'));
  $page->addRssFeed('status_branch_rss.php', __('Translations Status (Stable Branch)'));
  $page->addRssFeed('status_trunk_rss.php', __('Translations Status (Unstable Trunk)'));
  $page->printHead(__('Translations'), TAB_TRANSLATIONS);
  
  $page->printRssHeading(__('Translations'), 'status-feed/');
  
  try {
    $status = New TranslationsStatus('status_trunk.xml');
    $status->srcUrl = 'https://bitbucket.org/winmerge/winmerge/src/default/Translations/';
    
    print("<ul>\n");
    print("  <li><a href=\"#translators\">" . __('Translators') . "</a></li>\n");
    print("  <li><a href=\"#winmerge\">" . __('WinMerge Status') . "</a></li>\n");
    print("  <li><a href=\"#shellextension\">" . __('ShellExtension Status') . "</a></li>\n");
    print("  <li><a href=\"#innosetup\">" . __('InnoSetup Files') . "</a></li>\n");
    print("  <li><a href=\"#readme\">" . __('Readme Files') . "</a></li>\n");
    print("</ul>\n");
    
    $page->printSubHeading(__('Translating'));
    $page->printPara(__('We currently have WinMerge translated into the languages listed below:'));
    
    print("<ul class=\"inline\">\n");
    $languages = $status->getLanguagesArray();
    foreach ($languages as $language) { //for all languages...
      print("  <li>" . $language . "</li>\n");
    }
    print("</ul>\n");
    
    $page->printPara(__('If you would like to update any of these translations or add another translation, then please follow <a href="%s">these instructions</a>.', 'instructions.php'));
    
    $status->printTranslators();
    
    $page->printAnchorSubHeading('WinMerge Status', 'winmerge');
    $status->printProjectTable('WinMerge');
    
    $page->printAnchorSubHeading('ShellExtension Status', 'shellextension');
    $status->printProjectTable('ShellExtension');
    
    $page->printAnchorSubHeading('InnoSetup Files', 'innosetup');
    $status->printProjectList('InnoSetup');
    
    $page->printAnchorSubHeading('Readme Files', 'readme');
    $status->printProjectList('Docs/Readme');
  }
  catch (Exception $ex) { //If problems with translations status...
    $page->printPara(__('The translations status is currently not available...'));
  }

  $page->printFoot();
?>