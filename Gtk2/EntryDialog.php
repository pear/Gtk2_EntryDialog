<?php
/**
*   Dialog message box with text entry field.
*
*   There are three modes to use it:
*   - Normal constructor with (somewhat complicated) parameters
*       as known from GtkMessageDialog.
*   - new_simple() static method constructor with only one required
*       parameter.
*   - Static get() method that just returns the inputted text instead
*       of the dialog itself. This is the most convenient and code-saving
*       method to get an input.
*
*   Even when the dialog has an OK button only, the user can cancel it
*   by closing the window.
*
*   @category   Gtk2
*   @package    Gtk2_EntryDialog
*   @author     Christian Weiske <cweiske@php.net>
*   @license    LGPL
*   @version    CVS: $Id$
*/
class Gtk2_EntryDialog extends GtkMessageDialog
{
    /**
    *   The entry box
    *   @var GtkEntry
    */
    protected $entry;

    /**
    *   The response id that is used as default
    *   @var int
    */
    protected $nDefaultResponseId = null;



    /**
    *   Normal constructor.
    *   Parameters are the same as for GtkMessageDialog.
    *
    *   @param GtkWindow        $parent     Parent window (can be null)
    *   @param GtkDialogFlags   $flags      Dialog flags (use 0 as default)
    *   @param GtkMessageType   $type       Message type (e.g. Gtk::MESSAGE_QUESTION)
    *   @param GtkButtonsType   $buttons    Buttons to show (e.g. Gtk::BUTTONS_OK)
    *   @param string           $message    Message to display
    *   @param string           $default    Default text for the entry
    */
    public function __construct($parent, $flags, $type, $buttons, $message, $default = null)
    {
        parent::__construct($parent, $flags, $type, $buttons, $message);
        $this->entry = new GtkEntry();
        $this->entry->connect_simple('activate', array($this, 'onActivateEntry'));
        $this->vbox->pack_end($this->entry);
        if ($default !== null) {
            $this->entry->set_text($default);
        }
        switch ($buttons) {
            case Gtk::BUTTONS_OK:
            case Gtk::BUTTONS_OK_CANCEL:
                $this->nDefaultResponseId = Gtk::RESPONSE_OK;
                break;
            case Gtk::BUTTONS_YESNO:
                $this->nDefaultResponseId = Gtk::RESPONSE_YES;
                break;
            case Gtk::BUTTONS_CLOSE:
                $this->nDefaultResponseId = Gtk::RESPONSE_CLOSE;
                break;
        }
    }//public function __construct($parent, $flags, $type, $buttons, $message, $default = null)



    /**
    *   Simplified constructor with not so much parameters.
    *   Message type is Gtk::MESSAGE_QUESTION, the flags will be
    *   Gtk::DIALOG_MODAL if the parent is set. Only one OK button
    *   will be visible.
    *
    *   @param string       $message    Message/question to display
    *   @param string       $default    Default entry text
    *   @param GtkWidget    $parent     Parent widget if any
    *
    *   @return Gtk2_EntryDialog    Entry dialog instance
    */
    public static function new_simple($message, $default = null, $parent = null)
    {
        $flags = $parent === null ? 0 : Gtk::DIALOG_MODAL;
        return new Gtk2_EntryDialog(
            $parent, $flags, Gtk::MESSAGE_QUESTION,
            Gtk::BUTTONS_OK, $message, $default
        );
    }//public static function new_simple($message, $default = null, $parent = null)



    /**
    *   Creates a dialog with the given parameters (@see new_simple),
    *   runs it, and returns the text set.
    *   If the user cancelled the dialog, this method returns FALSE.
    *   In any other case (even when the text is empty), the a string
    *   with the text is returned.
    *
    *   @param string       $message    Message/question to display
    *   @param string       $default    Default entry text
    *   @param GtkWidget    $parent     Parent widget if any
    *
    *   @return string      Text input by the user
    */
    public static function get($message, $default, $parent = null)
    {
        $dialog = self::new_simple($message, $default, $parent);
        $answer = $dialog->run();
        if ($answer == Gtk::RESPONSE_OK) {
            $text = $dialog->get_text();
        } else {
            //cancelled
            $text = false;
        }
        $dialog->destroy();
        return $text;
    }//public static function get($message, $default, $parent = null)



    /**
    *   Show the dialog and block until a button has been pressed.
    *
    *   @return int     The response id of the pressed button.
    */
    public function run()
    {
        //Make sure that the entry is visible
        $this->show_all();
        return parent::run();
    }//public function run()



    /**
    *   Sets the text for the entry
    *
    *   @param string   $text   The text to set
    */
    public function set_text($text)
    {
        $this->entry->set_text($text);
    }//public function set_text($text)



    /**
    *   Retrieves the text from the entry
    *
    *   @return string  The input from the user
    */
    public function get_text()
    {
        return $this->entry->get_text();
    }//public function get_text()



    /**
    *   Set the default response.
    *   The button with the id will be the default one,
    *   allowing you to just press return to activate it
    *
    *   @param int  $response_id    Response code
    */
    public function set_default_response($response_id)
    {
        parent::set_default_response($response_id);
        $this->nDefaultResponseId = $response_id;
    }//public function set_default_response($response_id)



    /**
    *   Callback for the entry text.
    *   Activates the default button.
    */
    public function onActivateEntry()
    {
        if ($this->nDefaultResponseId !== null) {
            $this->response($this->nDefaultResponseId);
        }
    }//public function onActivateEntry()



    /*
    *   PEAR-style camelCase method aliases
    */



    /**
    *   Alias for set_default_response()
    *
    *   @param int  $response_id    Response code
    */
    public function setDefaultResponse($response_id)
    {
        $this->set_default_response($response_id);
    }//public function setDefaultResponse($response_id)



    /**
    *   Alias for set_text().
    *
    *   @param string   $text   The text to set
    */
    public function setText($text)
    {
        $this->set_text($text);
    }//public function setText($text)



    /**
    *   Alias for get_text().
    *
    *   @return string  The input from the user
    */
    public function getText()
    {
        return $this->get_text();
    }//public function getText()

}//class Gtk2_EntryDialog extends GtkMessageDialog
?>
