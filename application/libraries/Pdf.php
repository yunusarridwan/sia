<?php
require_once APPPATH . '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf extends Dompdf
{
    public function __construct()
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // kalau butuh load gambar eksternal

        parent::__construct($options);
    }

    // ✅ Tambahkan fungsi ini agar bisa dipanggil dari controller
    public function load_view($view, $data = [], $filename = '', $stream = true, $paper = 'A4', $orientation = 'portrait')
    {
        $CI =& get_instance();
        $html = $CI->load->view($view, $data, true); // Render HTML dari view

        $this->setPaper($paper, $orientation);
        $this->loadHtml($html);
        $this->render();

        if ($stream) {
            $this->stream($filename ? $filename : "document.pdf", array("Attachment" => 0));
        } else {
            return $this->output();
        }
    }
}
