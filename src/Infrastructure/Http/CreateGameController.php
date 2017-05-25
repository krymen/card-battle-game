<?php

namespace CardBattleGame\Infrastructure\Http;

use CardBattleGame\Application\Command\CreateGame;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Prooph\ServiceBus\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class CreateGameController implements MiddlewareInterface
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        $body = $request->getParsedBody();

        $this->commandBus->dispatch(new CreateGame(
            $body['playerOnTurnName'],
            $body['playerWaitingName'],
            $body['hitPointsPerPlayer'],
            $body['movePointsPerTurn']
        ));

        return (new Response())
            ->withStatus(202);
    }
}