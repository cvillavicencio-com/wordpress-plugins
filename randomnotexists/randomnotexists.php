<?php
/**
 * Plugin Name:       Random does not exists
 * Description:       Shortcode to put random a.i. generated images in your site, always changing.
 * Version:           1.0
 * Author:            Camilo Villavicencio
 */

function random_notexist_get(){
    $notexist= array(
        array('https://thisrentaldoesnotexist.com/img-new/hero.jpg','bedroom'),
        array('https://thispersondoesnotexist.com/image','person'),
        array('https://thisartworkdoesnotexist.com/','artwork'),
        array('https://thiscatdoesnotexist.com/','cat'),
        array('https://thishorsedoesnotexist.com/','horse'),
    );

    $sel = rand(0,(count($notexist)-1));
    $result ='<div style="max-width:300px"><img src="'.$notexist[$sel][0].'"><br>This '.$notexist[$sel][1].' does not exist. </div>';
    return $result;

}

add_shortcode('random-not-exist', 'random_notexist_get');


function random_notexist_info(){
    echo '<div style="background-color:white;">
<h1>Random not exist</h1>
This plugin works with the shortcode [random-not-exist], when you put it in some page you will load always a random thing that does not exist.<br><br>
Sources:
<ul>
<li>- thisartworkdoesnotexist.com</li>
<li>- thiscatdoesnotexist.com</li>
<li>- thishorsedoesnotexist.com</li>
<li>- thispersondoesnotexist.com</li>
<li>- thisrentaldoesnotexist.com</li>
<li></li>
</ul>
</div>';
}

function random_notexist_page() {
    add_options_page( 'Random not exist', 'Random not exist', 'manage_options', 'random_notexist_info', 'random_notexist_info' );
}
add_action( 'admin_menu', 'random_notexist_page' );


?>





