<?php
/*
 * This file is part of Silex Cops. Licensed under WTFPL
 *
 * (c) Mathieu Duplouy <mathieu.duplouy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cops\Model\ImageProcessor\Adapter;

use Cops\Model\ImageProcessor\ImageProcessorInterface;
use Cops\Model\ImageProcessor\ImageProcessorAbstract;
use Cops\Exception\ImageProcessor\AdapterException;

/**
 * Imagick processing class
 *
 * @author Mathieu Duplouy <mathieu.duplouy@gmail.com>
 */
class Imagick extends ImageProcessorAbstract implements ImageProcessorInterface
{
    /**
     * Constructor
     *
     * @throws \Cops\Exception\ImageProcessor\AdapterException
     */
    public function __construct()
    {
        if (!extension_loaded('imagick')) {
            throw new AdapterException('Please install php5-imagick module before using it');
        }
    }

    /**
     * Generate a thumbnail for image
     *
     * @param string $src    The source image file path
     * @param string $dest   The target image file path
     * @param array  $params Options
     */
    public function generateThumbnail($src, $dest, array $params=array())
    {
        if (isset($params['width'])) {
            $this->setWidth($params['width']);
        }
        if (isset($params['height'])) {
            $this->setHeight($params['height']);
        }

        $imagick = new \Imagick($src);
        $imagick->setImageResolution (92, 92);
        $imagick->setImageCompression(\Imagick::COMPRESSION_ZIP);
        $imagick->setImageCompressionQuality(85);
        $imagick->thumbnailImage(
            $this->getWidth(),
            $this->getHeight(),
            true,
            false
        );
        $imagick->stripImage();
        $imagick->writeImage($dest);
    }

}
