<?php
namespace App\Utility;

class UniversalTimer {

    /**
     *  This UniversalTimer utility class represents a single timer living
     *  through the runtime.
     *
     *  Functions:
     *      static start
     *      static clear
     *      static restart
     *      static pause
     *      static resume
     *      static lap
     *      static total
     *      static summarize
     */

    /** Stored timer */
    private static $tmr;

    /**
     *  Start the timer if not started yet
     */
    public static function start () {
        static::getTimer()->start();
    }

    /**
     *  Clear the timer
     */
    public static function clear () {
        static::getTimer()->clear();
    }

    /**
     *  Resume the timer if started; start the timer otherwise
     */
    public static function restart () {
        static::getTimer()->restart();
    }

    /**
     *  Pause the timer
     */
    public static function pause () {
        static::getTimer()->pause();
    }

    /**
     *  Resume the timer
     */
    public static function resume () {
        static::getTimer()->resume();
    }

    /**
     *  Return the duration since the last lap; "N/A" if the timer has
     *  not started
     *  @return string
     */
    public static function lap () {
        return static::getTimer()->lap();
    }

    /**
     *  Return the duration since the timer started; "N/A" if the timer has
     *  not started
     *  @return string
     */
    public static function total () {
        return static::getTimer()->total();
    }

    /**
     *  Lap the timer and return a summary of the timer
     *  @format
     *  "[Now: <current time> | Lap: <lap duration> | Total: <total duration>]"
     *  @return string
     */
    public static function summarize () {
        return static::getTimer()->summarize();
    }

    /**
     *  Return the stored timer
     */
    private static function getTimer () {
        if (!isset(static::$tmr)) {
            static::$tmr = Timer::make();
        }

        return static::$tmr;
    }
}
