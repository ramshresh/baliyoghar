<?php

class ExportToExcel extends CI_Controller {

    private $peopleHeaderTitle = array('Age wise', '', '','Gender wise', '','','', 'Status wise', '', '', '', '');
    private $peopleHeader = array('age<30', 'age>30', '','male', 'female','other','', 'active', 'retired', 'migrated within country', 'migrated outside country', 'death');

    public function loadpage($data = null, $view = 'Home', $pagetitle = 'HOME | BALIYOGHAR', $page = array('includes/Header', 'includes/Navigation'))
    {
        $data['deleted_count'] = $this->functionsmodel->getDeletedDataCounts();
        $data['pagetitle'] = $pagetitle;
        for ($i = 0; $i < count($page); $i++) {
            $this->load->View($page[$i], $data);
        }
        $this->load->View($view, $data);
        $this->load->View('includes/Footer');
    }

    public function peopleReport() {
        $content = $this->input->post('content');
        $date = date("Y-m-d");
        $file = 'Report/people('.$date.').CSV';
        $content_array = explode(',',$content);
        $list = array(
            $this->peopleHeaderTitle,
            $this->peopleHeader,
            $content_array
        );

        $fp = fopen($file, 'w');

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        header('Content-Disposition: attachment; filename=' . $file);
        header('Content-type: application/vnd.ms-excel');
        readfile($file);

        exit;
    }

}

?>