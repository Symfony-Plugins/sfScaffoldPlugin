<?php

class sfScaffoldPluginActions extends sfActions {

  public function executeParse(sfWebRequest $request) {
    $config['production'] = true;
    $config['max_age'] = false;
    $config['load_paths'] = array();
    $config['output_compression'] = false;
    $config['set_etag'] = true;
    $config['enable_string'] = false;
    $config['enable_url'] = false;
    $config['cache_path'] = sfConfig::get('sf_app_cache_dir') . '/scss/';
    $config['extensions'] = array(
      //'AbsoluteUrls',
      'Embed',
      'Functions',
      'HSL',
      'ImageReplace',
      'Minify',
      'Properties',
      'Random',
      'Import',
      'Mixins',
      'NestedSelectors',
      'Variables',
      'XMLVariables',
      //'Sass',
      //'CSSTidy',
      //'YUI'
    );

    /**
     * The environment class helps us handle errors
     * and autoloading of classes. It's not required
     * to make Scaffold function, but makes it a bit
     * nicer to use.
     */
    $system = sfConfig::get('sf_plugins_dir') . '/sfScaffoldPlugin/lib/vendor/scaffold';
    include $system . '/lib/Scaffold/Environment.php';

    /**
     * Automatically load any Scaffold Classes
     */
    Scaffold_Environment::auto_load();

    /**
     * Let Scaffold handle errors
     */
    Scaffold_Environment::handle_errors();

    /**
     * Set the view to use for errors and exceptions
     */
    Scaffold_Environment::set_view(realpath($system . '/views/error.php'));

// =========================================
// = Start the scaffolding magic  =
// =========================================
// The container creates Scaffold objects

    $container = new Scaffold_Container($system, $config);

// This is where the magic happens
    $scaffold = $container->build();

// Get the requested source
    $source = new Scaffold_Source_File($scaffold->helper->load->file('/css/' . $request->getParameter('stylesheet') . '.css'));

// Compiles the source object
    $source = $scaffold->compile($source);

// Use the result to render it to the browser. Hooray!
    return $this->renderText($scaffold->render($source));
  }

}