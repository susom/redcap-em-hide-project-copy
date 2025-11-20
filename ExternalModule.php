<?php

namespace HideProjectCopy\ExternalModule;

use ExternalModules\AbstractExternalModule;

class ExternalModule extends AbstractExternalModule {

    function redcap_every_page_top($project_id) {

        if (PAGE != 'ProjectSetup/other_functionality.php') {
            return;
        }

        $docNumArr = $this->edocsCount();
        $docNum = intval($docNumArr[0]);
        $maxFiles = intval($this->getSystemSetting('max-files'));

        if ($docNum > $maxFiles) {

            $this->includeJs('js/hideRow.js');
        }

    }

    function edocsCount(){
        $sql = 'SELECT COUNT(DISTINCT doc_id) as docs FROM redcap_edocs_metadata WHERE project_id = ' . $this->getProjectId();
        $result = $this->framework->query($sql);

        $response = array_column(
            $result->fetch_all(MYSQLI_ASSOC),
            'docs'
        );

        return $response;
    }

    protected function includeJs($file) {
        echo '<script src="' . $this->getUrl($file) . '"></script>';
    }

}
