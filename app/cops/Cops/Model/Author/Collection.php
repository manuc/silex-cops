<?php
/*
 * This file is part of Silex Cops. Licensed under WTFPL
 *
 * (c) Mathieu Duplouy <mathieu.duplouy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cops\Model\Author;

use Cops\Model\CollectionAbstract;
use Cops\Model\Core;

/**
 * Author collection model
 * @author Mathieu Duplouy <mathieu.duplouy@gmail.com>
 */
class Collection extends CollectionAbstract
{
    /**
     * Get collection based on first letter
     *
     * @param  str        $letter
     *
     * @return Collection
     */
    public function getByFirstLetter($letter)
    {
        $resource = $this->getResource();

        foreach ($resource->loadByFirstLetter($letter) as $result) {
            $this->add($resource->setDataFromStatement($result));
        }
        return $this;
    }

    /**
     * Get collection based on bookId
     *
     * @param  int        $bookId
     *
     * @return Collection
     */
    public function getByBookId($bookId)
    {
        $resource = $this->getResource();

        foreach ($resource->loadByBookId($bookId) as $result) {
            $this->add($resource->setDataFromStatement($result));
        }
        return $this;
    }

    /**
     * Get concatened author's name
     *
     * @return string
     */
    public function getName()
    {
        $name = array();
        foreach($this as $author) {
            $name[] = $author->getName();
        }
        return implode(' & ', $name);
    }

    /**
     * Set sort name for author collection
     *
     * @param  \Cops\Model\Author\Collection $authors
     *
     * @return \Cops\Model\Author\Collection
     */
    public function setSortName()
    {
        $calibre = $this->app['calibre'];

        foreach ($this as &$author) {
            $author->setSort(
                $calibre->getSortName($author->getName())
            );
        }
        return $this;
    }
}
