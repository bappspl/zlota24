<?php 
namespace Offer\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class OfferTable
{
	protected $tableGateway;
  
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 

    public function addOffer(Offer $offer)
    {
    	$data = array(
            'image' => $offer->image,
            'description_1'  => $offer->description_1,
            'description_2'  => $offer->description_2,
            'description_3'  => $offer->description_3,
        );	
        $this->tableGateway->update($data, array('id' => 1));
    }

    public function getById($id)
	{
		$rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
	}
}