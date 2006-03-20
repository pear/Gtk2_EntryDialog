<?php
/**
*   Simple Gtk2_EntryDialog example
*
*   @author Christian Weiske <cweiske@php.net>
*/
require_once 'Gtk2/EntryDialog.php';

$id = Gtk2_EntryDialog::new_simple(
    'What\'s your name?',       //the message
    'Don\'t know'               //The default text
);

$answer = $id->run();
$id->destroy();
if ($answer == Gtk::RESPONSE_OK) {
    echo 'The name is: ';
    var_dump($id->get_text());
} else {
    echo "You cancelled\r\n";
}
?>
