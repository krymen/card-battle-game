<?php

namespace CardBattleGame\Tests\Functional\Application;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use CardBattleGame\Application\Command\DealCard;
use CardBattleGame\Application\Command\DealCardHandler;
use CardBattleGame\Tests\Functional\Domain\EventSourcedContextTrait;

final class CardsDealingContext implements Context
{
    use CqrsContextTrait;
    use EventSourcedContextTrait;

    /**
     * @Given player on the move was dealt with card of type :arg1 with value :arg2 and cost of :arg3 MP
     */
    public function playerOnTheMoveWasDealtWithCardOfTypeWithValueAndCostOfMp($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @When card of type :type with value :value HP and cost of :cost MP is dealt for player on turn
     */
    public function cardOfTypeWithValueHpAndCostOfMpIsDealtForPlayerOnTurn($type, $value, $cost)
    {
        $gameRepository = $this->eventSourcedContext->getGameRepository();

        $this->cqrsContext->getCommandRouter()
            ->route(DealCard::class)
            ->to(new DealCardHandler($gameRepository));

        $gameId = $persistedEventStream = $this->eventSourcedContext->getAggregateId();

        $this->cqrsContext->getCommandBus()->dispatch(
            new DealCard($gameId, $type, $value, $cost)
        );
    }
}
