<?php
namespace Courses\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class JpositionTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getJposition($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) { 
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveJposition(Jposition $jposition)
    {
        $data = [
            'strEmpPosition' => $jposition->strEmpPosition,
            
        ];

        $id = (int) $jposition->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getJposition($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update position with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteJposition($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
?>