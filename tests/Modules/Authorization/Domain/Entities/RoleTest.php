<?php

namespace Tests\Modules\Authorization\Domain\Entities;

use App\Modules\Authorization\Domain\Entities\Role;
use App\Modules\Authorization\Domain\Exception\EmptyRoleNameException;
use App\Modules\Authorization\Domain\Exception\RoleIdExistsException;
use PHPUnit\Framework\TestCase;

final class RoleTest extends TestCase
{
    private Role $role;
    private string $expectedName;
    private int $expectedRoleId;
    
    public function setUp(): void
    {
        $this->expectedName = 'Admin';
        $this->expectedRoleId = 3;

        $this->role = Role::create($this->expectedName);
    }
    
    /**
     * Run: composer test -- --filter RoleTest::testGetIdReturnNull
     * @return void
     */
    public function testGetIdReturnNull(): void
    {
        $this->assertNull($this->role->getId());
    }

    /**
     * Run: composer test -- --filter RoleTest::testGetters
     * 
     * @return void
     */
    public function testGetters()
    {
        $this->role->assignId($this->expectedRoleId);

        $this->assertNotNull($this->role->getId());
        $this->assertSame($this->expectedRoleId, $this->role->getId());
        $this->assertSame($this->expectedName, $this->role->getName());
    }

    /**
     * Run: composer test -- --filter RoleTest::testCreateShouldThrowExceptionWhenNameIsEmpty
     * 
     * @return void
     */
    public function testCreateShouldThrowExceptionWhenNameIsEmpty(): void
    {
        $this->expectException(EmptyRoleNameException::class);
        
        Role::create('');
    }

    /**
     * Run: composer test -- --filter RoleTest::testAssignIdShouldThrowExceptionWhenIdAlreadyExists
     * 
     * @return void
     */
    public function testAssignIdShouldThrowExceptionWhenIdAlreadyExists(): void
    {
        $this->role->assignId(1);
        
        $this->expectException(RoleIdExistsException::class);
        
        $this->role->assignId(2);
    }
}