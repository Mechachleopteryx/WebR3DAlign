<?php
class Results_model extends CI_Model {

    function __construct()
    {
        $CI = & get_instance();
        parent::__construct();
    }

    function get_basepair_comparison($query_id)
    {
        $filename = "/Servers/rna.bgsu.edu/r3dalign_dev/data/results/$query_id/{$query_id}.csv";
        if ( !file_exists($filename) ) {
            return NULL;
        }

        $table = '';
        if (($handle = fopen($filename, "r")) !== FALSE) {
            $isFirstLine = True;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($isFirstLine) {
                    $table .= '<thead>';
                }
                $table .= '<tr>';
                $num = count($data);
                for ($i = 0; $i < $num; $i++) {
                    if ( $isFirstLine ) {
                        $tag = 'th';
                    } else {
                        $tag = 'td';
                    }
                    if ( $i == 1 or $i == 4 ) {
                        $table .= "<$tag class='{$data[$i]}'>" . $data[$i] . "</$tag>";
                    } else {
                        $table .= "<$tag>" . $data[$i] . "</$tag>";
                    }
                }
                $table .= '</tr>';
                if ($isFirstLine) {
                    $table .= '</thead><tbody>';
                    $isFirstLine = False;
                }
            }
            $table .= '</tbody>';
            fclose($handle);
        }
        return $table;
    }

    function get_alignment($query_id)
    {
        $filename = "/Servers/rna.bgsu.edu/r3dalign_dev/data/results/$query_id/{$query_id}.fasta";
        if ( !file_exists($filename) ) {
            return NULL;
        }

        $lines = file($filename);

        $num = count($lines) - 1; // the last line is empty
        $delta = $num / 2;

        $alignment = '';

        for ($i = 1; $i <= $delta; $i++) {
            $alignment .= $lines[$i] . $lines[$i+$delta+1] . "\n";
        }

        return $alignment;

    }


}

/* End of file results_model.php */
/* Location: ./application/model/results_model.php */