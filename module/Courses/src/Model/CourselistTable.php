<?php
namespace Courses\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class CourselistTable
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

    public function getCourselist($id)
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

    public function saveCourselist(Courselist $courselist)
    {
        $data = [
            'strCourseDescription' => $courselist->strCourseDescription,
            'curCourseCost'  => $courselist->curCourseCost,
            'intCourseDurationYears' => $courselist->intCourseDurationYears,
            'memNotes'  => $courselist->memNotes,
        ];

        $id = (int) $courselist->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getCourselist($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update course with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteCourselist($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
?>