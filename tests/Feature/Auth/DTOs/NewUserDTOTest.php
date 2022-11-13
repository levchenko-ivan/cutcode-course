<?php

namespace Auth\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    public function test_instance_create_form_request()
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => 'test',
            'email' => 'test@email.ru',
            'password' => '12345678',
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
