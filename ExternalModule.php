<?php

namespace HideProjectCopy\ExternalModule;

use ExternalModules\AbstractExternalModule;

class ExternalModule extends AbstractExternalModule {

    function redcap_every_page_top($project_id): void {

        if (PAGE != 'ProjectSetup/other_functionality.php') {
            return;
        }

        $docNum = $this->edocsCount();
        $maxFiles = intval($this->getSystemSetting('max-files'));

        if ($docNum > $maxFiles) {

            $this->includeJs('js/hideRow.js');
        }

    }

    function edocsCount(): int {

        $pid = $this->getProjectId();
        $sql = sprintf("SELECT COUNT(DISTINCT doc_id) as docs from redcap_edocs_metadata WHERE project_id = $pid");
        $result = db_query($sql);
        $data = db_fetch_assoc($result);
        $docnum = intval($data['docs']);

        return $docnum;
    }

    protected function includeJs($file) {
        echo '<script src="' . $this->getUrl($file) . '"></script>';
    }

}
