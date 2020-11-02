<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Modules\Education\Entities\Team;
use Modules\Education\Repository\TeamRepository;
use Modules\Education\Services\TeamService;

class TeamsTest extends TestCase
{
    protected $userMock;

    protected function setUp() : void
    {
        parent::setUp();

        $this->mock = Mockery::mock(TeamRepository::class);
    }

    /**
     * Online classes may not have an end date set
     */
    public function testCreateClassWithoutEndDateThenOk()
    {
        $active = true;
        $name = "Turma do curso teste";
        $shift = "Online";
        $start_date = "2020-06-01";
        $end_date = null;
        $course_id = 1;

        $teamFake = new Team;
        $teamFake->id = 1;
        $teamFake->active = $active;
        $teamFake->name = $name;
        $teamFake->shift = $shift;
        $teamFake->start_date = $start_date;
        $teamFake->end_date = $end_date;
        $teamFake->course_id = $course_id;

        $this->mock->shouldReceive('save')->andReturn(true);
        $this->mock->shouldReceive('find')->with(1)->andReturn($teamFake);

        $service = new TeamService($this->mock);

        $team = $service->create(
            $active,
            $name,
            $shift,
            $start_date,
            $end_date,
            $course_id
        );

        $this->assertInstanceOf(Team::class, $team);
        $this->assertEquals($teamFake , $service->find(1));
        $this->assertDatabaseHas('Teams', ['name' => $name]);
    }

    /**
     *
     */
    public function testCreateClassesWithAnEndDateBeforeTheStartDateThenException()
    {
        $active = true;
        $name = "Turma do curso teste";
        $shift = "Online";
        $start_date = "2020-06-02";
        $end_date = "2020-06-01";
        $course_id = 1;

        $teamFake = new Team;
        $teamFake->id = 1;
        $teamFake->active = $active;
        $teamFake->name = $name;
        $teamFake->shift = $shift;
        $teamFake->start_date = $start_date;
        $teamFake->end_date = $end_date;
        $teamFake->course_id = $course_id;

        $service = new TeamService($this->mock);

        $this->expectException(\Exception::class);

        $service->create(
            $active,
            $name,
            $shift,
            $start_date,
            $end_date,
            $course_id
        );

    }
}
