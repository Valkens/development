<?php
class Core_Template
{
    public $engine;
    public $filename;
    public $contents;
    public $varsGlobal;
    public $inheritFrom;
    public $inheritBlocks = array();

    public function __construct($engine, $filename, $contents, $varsGlobal = array()) {
        $this->engine = $engine;
        $this->filename = $filename;
        $this->contents = $contents;
        $this->varsGlobal = $varsGlobal;
    }

    public function setVar($varName, $varValue) {
        $this->varsGlobal[$varName] = $varValue;
    }

    public function render($varsLocal = array()) {
        // Extract the Universal (embedded in global), Global and
        // Localvariables into the current scope.
        extract($this->varsGlobal);
        extract($varsLocal);

        // Start output buffering so we can capture the output of the eval.
        ob_start();

        // Temporary set the error handler so we can show the faulty template
        // file. Render the contents, reset the error handler and return the
        // rendered contents.
        $this->errorHandlerOrig = set_error_handler(array($this, 'errorHandler'));
        eval("?>" . $this->contents);
        restore_error_handler();

        // Stop output buffering and return the contents of the buffer
        // (rendered template).
        $result = ob_get_contents();

        foreach ($this->engine->registryFilters as $key => $val) {
            if ($key == 'output') {
                $result = call_user_func($val[0], $result, $val[1]);
            }
        }

        ob_end_clean();

        if ($this->inheritFrom !== NULL) {
            $this->inheritFrom->inheritBlocks = $this->inheritBlocks;
            $result = $this->inheritFrom->render();
        }

        return $result;
    }

    public function errorHandler($nr, $string, $file, $line) {
        // We can restore the old error handler, otherwise this error handler
        // will stay active because we throw an exception below.
        restore_error_handler();

        // If this is reached, it means we were still in Output Buffering mode.
        // Stop output buffering, or we'll end up with template text on the
        // Stdout.
        ob_end_clean();

        // Throw the exception
        throw new Exception("$string (file: {$this->filename}, line $line)");
    }

    public function inc($template) {
        if (!isset($this->engine)) {
            throw new Exception("Cannot include templates in a Template instance created from a string.");
        }
        $t = $this->engine->template($template);
        print ($t->render());
    }

    public function inherit($template) {
        $this->inheritFrom = $this->engine->template($template);
    }

    public function addScript($files)
    {
        if ($this->engine->options['combineJs']) {
            $files = array_map(array($this, 'getAbsolutePath'), $files);
            $fileCache = Core_Helper_View::cccJs($files, $this->engine->options);

            echo "<script type=\"text/javascript\" src=\"$fileCache\"></script>\n";
        } else {
            $files = array_map(array($this, 'getAbsoluteUrl'), $files);
            foreach ($files as $file) {
                echo "<script type=\"text/javascript\" src=\"$file\"></script>\n";
            }
        }
    }

    public function addCss($files)
    {
        if ($this->engine->options['combineCss']) {
            $files = array_map(array($this, 'getAbsolutePath'), $files);
            $fileCache = Core_Helper_View::cccCss($files, $this->engine->options);

            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$fileCache\" />\n";
        } else {
            $files = array_map(array($this, 'getAbsoluteUrl'), $files);
            foreach ($files as $file) {
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$file\" />\n";
            }
        }
    }

    public function getAbsoluteUrl($file)
    {
        if (strpos($file, '/', 0) == 0) {
            $file = BASE_URL . $file;
        } else {
            $file = BASE_URL . '/app/theme/' . $this->engine->getTheme() . '/' . $file;
        }

        return $file;
    }

    public function getAbsolutePath($file)
    {
        if (strpos($file, '/', 0) == 0) {
            $file = BASE_PATH . $file;
        } else {
            $file = BASE_PATH . '/app/theme/' . $this->engine->getTheme() . '/' . $file;
        }

        return $file;
    }
}