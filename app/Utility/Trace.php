<?php
namespace App\Utility;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class Trace {

    /**
     *  This Trace utility class prints each given message with the current
     *  timestamp and runtime to the console if stdouts are visible.
     *
     *  Functions:
     *      static println (string $msg = null)
     *      static print (string $msg)
     *      static getTimerMessage
     *      static getInfoMessage (string $msg)
     *      static getWarningMessage (string $msg)
     *      static getErrorMessage (string $msg)
     *      static getSuccessMessage (string $msg)
     *      static resetTimer
     */

    /** Path to the config file */
    private const CONFIG_FILE_PATH = "app/Utility/Config/trace.ini";

    /** Instance of Trace for the singleton pattern */
    private static $instance;

    /** Whether statements will be printed to the console */
    private $isStdoutVisible;

    /** Color index (0-7) of the standard message */
    private $stdMsgClrIdx;

    /** Color index (0-7) of the background of the standard message */
    private $stdBgClrIdx;

    /** Color index (0-7) of the timer message */
    private $tmrMsgClrIdx;

    /** Color index (0-7) of the background of the timer message */
    private $tmrBgClrIdx;

    /** Color index (0-7) of the info message */
    private $infoMsgClrIdx;

    /** Color index (0-7) of the background of the info message */
    private $infoBgClrIdx;

    /** Color index (0-7) of the warning message */
    private $warnMsgClrIdx;

    /** Color index (0-7) of the background of the warning message */
    private $warnBgClrIdx;

    /** Color index (0-7) of the error message */
    private $errMsgClrIdx;

    /** Color index (0-7) of the background of the error message */
    private $errBgClrIdx;

    /** Color index (0-7) of the success message */
    private $scsMsgClrIdx;

    /** Color index (0-7) of the background of the success message */
    private $scsBgClrIdx;

