<?php
namespace App\Utility;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class Timer {

    /**
     *  This Timer utility class represents a timer which records durations and
     *  returns summary of itself.
     *
     *  Functions:
     *      static make
     *      start
     *      clear
     *      restart
     *      pause
     *      resume
     *      lap
     *      total
     *      summarize
     */

    /** Path to the config file */
    private const CONFIG_FILE_PATH = "app/Utility/Config/timer.ini";

    /** Color index (0-7) of the timer message */
    private static $tmrMsgClrIdx;

    /** Color index (0-7) of the background of the timer message */
    private static $tmrBgClrIdx;

    /** Timestamp recorded when the timer starts*/
    private $iniTmstmp;

    /** Timestamp recorded when a lap is triggered */
    private $lapTmstmp;

    /** Whether the timer is started */
    private $started;

    /** Whether the timer is running */
    private $run;

    /**
     *  Return a new instance of Timer
     */
    public static function make () {
        return new static;
    }

    /**
     *  Start the timer if not started yet
     */
    public function start () {
        if (!$this->started) {
            $this->restart();
        }
    }

    /**
     *  Clear the timer
     */
    public function clear () {
        $this->iniTmstmp = null;
        $this->lapTmstmp = null;
        $this->started = false;
        $this->pause();
    }

    /**
     *  Restart the timer
     */
    public function restart () {
        $this->iniTmstmp = now();
        $this->lapTmstmp = now();
        $this->started = true;
        $this->run = true;
    }

    /**
     *  Pause the timer
     */
    public function pause () {
        $this->run = false;
    }

    /**
     *  Resume the timer if started; start the timer otherwise
     */
    public function resume () {
        if ($this->started) {
            $this->run = true;
            $this->lapTmstmp = now();

        } else {
            $this->restart();
        }
    }

    /**
     *  Return the duration since the last lap; "N/A" if the timer has
     *  not started
     *  @return string
     */
    public function lap () {
        $lapDur = $this->since($this->lapTmstmp);

        if ($this->run) {
            $this->lapTmstmp = now();
        }

        return $lapDur;
    }

    /**
     *  Return the duration since the timer started; "N/A" if the timer has
     *  not started
     *  @return string
     */
    public function total () {
        return $this->since($this->iniTmstmp);
    }

    /**
     *  Lap the timer and return a summary of the timer
     *  @format
     *  "[Now: <current time> | Lap: <lap duration> | Total: <total duration>]"
     *  @return string
     */
    public function summarize () {
        $currTm = now()->format("m-d-Y H:i:s");
        $lapDur = $this->lap();
        $ttlDur = $this->total();
        $msg = "[Now: $currTm | Lap: $lapDur | Total: $ttlDur]";

        return Dye::dye($msg, static::$tmrMsgClrIdx, static::$tmrBgClrIdx);
    }

    /**
     *  Return the duration since the given time; "N/A" if the timer has not
     *  started
     *  @param  Carbon|null $tmstmp a timestamp
     *  @return string
     */
    private function since (Carbon $tmstmp = null) {
        if (!isset($tmstmp)) {
            return "N/A";
        }

        $now = ($this->run) ? now() : $this->lapTmstmp;
        return date_diff($tmstmp, $now)->format("%h h %i min %s s");
    }

    /**
     *  Construct a new instance of Timer
     */
    private function __construct () {
        if (!isset(static::$tmrMsgClrIdx) || !isset(static::$tmrBgClrIdx)) {
            $cfgLst = parse_ini_string(File::get(self::CONFIG_FILE_PATH));
            static::$tmrMsgClrIdx = $cfgLst["tmrMsgClrIdx"];
            static::$tmrBgClrIdx = $cfgLst["tmrBgClrIdx"];
        }

        $this->clear();
    }
}
