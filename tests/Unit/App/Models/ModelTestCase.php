<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase {
    abstract protected function model(): Model;
    abstract protected function traits(): array;
    abstract protected function fillables(): array;
    abstract protected function hidden(): array;
    abstract protected function casts(): array;
    abstract protected function incrementing(): bool;

    public function test_it_should_implement_traits()
    {
        $traitsNeeded = $this->traits();

        $traitsUsed = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeeded, $traitsUsed);
    }

    public function test_it_should_not_increment_ids()
    {
        $model = $this->model();

        $this->assertFalse($this->incrementing());
    }

    public function test_it_should_have_corret_fillables()
    {
        $model = $this->model();
        $fillableUsed = $model->getFillable();

        $fillableNeeded = $this->fillables();

        $this->assertEquals($fillableUsed, $fillableNeeded);
    }

    public function test_it_should_hide_correct_attributes()
    {
        $model = $this->model();
        $hidded = $model->getHidden();

        $hiddenNeeded = $this->hidden();

        $this->assertEquals($hiddenNeeded, $hidded);
    }

    public function test_it_should_casts_correctly()
    {
        $model = $this->model();
        $casts = $model->getCasts();

        $castNeeded = $this->casts();

        $this->assertEquals($castNeeded, $casts);
    }
}
