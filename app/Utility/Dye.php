<?php
namespace App\Utility;

class Dye {

    /**
     *  This Dye utility class dyes messages and backgrounds in the console.
     *
     *  Functions:
     *      static blackMessage (string $msg)
     *      static redMessage (string $msg)
     *      static greenMessage (string $msg)
     *      static yellowMessage (string $msg)
     *      static blueMessage (string $msg)
     *      static purpleMessage (string $msg)
     *      static cyanMessage (string $msg)
     *      static whiteMessage (string $msg)
     *      static blackBackground (string $msg)
     *      static redBackground (string $msg)
     *      static greenBackground (string $msg)
     *      static yellowBackground (string $msg)
     *      static blueBackground (string $msg)
     *      static purpleBackground (string $msg)
     *      static cyanBackground (string $msg)
     *      static whiteBackground   (string $msg)
     *      static dyeMessage (string $msg, int $clrIdx)
     *      static dyeBackground (string $msg, int $clrIdx)
     *      static dye (string $msg, int $msgClrIdx, int $bgClrIdx)
     */

    /**
     *  Return the message in black
     *  @param  string  $msg    message
     *  @return string
     */
    public static function blackMessage (string $msg) {
        return static::dyeMessage($msg, 0);
    }

    /**
     *  Return the message in red
     *  @param  string  $msg    message
     *  @return string
     */
    public static function redMessage (string $msg) {
        return static::dyeMessage($msg, 1);
    }

    /**
     *  Return the message in green
     *  @param  string  $msg    message
     *  @return string
     */
    public static function greenMessage (string $msg) {
        return static::dyeMessage($msg, 2);
    }

    /**
     *  Return the message in yellow
     *  @param  string  $msg    message
     *  @return string
     */
    public static function yellowMessage (string $msg) {
        return static::dyeMessage($msg, 3);
    }

    /**
     *  Return the message in blue
     *  @param  string  $msg    message
     *  @return string
     */
    public static function blueMessage (string $msg) {
        return static::dyeMessage($msg, 4);
    }

    /**
     *  Return the message in purple
     *  @param  string  $msg    message
     *  @return string
     */
    public static function purpleMessage (string $msg) {
        return static::dyeMessage($msg, 5);
    }

    /**
     *  Return the message in cyan
     *  @param  string  $msg    message
     *  @return string
     */
    public static function cyanMessage (string $msg) {
        return static::dyeMessage($msg, 6);
    }

    /**
     *  Return the message in white
     *  @param  string  $msg    message
     *  @return string
     */
    public static function whiteMessage (string $msg) {
        return static::dyeMessage($msg, 7);
    }

    /**
     *  Return the message with black background
     *  @param  string  $msg    message
     *  @return string
     */
    public static function blackBackground (string $msg) {
        return static::dyeBackGround($msg, 0);
    }

    /**
     *  Return the message with red background
     *  @param  string  $msg    message
     *  @return string
     */
    public static function redBackground (string $msg) {
        return static::dyeBackGround($msg, 1);
    }

    /**
     *  Return the message with green background
     *  @param  string  $msg    message
     *  @return string
     */
    public static function greenBackground (string $msg) {
        return static::dyeBackGround($msg, 2);
    }

    /**
     *  Return the message with yellow background
     *  @param  string  $msg    message
     *  @return string
     */
    public static function yellowBackground (string $msg) {
        return static::dyeBackGround($msg, 3);
    }

    /**
     *  Return the message with blue background
     *  @param  string  $msg    message
     *  @return string
     */
    public static function blueBackground (string $msg) {
        return static::dyeBackGround($msg, 4);
    }

    /**
     *  Return the message with purple background
     *  @param  string  $msg    message
     *  @return string
     */
    public static function purpleBackground (string $msg) {
        return static::dyeBackGround($msg, 5);
    }

    /**
     *  Return the message with cyan background
     *  @param  string  $msg    message
     *  @return string
     */
    public static function cyanBackground (string $msg) {
        return static::dyeBackGround($msg, 6);
    }

    /**
     *  Return the message with white background
     *  @param  string  $msg    message
     *  @return string
     */
    public static function whiteBackground (string $msg) {
        return static::dyeBackGround($msg, 7);
    }

    /**
     *  Return the message in the given color
     *  @param  string  $msg    message
     *  @param  int $clrIdx color index (0-7)
     *  @return string
     */
    public static function dyeMessage (string $msg, int $clrIdx) {
        return "\e[3$clrIdx" . "m$msg\e[0m";
    }

    /**
     *  Return the message with background in the given color
     *  @param  string  $msg    message
     *  @param  int $clrIdx color index (0-7)
     *  @return string
     */
    public static function dyeBackground (string $msg, int $clrIdx) {
        return "\e[4$clrIdx" . "m$msg\e[0m";
    }

    /**
     *  Return the message with itself and background in the given colors
     *  @param  string  $msg    message
     *  @param  int $msgClrIdx  color index for the message (0-7)
     *  @param  int $bgClrIdx   color index for the background (0-7)
     */
    public static function dye (string $msg, int $msgClrIdx, int $bgClrIdx) {
        return (
            static::dyeBackGround(
                static::dyeMessage($msg, $msgClrIdx),
                $bgClrIdx
            )
        );
    }
}