    /**
     *  Print the info-message to the console and move the cursor to the next
     *  line if stdouts are visible
     *  @param  string|null $msg    message
     */
    public static function printlnInfo (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getInfoMessage($msg) . "\n";
        }
    }

    /**
     *  Print the warning-style message to the console and move the cursor to
     *  the next line if stdouts are visible
     *  @param  string|null $msg    message
     */
    public static function printlnWarning (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getWarningMessage($msg) . "\n";
        }
    }

    /**
     *  Print the error-style message to the console and move the cursor to
     *  the next line if stdouts are visible
     *  @param  string|null $msg    message
     */
    public static function printlnError (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getErrorMessage($msg) . "\n";
        }
    }

    /**
     *  Print the success-style message to the console and move the cursor to
     *  the next line if stdouts are visible
     *  @param  string|null $msg    message
     */
    public static function printlnSuccess (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getSuccessMessage($msg) . "\n";
        }
    }

    /**
     *  Print the message to the console and move the cursor to the next line if
     *  stdouts are visible
     *  @param  string|null $msg    message
     */
    public static function println (string $msg = null) {
        if (static::isStdoutVisible()) {
            echo (
                ($msg === null)
                ? "\n"
                : static::getStandardMessage($msg) . "\n"
            );
        }
    }

    /**
     *  Print the yes/no option to the console if the stdouts are visible
     *  @param  string  $yes    "yes" message
     *  @param  string  $no     "no" message
     */
    public static function printYesNo (string $yes = "yes", string $no = "no") {
        if (static::isStdoutVisible()) {
            echo static::getYesNoMessage($yes, $no);
        }
    }

    /**
     *  Print the info-style to the console if stdouts are visible
     *  @param  string  $msg    message
     */
    public static function printInfo (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getInfoMessage($msg);
        }
    }

    /**
     *  Print the warning-style message to the console if stdouts are visible
     *  @param  string  $msg    message
     */
    public static function printWarning (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getWarningMessage($msg);
        }
    }
    /**
     *  Print the error-style message to the console if stdouts are visible
     *  @param  string  $msg    message
     */
    public static function printError (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getErrorMessage($msg);
        }
    }

    /**
     *  Print the success-style message to the console if stdouts are visible
     *  @param  string  $msg    message
     */
    public static function printSuccess (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getSuccessMessage($msg);
        }
    }

    /**
     *  Print the message to the console if stdouts are visible
     *  @param  string  $msg    message
     */
    public static function print (string $msg) {
        if (static::isStdoutVisible()) {
            echo static::getStandardMessage($msg);
        }
    }

    /**
     *  Return the yes/no option
     *  @param  string  $yes    "yes" message
     *  @param  string  $no     "no" message
     *  @return string
     */
    public static function getYesNoMessage (
            string $yes = "yes", string $no = "no") {

        return (static::getSuccessMessage(" $yes ")
            . static::getErrorMessage(" $no ")
        );
    }

    /**
     *  Return the message as an information
     *  @param  string  $msg    message
     */
    public static function getInfoMessage (string $msg) {
        $infoMsgClrIdx = static::getInstance()->infoMsgClrIdx;
        $infoBgClrIdx = static::getInstance()->infoBgClrIdx;

        return Dye::dye($msg, $infoMsgClrIdx, $infoBgClrIdx);
    }

    /**
     *  Return the message as a warning
     *  @param  string  $msg    message
     */
    public static function getWarningMessage (string $msg) {
        $warnMsgClrIdx = static::getInstance()->warnMsgClrIdx;
        $warnBgClrIdx = static::getInstance()->warnBgClrIdx;

        return Dye::dye($msg, $warnMsgClrIdx, $warnBgClrIdx);
    }

    /**
     *  Return the message as an error
     *  @param  string  $msg    message
     */
    public static function getErrorMessage (string $msg) {
        $errMsgClrIdx = static::getInstance()->errMsgClrIdx;
        $errBgClrIdx = static::getInstance()->errBgClrIdx;

        return Dye::dye($msg, $errMsgClrIdx, $errBgClrIdx);
    }

    /**
     *  Return the message as a success
     *  @param  string  $msg    message
     */
    public static function getSuccessMessage (string $msg) {
        $scsMsgClrIdx = static::getInstance()->scsMsgClrIdx;
        $scsBgClrIdx = static::getInstance()->scsBgClrIdx;

        return Dye::dye($msg, $scsMsgClrIdx, $scsBgClrIdx);
    }

    /**
     *  Return the colored standard message
     *  @param  string  $msg    message
     *  @return string
     */
    private static function getStandardMessage (string $msg) {
        return Dye::dye(
            $msg,
            static::getInstance()->stdMsgClrIdx,
            static::getInstance()->stdBgClrIdx
        );
    }

    /**
     *  Return an instance; an exsisting one if exists; a new instance otherwise
     *  @return static
     */
    private static function getInstance () {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     *  Return true if the stdout is visible; false otherwise
     *  @return bool
     */
    private static function isStdoutVisible () {
        return static::getInstance()->isStdoutVisible;
    }

    /**
     *  Construct a new instance
     */
    private function __construct () {
        $cfgLst = parse_ini_string(File::get(self::CONFIG_FILE_PATH));

        $this->isStdoutVisible = $cfgLst["isStdoutVisible"];
        $this->stdMsgClrIdx = $cfgLst["stdMsgClrIdx"];
        $this->stdBgClrIdx = $cfgLst["stdBgClrIdx"];
        $this->infoMsgClrIdx = $cfgLst["infoMsgClrIdx"];
        $this->infoBgClrIdx = $cfgLst["infoBgClrIdx"];
        $this->warnMsgClrIdx = $cfgLst["warnMsgClrIdx"];
        $this->warnBgClrIdx = $cfgLst["warnBgClrIdx"];
        $this->errMsgClrIdx = $cfgLst["errMsgClrIdx"];
        $this->errBgClrIdx = $cfgLst["errBgClrIdx"];
        $this->scsMsgClrIdx = $cfgLst["scsMsgClrIdx"];
        $this->scsBgClrIdx = $cfgLst["scsBgClrIdx"];
    }
}
