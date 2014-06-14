<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	protected $offerTable;

	public function getOfferTable()
    {
        if (!$this->offerTable) {
            $sm = $this->getServiceLocator();
            $this->offerTable = $sm->get('Offer\Model\OfferTable');
        } 
        return $this->offerTable;
    }

    protected $extraTable;

	public function getExtraTable()
    {
        if (!$this->extraTable) {
            $sm = $this->getServiceLocator();
            $this->extraTable = $sm->get('Extra\Model\ExtraTable');
        } 
        return $this->extraTable;
    }

    protected $galleryTable;
    public function getGalleryTable()
    {
        if (!$this->galleryTable) {
            $sm = $this->getServiceLocator();
            $this->galleryTable = $sm->get('Gallery\Model\GalleryTable');
        } 
        return $this->galleryTable;
    }
    protected $photosTable;
    public function getPhotosTable()
    {
        if (!$this->photosTable) {
            $sm = $this->getServiceLocator();
            $this->photosTable = $sm->get('Gallery\Model\PhotosTable');
        } 
        return $this->photosTable;
    }
    protected $galleryiconTable;
    public function getGalleryiconTable()
    {
        if (!$this->galleryiconTable) {
            $sm = $this->getServiceLocator();
            $this->galleryiconTable = $sm->get('Gallery\Model\GalleryiconTable');
        } 
        return $this->galleryiconTable;
    }
    protected $videoTable;
    public function getVideoTable()
    {
        if (!$this->videoTable) {
            $sm = $this->getServiceLocator();
            $this->videoTable = $sm->get('Video\Model\VideoTable');
        } 
        return $this->videoTable;
    }
    protected $crossimagesTable;
    public function getCrossimagesTable()
    {
        if (!$this->crossimagesTable) {
            $sm = $this->getServiceLocator();
            $this->crossimagesTable = $sm->get('Crossimages\Model\CrossimagesTable');
        } 
        return $this->crossimagesTable;
    }
    protected $tagsTable;
    public function getTagsTable()
    {
        if (!$this->tagsTable) {
            $sm = $this->getServiceLocator();
            $this->tagsTable = $sm->get('Tags\Model\TagsTable');
        } 
        return $this->tagsTable;
    }

    public function indexAction()
    {
    	$offer = $this->getOfferTable()->getById(1);
    	$extra = $this->getExtraTable()->getById(1);

        // gallery data
        $galleries = $this->getGalleryTable()->getAllGalleries();
        $galleries2 = $this->getGalleryTable()->getAllGalleries();
        $galleryArray = array();
        foreach ($galleries2 as $key => $gallery) {
            $photos = $this->getPhotosTable()->getAllPhotosById($gallery->id);
            $icons = $this->getGalleryiconTable()->getAllIconsById($gallery->id);

            $tmp = array(
                'id' => $gallery->id,
                'name' => $gallery->name,
                'description' => $gallery->description,
                'photos' => $photos,
                'icons' => $icons
            );
            array_push($galleryArray, $tmp);
        }
       
        $galleriesNames = $this->getGalleryTable()->getAllGalleriesName();

        //video 
        $videoData = $this->getVideoTable()->getVideoData();

        //crossimages
        $allCrossimages = $this->getCrossimagesTable()->getAllCrossimages();
        $crossimagesArray = array();
        foreach ($allCrossimages as $key => $crossimage) {
            $tmp = array(
                'first_row' => $crossimage->first_row,
                'second_row' => $crossimage->second_row,
                'image' => $crossimage->image
            );
            array_push($crossimagesArray, $tmp);
        }

        //tags
        $tagsList = $this->getTagsTable()->getAllTags();
        $tagers = array();
        foreach ($tagsList as $key => $tag) {
            array_push($tagers, $tag->name);
        }
        $tags = implode(', ', $tagers);
       	return new ViewModel(array('offer' => $offer,
       							   'extra' => $extra,
                                   'galleries' => $galleries,
                                   'galleriesData' => $galleryArray,
                                   'galleriesName' => $galleriesNames,
                                   'video' => $videoData->description,
                                   'crossimages' => $crossimagesArray,
                                   'tags' => $tags
       	));    
    }    
}
