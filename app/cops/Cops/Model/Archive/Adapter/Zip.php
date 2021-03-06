<?php
/*
 * This file is part of Silex Cops. Licensed under WTFPL
 *
 * (c) Mathieu Duplouy <mathieu.duplouy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cops\Model\Archive\Adapter;

use Cops\Model\ArchiveAbstract;
use Cops\Model\Archive\ArchiveInterface;

/**
 * Archive adapter for zip file
 *
 * @author Mathieu Duplouy <mathieu.duplouy@gmail.com>
 */
class Zip extends ArchiveAbstract implements ArchiveInterface
{
    /**
     * Generate archive
     *
     * @return string The path to archive file
     */
    public function generateArchive()
    {
        $archive = tempnam(sys_get_temp_dir(), '').$this->getExtension();

        $zip = new \ZipArchive;
        if ($zip->open($archive, \ZipArchive::CREATE)) {
            foreach ($this->_files as $file) {
                if (file_exists($file->getFilePath())) {
                    $zip->addFile($file->getFilePath(), $file->getFileName());
                }
            }
            $zip->close();
        }

        return $archive;
    }

    /**
     * Get file extension
     *
     * @implements ArchiveInterface
     *
     * @return string
     */
    public function getExtension()
    {
        return '.zip';
    }
}