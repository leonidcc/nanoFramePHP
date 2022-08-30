<?php
/**
 *
 */
class Cmp{
    function __construct(){
        // code...
    }
    public function parseComponent($name, $args){
        $template = $this->create($name, $args);
        $script = $this->get_string_between($template,"<script>","</script>");
        $html = $this->get_string_between($template,"</script>","<style>");
        $css = $this->get_string_between($template,"<style>","</style>");

        preg_match_all('/[.]+.+{/', $css , $resultado);
        $resultado = array_unique($resultado[0]);
        $hash = substr(md5(rand(1,30)),0,4);
        foreach ( $resultado as $key => $value) { 
            $class = "#kai$hash ".$value;
            $css =  str_replace($value , $class , $css) ;
        }
        $html =  str_replace("<kaiwik>" , "<kaiwik id='kai$hash' >"  , $html) ;
        return [$html, $css, $script];
    }
    function create($name, $arg = []) {
       $template= new template("vistas/".$name.".kaiwik" , $arg);
       return $template;
   }
   function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

}


 ?>
