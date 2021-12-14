<?php

namespace Shield1739\UTP\CitasCss\core\common;

use Shield1739\UTP\CitasCss\tests\AppTestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class ModelTest extends AppTestCase
{
    protected $model;

    protected function tearDown(): void
    {
        $this->model->getPdoUtils()->rollback();
    }

    private function createFullModel()
    {
        $this->model = new class extends Model {
            public ?string $required;
            public ?string $requiredWhen;
            public bool $requiredWhenTest;
            public ?string $email;
            public ?string $cedula;
            public ?string $min;
            public ?string $max;
            public ?string $password_matchA;
            public ?string $password_matchB;
            public ?string $citaCodigoSeguimineto; //unique
            public ?string $workDay;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->required = null;
                $this->requiredWhen = null;
                $this->requiredWhenTest = false;
                $this->email = null;
                $this->cedula = null;
                $this->min = null;
                $this->max = null;
                $this->password_matchA = null;
                $this->password_matchB = null;
                $this->citaCodigoSeguimineto = null;
                $this->workDay = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'required',
                        'requiredWhen',
                        'email',
                        'cedula',
                        'min',
                        'max',
                        'password_matchA',
                        'password_matchB',
                        'unique',
                        'workDay'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'required' => [self::RULE_REQUIRED],
                        'requiredWhen' => [[self::RULE_REQUIRED_WHEN, 'when' => $this->requiredWhenTest]],
                        'email' => [self::RULE_EMAIL],
                        'cedula' => [self::RULE_CEDULA],
                        'min' => [[self::RULE_MIN, 'min' => 5]],
                        'max' => [[self::RULE_MAX, 'max' => 5]],
                        'password_matchB' => [self::RULE_REQUIRED, [self::RULE_PASSWORD_MATCH, 'passwordField' => 'password_matchA']],
                        'citaCodigoSeguimineto' => [[self::RULE_UNIQUE, 'tableName' => 'cita', 'field' => 'citaCodigoSeguimineto']],
                        'workDay' => [self::RULE_WORK_DAY]
                    ]
                ];
            }
        };
    }

    public function testLoadData()
    {
        $this->createFullModel();
        $this->model->getPdoUtils()->beginTransaction();

        assertNull($this->model->required);
        assertNull($this->model->cedula);
        assertNull($this->model->workDay);

        $data = [
            'required' => 'testA',
            'cedula' => 'testB',
            'workDay' => 'testC'
        ];

        $this->model->loadData($data);

        assertEquals('testA', $this->model->required);
        assertEquals('testB', $this->model->cedula);
        assertEquals('testC', $this->model->workDay);
    }

    public function testValidate()
    {
        $this->createFullModel();
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->required = 'asd';
        $this->model->requiredWhen = 'asdas';
        $this->model->requiredWhenTest = true;
        $this->model->email = 'a@a.com';
        $this->model->cedula = '1-234-5678';
        $this->model->min = '123456';
        $this->model->max = '1234';
        $this->model->password_matchA = 'abc';
        $this->model->password_matchB = 'abc';
        $this->model->citaCodigoSeguimineto = 'ZZZZZZ';
        $this->model->workDay = '2021/12/13';

        assertTrue($this->model->validate());
    }

    public function testValidateRequired()
    {
        $this->model = new class extends Model {
            public ?string $required;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->required = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'required'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'required' => [self::RULE_REQUIRED]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->required = null;
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('required'));

        $this->model->required = '';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('required'));

        $this->model->required = 'aaaa';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('required'));
    }

    public function testValidateRequiredWhen()
    {
        $this->model = new class extends Model {
            public ?string $requiredWhen;
            public bool $requiredWhenTest;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->requiredWhen = null;
                $this->requiredWhenTest = false;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'requiredWhen'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'requiredWhen' => [[self::RULE_REQUIRED_WHEN, 'when' => $this->requiredWhenTest]]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();
        $this->model->requiredWhenTest = true;

        $this->model->requiredWhen = null;
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('requiredWhen'));

        $this->model->requiredWhen = '';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('requiredWhen'));

        $this->model->requiredWhen = 'aaaa';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('requiredWhen'));
    }

    public function testValidateEmail()
    {
        $this->model = new class extends Model {
            public ?string $email;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->email = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'email'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'email' => [self::RULE_EMAIL]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->email = null;
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('email'));

        $this->model->email = '';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('email'));

        $this->model->email = 'aaaa';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('email'));

        $this->model->email = 'aa@';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('email'));

        $this->model->email = 'aaaa@aaa';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('email'));

        $this->model->email = 'aa@aa.aa';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('email'));
    }

    public function testValidateCedula() // Extensively tested at Utilities
    {
        $this->model = new class extends Model {
            public ?string $cedula;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->cedula = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'cedula'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'cedula' => [self::RULE_CEDULA]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->cedula = '';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('cedula'));

        $this->model->cedula = '111';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('cedula'));

        $this->model->cedula = '11-11-123';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('cedula'));
    }

    public function testValidateMin() // Min 5
    {
        $this->model = new class extends Model {
            public ?string $min;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->min = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'min'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'min' => [[self::RULE_MIN, 'min' => 5]]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->min = null;
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('min'));

        $this->model->min = '';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('min'));

        $this->model->min = '1234';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('min'));

        $this->model->min = '12345';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('min'));
    }

    public function testValidateMax() // Max 5
    {
        $this->model = new class extends Model {
            public ?string $max;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->max = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'max'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'max' => [[self::RULE_MAX, 'max' => 5]]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->max = '123456';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('max'));

        $this->model->max = null;
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('max'));

        $this->model->max = '';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('max'));

        $this->model->max = '12345';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('max'));
    }

    public function testValidatePasswordMatch()
    {
        $this->model = new class extends Model {

            public ?string $password_matchA;
            public ?string $password_matchB;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->password_matchA = null;
                $this->password_matchB = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'password_matchA',
                        'password_matchB'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'password_matchB' => [self::RULE_REQUIRED, [self::RULE_PASSWORD_MATCH, 'passwordField' => 'password_matchA']]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->password_matchA = 'AA';
        $this->model->password_matchB = 'BB';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('password_matchB'));

        $this->model->password_matchA = 'Aa';
        $this->model->password_matchB = 'AA';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('password_matchB'));

        $this->model->password_matchA = 'bbb';
        $this->model->password_matchB = 'bbb';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('password_matchB'));
    }

    public function testValidateUnique() // citaCodigoSeguimineto
    {
        $this->model = new class extends Model {
            public ?string $citaCodigoSeguimineto; //unique

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->citaCodigoSeguimineto = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'unique'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'citaCodigoSeguimineto' => [[self::RULE_UNIQUE, 'tableName' => 'cita', 'field' => 'citaCodigoSeguimineto']]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->citaCodigoSeguimineto = 'ABCDFG';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('citaCodigoSeguimineto'));

        $this->model->citaCodigoSeguimineto = 'AABBCC';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('citaCodigoSeguimineto'));

        $this->model->citaCodigoSeguimineto = 'ZZZZZZ';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('citaCodigoSeguimineto'));
    }

    public function testValidateWorkDay()
    {
        $this->model = new class extends Model {
            public ?string $workDay;

            /**
             * @inheritDoc
             */
            public function init()
            {
                $this->workDay = null;
            }

            /**
             * @inheritDoc
             */
            public function getAllAttributes(): array
            {
                return [
                    self::MODEL_KEY => [
                        'workDay'
                    ]
                ];
            }

            /**
             * @inheritDoc
             */
            public function getRules(): array
            {
                return [
                    self::MODEL_KEY => [
                        'workDay' => [self::RULE_WORK_DAY]
                    ]
                ];
            }
        };
        $this->model->getPdoUtils()->beginTransaction();

        $this->model->workDay = '2021/12/12';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('workDay'));

        $this->model->workDay = '2021/12/18';
        assertFalse($this->model->validate());
        assertTrue($this->model->hasError('workDay'));

        $this->model->workDay = '2021/12/17';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('workDay'));

        $this->model->workDay = '2021/12/13';
        assertTrue($this->model->validate());
        assertFalse($this->model->hasError('workDay'));
    }
}