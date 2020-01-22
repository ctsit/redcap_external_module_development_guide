<?php

namespace HelloHook\ExternalModule;

use ExternalModules\AbstractExternalModule;

class ExternalModule extends AbstractExternalModule {

    // Test out using the hooks in the documentation to make an alert appear in different contexts
    // FIXME
    /* Write your code here */
    function a_real_redcap_hook() {
    /* Stop writing code here */
        $this->includeJs('js/hello_hook.js');
        $this->setJsSetting('helloHook', 'Hello world!');
    }

    protected function includeJs($file) {
        // Use this function to use your JavaScript files in the frontend
        echo '<script src="' . $this->getUrl($file) . '"></script>';
    }

    protected function setJsSetting($key, $value) {
        // Use this function to send variables to the frontend
        echo '<script>' . $key . '=' . json_encode($value) . ';</script>';
    }
}
