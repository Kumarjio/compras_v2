<?php
class mypdf extends tcpdf {
    //Page header
    public function Header() {
        // Logo
        //$this->Image('/var/www/ingliq/images/inglogo.jpg', 10, 8, 15);
        $this->Image("images/tuya_logo.jpg",20,8,23,15,'jpg','','',true,600);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Move to the right
        $this->Cell(80);
        // Title
        //$this->Cell(31, 10, 'Title', 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }
    
    // Page footer
    public function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'TUYA - Compañía de Financiamiento - Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
    }
}
?>
