<?php

namespace CardBattleGame\Tests\Unit\Infrastructure\Http;

use CardBattleGame\Application\Command\CreateGame;
use CardBattleGame\Infrastructure\Http\CreateGameController;
use Helmich\Psr7Assert\Psr7Assertions;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Prooph\ServiceBus\CommandBus;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequest;

class CreateGameControllerTest extends TestCase
{
    use Psr7Assertions;

    /** @var CreateGameController */
    private $middleware;
    /** @var ObjectProphecy|CommandBus */
    private $commandBus;

    /** @test */
    public function it_calls_create_game_handler()
    {
        $request = (new ServerRequest())
            ->withMethod('POST')
            ->withParsedBody([
                'playerOnTurnName' => 'Bart',
                'playerWaitingName' => 'Homer',
                'hitPointsPerPlayer' => 20,
                'movePointsPerTurn' => 10,
            ]);

        $this->middleware->process($request, $this->delegate());

        $this->commandBus->dispatch(new CreateGame(
            'Bart',
            'Homer',
            20,
            10
        ))->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_responds_202()
    {
        $response = $this->middleware->process($this->validRequest(), $this->delegate());

        $this->assertResponseHasStatus($response, 202);
    }

    /** @test */
    public function it_is_a_final_middleware()
    {
        /** @var ObjectProphecy|DelegateInterface $delegate */
        $delegate = $this->prophesize(DelegateInterface::class);

        $this->middleware->process($this->validRequest(), $delegate->reveal());

        $delegate->process(Argument::cetera())->shouldNotHaveBeenCalled();
    }

    protected function setUp()
    {
        parent::setUp();

        $this->commandBus = $this->prophesize(CommandBus::class);
        $this->middleware = new CreateGameController($this->commandBus->reveal());
    }

    private function delegate(): DelegateInterface
    {
        return $this->prophesize(DelegateInterface::class)->reveal();
    }

    private function validRequest(): ServerRequestInterface
    {
        return (new ServerRequest())
            ->withMethod('POST')
            ->withParsedBody([
                'playerOnTurnName' => 'Bart',
                'playerWaitingName' => 'Homer',
                'hitPointsPerPlayer' => 20,
                'movePointsPerTurn' => 10,
            ]);
    }
}