<?php
namespace App\Utility;

use Illuminate\Support\Facades\File;

class CompanyLogo {

    /**
     *  This CompanyLogo utility class returns a string representing the saic
     *  company logo.
     *
     *  Functions:
     *      static getCompanyLogo
     */

    /** Path to the source file */
    private const COMPANY_LOGO_PATH = "app/Utility/Config/company_logo.txt";

    /** Company logo */
    private static $compLogo;

    /**
     *  Return the company logo
     *  @return string
     */
    public static function getCompanyLogo () {
        if (!isset(static::$compLogo)) {
            $src = File::get(self::COMPANY_LOGO_PATH);
            $rowRawLst = preg_split("/[\r\n]+/", $src);
            array_pop($rowRawLst); // Get rid of the empty row in the end
            $rowLst = [];

            foreach ($rowRawLst as $rowRaw) {
                $ptRawLst = explode(",", $rowRaw);
                $ptLst = [];

                foreach ($ptRawLst as $ptRaw) {
                    $ptLst[] = Dye::dyeBackGround(" ", ((int) $ptRaw));
                }

                $rowLst[] = implode("", $ptLst);
            }

            static::$compLogo = implode("\n", $rowLst);
        }

        return static::$compLogo;
    }
}
