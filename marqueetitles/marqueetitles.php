<?php
/**
 * Plugin Name:       Maquee titles
 * Description:       Show title of posts inside lovely marquee tag, before it's finally totally deprecated.
 * Version:           1.0
 * Author:            Camilo Villavicencio
 */

function marqueeit($title){
    return '<br><marquee behavior="scroll" direction="up" height="80px">' . $title . '</marquee>';
}

add_filter( 'the_title', 'marqueeit' );

?>
