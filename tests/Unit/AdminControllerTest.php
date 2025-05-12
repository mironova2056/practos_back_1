<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use Validation\UserValidator;
use Model\User;
use Model\Role;
use Src\Request;
use Controller\Admin;
use Src\Auth\Auth;
use Src\Session;
use Illuminate\Database\Capsule\Manager as DB;

class AdminControllerTest extends TestCase
{
    protected $adminController;
    protected $mockValidator;
    protected $mockUser;
    protected $mockRole;
    protected $mockAuth;

    protected function setUp(): void
    {
        m::close();

        // Инициализация Eloquent без реального подключения к БД
        $db = new DB;
        $db->addConnection(['driver' => 'sqlite', ':memory:']);
        $db->setAsGlobal();
        $db->bootEloquent();

        // Мокируем необходимые классы
        $this->mockValidator = m::mock(UserValidator::class);
        $this->mockUser = m::mock(User::class)->makePartial();
        $this->mockRole = m::mock(Role::class);

        // Мокируем Auth
        $this->mockAuth = m::mock('overload:Src\Auth\Auth');
        $this->mockAuth->shouldReceive('check')->andReturn(true);
        $this->mockAuth->shouldReceive('user')->andReturn((object)['id_role' => 1]);

        // Мокируем Session
        $this->sessionMock = m::mock('overload:Src\Session');
        $this->sessionMock->shouldReceive('get')->andReturnNull();
        $this->sessionMock->shouldReceive('set');

        // Создаем экземпляр контроллера
        $this->adminController = new Admin($this->mockValidator);
    }

    protected function tearDown(): void
    {
        m::close();
        DB::connection()->disconnect();
        if (ob_get_level() > 0) ob_end_clean();
    }

    private function callPrivateMethod($object, $methodName, array $params = [])
    {
        $class = new \ReflectionClass(get_class($object));
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $params);
    }

    public function testCreateUserSuccess()
    {
        $testData = [
            'login' => 'testuser',
            'password' => 'password123',
            'id_role' => 1
        ];

        $this->mockUser->shouldReceive('create')
            ->once()
            ->with($testData)
            ->andReturn($this->mockUser);

        $this->mockUser->shouldReceive('exists')
            ->once()
            ->andReturn(true);

        $this->sessionMock->shouldReceive('set')
            ->with('success', m::type('string'));

        $result = $this->callPrivateMethod(
            $this->adminController,
            'createUser',
            [$testData]
        );

        $this->assertTrue($result);
    }

    public function testCreateUserWithDuplicateLogin()
    {
        $testData = [
            'login' => 'admin',
            'password' => 'password123',
            'id_role' => 1
        ];

        $this->mockValidator->shouldReceive('validate')
            ->once()
            ->with($testData)
            ->andReturn(false);

        $this->mockValidator->shouldReceive('getErrors')
            ->once()
            ->andReturn(['login' => ['unique' => 'Этот логин уже занят']]);

        $this->sessionMock->shouldReceive('set')
            ->with('errors', ['login' => ['unique' => 'Этот логин уже занят']]);

        $request = m::mock(Request::class);
        $request->shouldReceive('all')->andReturn($testData);
        $request->shouldReceive('has')->with('search')->andReturn(false);
        $request->method = 'POST';

        ob_start();
        $this->adminController->adminDashboard($request);
        $output = ob_get_clean();

        $this->assertEmpty($output);
    }

    public function testShortPasswordValidation()
    {
        $testData = [
            'login' => 'shortpass',
            'password' => '123',
            'id_role' => 2
        ];

        $this->mockValidator->shouldReceive('validate')
            ->once()
            ->with($testData)
            ->andReturn(false);

        $this->mockValidator->shouldReceive('getErrors')
            ->once()
            ->andReturn(['password' => ['min' => 'Пароль должен содержать минимум 6 символов']]);

        $this->sessionMock->shouldReceive('set')
            ->with('errors', ['password' => ['min' => 'Пароль должен содержать минимум 6 символов']]);

        $request = m::mock(Request::class);
        $request->shouldReceive('all')->andReturn($testData);
        $request->shouldReceive('has')->with('search')->andReturn(false);
        $request->method = 'POST';

        ob_start();
        $this->adminController->adminDashboard($request);
        $output = ob_get_clean();

        $this->assertEmpty($output);
    }
}