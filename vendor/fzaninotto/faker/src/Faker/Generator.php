text/vnd.in3d.3dml'                                                        => '3dml',
        'text/vnd.in3d.spot'                                                        => 'spot',
        'text/vnd.sun.j2me.app-descriptor'                                          => 'jad',
        'text/vnd.wap.wml'                                                          => 'wml',
        'text/vnd.wap.wmlscript'                                                    => 'wmls',
        'text/x-asm'                                                                => array('s', 'asm'),
        'text/x-fortran'                                                            => array('f', 'for', 'f77', 'f90'),
        'text/x-java-source'                                                        => 'java',
        'text/x-opml'                                                               => 'opml',
        'text/x-pascal'                                                             => array('p', 'pas'),
        'text/x-nfo'                                                                => 'nfo',
        'text/x-setext'                                                             => 'etx',
        'text/x-sfv'                                                                => 'sfv',
        'text/x-uuencode'                                                           => 'uu',
        'text/x-vcalendar'                                                          => 'vcs',
        'text/x-vcard'                                                              => 'vcf',
        'video/3gpp'                                                                => '3gp',
        'video/3gpp2'                                                               => '3g2',
        'video/h261'                                                                => 'h261',
        'video/h263'                                                                => 'h263',
        'video/h264'                                                                => 'h264',
        'video/jpeg'                                                                => 'jpgv',
        'video/jpm'                                                                 => array('jpm', 'jpgm'),
        'video/mj2'                                                                 => 'mj2',
        'video/mp4'                                                                 => 'mp4',
        'video/mpeg'                                                                => array('mpeg', 'mpg', 'mpe', 'm1v', 'm2v'),
        'video/ogg'                                                                 => 'ogv',
        'video/quicktime'                                                           => array('qt', 'mov'),
        'video/vnd.dece.hd'                                                         => array('uvh', 'uvvh'),
        'video/vnd.dece.mobile'                                                     => array('uvm', 'uvvm'),
        'video/vnd.dece.pd'                                                         => array('uvp', 'uvvp'),
        'video/vnd.dece.sd'                                                         => array('uvs', 'uvvs'),
        'video/vnd.dece.video'                                                      => array('uvv', 'uvvv'),
        'video/vnd.dvb.file'                                                        => 'dvb',
        'video/vnd.fvt'                                                             => 'fvt',
        'video/vnd.mpegurl'                                                         => array('mxu', 'm4u'),
        'video/vnd.ms-playready.media.pyv'                                          => 'pyv',
        'video/vnd.uvvu.mp4'                                                        => array('uvu', 'uvvu'),
        'video/vnd.vivo'                                                            => 'viv',
        'video/webm'                                                                => 'webm',
        'video/x-f4v'                                                               => 'f4v',
        'video/x-fli'                                                               => 'fli',
        'video/x-flv'                                                               => 'flv',
        'video/x-m4v'                                                               => 'm4v',
        'video/x-matroska'                                                          => array('mkv', 'mk3d', 'mks'),
        'video/x-mng'                                                               => 'mng',
        'video/x-ms-asf'                                                            => array('asf', 'asx'),
        'video/x-ms-vob'                                                            => 'vob',
        'video/x-ms-wm'                                                             => 'wm',
        'video/x-ms-wmv'                                                            => 'wmv',
        'video/x-ms-wmx'                                                            => 'wmx',
        'video/x-ms-wvx'                                                            => 'wvx',
        'video/x-msvideo'                                                           => 'avi',
        'video/x-sgi-movie'                                                         => 'movie',
    );

    /**
     * Get a random MIME type
     *
     * @return string
     * @example 'video/avi'
     */
    public static function mimeType()
    {
        return static::randomElement(array_keys(static::$mimeTypes));
    }

    /**
     * Get a random file extension (without a dot)
     *
     * @example avi
     * @return string
     */
    public static function fileExtension()
    {
        $random_extension = static::randomElement(array_values(static::$mimeTypes));

        return is_array($random_extension) ? static::randomElement($random_extension) : $random_extension;
    }

    /**
     * Copy a random file from the source directory to the target directory and returns the filename/fullpath
     *
     * @param  string  $sourceDirectory The directory to look for random file taking
     * @param  string  $targetDirectory
     * @param  boolean $fullPath        Whether to have the full path or just the filename
     * @return string
     */
    public static function file($sourceDirectory = '/tmp', $targetDirectory = '/tmp', $fullPath = true)
    {
        if (!is_dir($sourceDirectory)) {
            throw new \InvalidArgumentException(sprintf('Source directory %s does not exist or is not a directory.', $sourceDirectory));
        }

        if (!is_dir($targetDirectory)) {
            throw new \InvalidArgumentException(sprintf('Target directory %s does not exist or is not a directory.', $targetDirectory));
        }

        if ($sourceDirectory == $targetDirectory) {
            throw new \InvalidArgumentException('Source and target directories must differ.');
        }

        // Drop . and .. and reset array keys
        $files = array_filter(array_values(array_diff(scandir($sourceDirectory), array('.', '..'))), function ($file) use ($sourceDirectory) {
            return is_file($sourceDirectory . DIRECTORY_SEPARATOR . $file) && is_readable($sourceDirectory . DIRECTORY_SEPARATOR . $file);
        });

        if (empty($files)) {
            throw new \InvalidArgumentException(sprintf('Source directory %s is empty.', $sourceDirectory));
        }

        $sourceFullPath = $sourceDirectory . DIRECTORY_SEPARATOR . static::randomElement($files);

        $destinationFile = Uuid::uuid() . '.' . pathinfo($sourceFullPath, PATHINFO_EXTENSION);
        $destinationFullPath = $targetDirectory . DIRECTORY_SEPARATOR . $destinationFile;

        if (false === copy($sourceFullPath, $destinationFullPath)) {
            return false;
        }

        return $fullPath ? $destinationFullPath : $destinationFile;
    }
}
                                                                                                                                                                                                                                                                                                  <?php

namespace Faker\Provider;

use Faker\Generator;
use Faker\UniqueGenerator;

class HtmlLorem extends Base
{

    const HTML_TAG = "html";
    const HEAD_TAG = "head";
    const BODY_TAG = "body";
    const DIV_TAG = "div";
    const P_TAG = "p";
    const A_TAG = "a";
    const SPAN_TAG = "span";
    const TABLE_TAG = "table";
    const THEAD_TAG = "thead";
    const TBODY_TAG = "tbody";
    const TR_TAG = "tr";
    const TD_TAG = "td";
    const TH_TAG = "th";
    const UL_TAG = "ul";
    const LI_TAG = "li";
    const H_TAG = "h";
    const B_TAG = "b";
    const I_TAG = "i";
    const TITLE_TAG = "title";
    const FORM_TAG = "form";
    const INPUT_TAG = "input";
    const LABEL_TAG = "label";

    private $idGenerator;

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
        $generator->addProvider(new Lorem($generator));
        $generator->addProvider(new Internet($generator));
    }

    /**
     * @param integer $maxDepth
     * @param integer $maxWidth
     *
     * @return string
     */
    public function randomHtml($maxDepth = 4, $maxWidth = 4)
    {
