<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
        $options = new Options();
        // Activer l'accès aux fichiers distants
        $options->set('isRemoteEnabled', true);
        $this->dompdf = new Dompdf($options);
        // Charger le HTML dans Dompdf

        // Définir la taille et l'orientation du papier
        $this->dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF (remarque : vous n'avez pas besoin de passer explicitement le contexte du flux)

        // Sortie du PDF généré
    }


    public function showPdf($html,$recipeName)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
        $this->dompdf->stream($recipeName, ["Attachment" => false]);
    }
}
