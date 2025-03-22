<?php
class FormSanitizer{
    public static function sanitizeFormString($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        $inputText = htmlspecialchars($inputText);
        $inputText = strtolower($inputText);
        $inputText = ucfirst($inputText);
        return $inputText;
    }

    public static function sanitizeFormPseudo($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        $inputText = str_replace(["/","?",".","=",">","<","$","!","*","|","&","","/","/","_","@","-"],"",$inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","",$inputText);
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);
        return $inputText;
    }
}