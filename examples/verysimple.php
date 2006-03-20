<?php
/**
*   Very simple Gtk2_EntryDialog example
*
*   @author Christian Weiske <cweiske@php.net>
*/
require_once 'Gtk2/EntryDialog.php';

$text = Gtk2_EntryDialog::get(
    'What\'s your name?',       //the message
    'Don\'t know'               //The default text
);

if ($text !== false) {
    echo 'The name is: ';
    var_dump($text);
} else {
    echo "You cancelled\r\n";
}
?>
