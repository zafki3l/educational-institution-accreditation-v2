<?php

namespace Tests\Unit\Modules\DepartmentManagement\Domain\Entities;

use App\Modules\DepartmentManagement\Domain\Entities\Department;
use App\Modules\DepartmentManagement\Domain\Exception\EmptyDepartmentIdException;
use App\Modules\DepartmentManagement\Domain\Exception\EmptyDepartmentNameException;
use PHPUnit\Framework\TestCase;

class DepartmentTest extends TestCase
{
    public function testCanBeCreatedWithValidData(): void
    {
        $id = 'DEPT-001';
        $name = 'Phòng Kỹ Thuật';

        $department = Department::create($id, $name);

        $this->assertInstanceOf(Department::class, $department);
        $this->assertEquals($id, $department->getId());
        $this->assertEquals($name, $department->getName());
        $this->assertEmpty($department->getChanges());
    }

    public function testThrowsExceptionWhenIdIsEmpty(): void
    {
        $this->expectException(EmptyDepartmentIdException::class);

        Department::create('', 'Phòng Kỹ Thuật');
    }

    public function testThrowsExceptionWhenNameIsEmpty(): void
    {
        $this->expectException(EmptyDepartmentNameException::class);

        Department::create('DEPT-001', '');
    }

    public function testUpdateNameSuccessfully(): void
    {
        $oldName = 'Phòng Cũ';
        $newName = 'Phòng Mới';
        $department = Department::create('DEPT-001', $oldName);

        $department->update($newName);

        $this->assertEquals($newName, $department->getName());
        
        $changes = $department->getChanges();
        $this->assertArrayHasKey('name', $changes);
        $this->assertEquals($oldName, $changes['name']['old']);
        $this->assertEquals($newName, $changes['name']['new']);
    }

    public function testUpdateThrowsExceptionWhenNameIsEmpty(): void
    {
        $department = Department::create('DEPT-001', 'Phòng Kỹ Thuật');

        $this->expectException(EmptyDepartmentNameException::class);

        $department->update('');
    }
}