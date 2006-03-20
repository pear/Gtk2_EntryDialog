<?php
/**
*   Normal Gtk2_EntryDialog example
*
*   @author Christian Weiske <cweiske@php.net>
*/
require_once 'Gtk2/EntryDialog.php';

$id = new Gtk2_EntryDialog(
    null,                       //parent window
    0,                          //flags (GtkDialogFlags)
    Gtk::MESSAGE_QUESTION,      //type of message
    Gtk::BUTTONS_OK_CANCEL,     //which buttons shall be there
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
