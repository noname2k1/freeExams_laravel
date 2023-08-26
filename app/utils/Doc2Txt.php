<?php
namespace App\Utils;

class Doc2Txt {
    private $filename;

    public function __construct($filePath) {
        $this->filename = $filePath;
    }

    private function read_doc() {
        $fileHandle = fopen($this->filename, "r");
        $line       = @fread($fileHandle, filesize($this->filename));
        $lines      = explode(chr(0x0D), $line);
        $outtext    = "";
        foreach ($lines as $thisline) {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== false) || (strlen($thisline) == 0)) {
            } else {
                $outtext .= $thisline . " ";
            }
        }
        $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/", "", $outtext);
        return $outtext;
    }

    private function read_docx() {
        $striped_content = '';
        $content         = '';

        $zip = new \ZipArchive();

        if ($zip->open($this->filename) !== true) {
            return false;
        }

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $entryName = $zip->getNameIndex($i);

            if ($entryName != "word/document.xml") {
                continue;
            }

            $content .= $zip->getFromIndex($i);
        }

        $zip->close();

        $content         = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content         = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }

    public function convertToText() {

        if (isset($this->filename) && !file_exists($this->filename)) {
            return "File Not exists";
        }

        $fileArray = pathinfo($this->filename);
        $file_ext  = $fileArray['extension'];
        if ($file_ext == "doc" || $file_ext == "docx") {
            if ($file_ext == "doc") {
                return $this->read_doc();
            } else {
                return $this->read_docx();
            }
        } else {
            return "Invalid File Type";
        }
    }
}