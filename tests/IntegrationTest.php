<?php namespace Minhbang\File\Tests;

use Minhbang\File\Tests\Stubs\IntergrationTestCase;

/**
 * Quản lý File bằng giao diện backend
 * Class IntegrationTest
 * @package Minhbang\File\Tests
 * @author Minh Bang
 */
class IntegrationTest extends IntergrationTestCase
{
    /**
     * User bình thường truy cập trang quản lý file
     */
    public function testUserAccessEnumManagementPage()
    {
        $response = $this->get('/backend/file');
        // Yêu cầu đăng nhập khi truy cập
        $response->assertRedirect('/auth/login');
    }

    /**
     * Admin truy cập trang quản lý file
     */
    public function testAdminAccessEnumManagementPage()
    {
        // Truy cập bằng quyền Admin
        $response = $this->actingAs($this->users['admin'])->get('/backend/file');
        $response->assertStatus(200);
    }

    /**
     * Super Admin truy cập trang quản lý file
     */
    public function testSuperAdminAccessEnumManagementPage()
    {
        $this->withoutExceptionHandling();
        // Truy cập bằng quyền Super Admin
        $response = $this->actingAs($this->users['super_admin'])->get('/backend/file');
        $response->assertStatus(200);
    }
}