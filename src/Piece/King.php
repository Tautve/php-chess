<?php

namespace Chess\Piece;

use Chess\Castling\Rule as CastlingRule;
use Chess\PGN\Move;
use Chess\PGN\Symbol;
use Chess\Piece\AbstractPiece;
use Chess\Piece\Rook;
use Chess\Piece\Bishop;
use Chess\Piece\Type\RookType;

/**
 * King class.
 *
 * @author Jordi Bassagañas
 * @license GPL
 */
class King extends AbstractPiece
{
    /**
     * @var \Chess\Piece\Rook
     */
    private $rook;

    /**
     * @var \Chess\Piece\Bishop
     */
    private $bishop;

    /**
     * Constructor.
     *
     * @param string $color
     * @param string $square
     */
    public function __construct(string $color, string $square)
    {
        parent::__construct($color, $square, Symbol::KING);

        $this->rook = new Rook($color, $square, RookType::FAKED);
        $this->bishop = new Bishop($color, $square);

        $this->scope();
    }

    protected function moveCastlingLong()
    {
        $rule = CastlingRule::color($this->getColor())[Symbol::KING][Symbol::CASTLING_LONG];
        if (!$this->boardStatus->castling[$this->getColor()]['castled']) {
            if ($this->boardStatus->castling[$this->getColor()][Symbol::CASTLING_LONG]) {
                if (
                    in_array($rule['squares']['b'], $this->boardStatus->squares->free) &&
                    in_array($rule['squares']['c'], $this->boardStatus->squares->free) &&
                    in_array($rule['squares']['d'], $this->boardStatus->squares->free) &&
                    !in_array($rule['squares']['b'], $this->space->{$this->getOppColor()}) &&
                    !in_array($rule['squares']['c'], $this->space->{$this->getOppColor()}) &&
                    !in_array($rule['squares']['d'], $this->space->{$this->getOppColor()})
                ) {
                    return $rule['position']['next'];
                }
            }
        }

        return null;
    }

    protected function moveCastlingShort()
    {
        $rule = CastlingRule::color($this->getColor())[Symbol::KING][Symbol::CASTLING_SHORT];
        if (!$this->boardStatus->castling[$this->getColor()]['castled']) {
            if ($this->boardStatus->castling[$this->getColor()][Symbol::CASTLING_SHORT]) {
                if (
                    in_array($rule['squares']['f'], $this->boardStatus->squares->free) &&
                    in_array($rule['squares']['g'], $this->boardStatus->squares->free) &&
                    !in_array($rule['squares']['f'], $this->space->{$this->getOppColor()}) &&
                    !in_array($rule['squares']['g'], $this->space->{$this->getOppColor()})
                ) {
                    return $rule['position']['next'];
                }
            }
        }

        return null;
    }

    protected function movesCaptures()
    {
        $movesCaptures = array_intersect(
            array_values((array)$this->scope),
            $this->boardStatus->squares->used->{$this->getOppColor()}
        );

        return array_diff($movesCaptures, $this->defense->{$this->getOppColor()});
    }

    protected function movesKing()
    {
        $movesKing = array_intersect(array_values((array)$this->scope), $this->boardStatus->squares->free);

        return array_diff($movesKing, $this->space->{$this->getOppColor()});
    }

    /**
     * Gets the king's castling rook.
     *
     * @param array $pieces
     * @return mixed \Chess\Piece\Rook|null
     */
    public function getCastlingRook(array $pieces)
    {
        $rule = CastlingRule::color($this->getColor())[Symbol::ROOK];
        foreach ($pieces as $piece) {
            if (
                $piece->getIdentity() === Symbol::ROOK &&
                $piece->getPosition() === $rule[rtrim($this->getMove()->pgn, '+')]['position']['current']
            ) {
                return $piece;
            }
        }

        return null;
    }

    /**
     * Calculates the king's scope.
     */
    protected function scope(): void
    {
        $scope =  array_merge(
            (array) $this->rook->getScope(),
            (array) $this->bishop->getScope()
        );

        foreach($scope as $key => $val) {
            $scope[$key] = !empty($val[0]) ? $val[0] : null;
        }

        $this->scope = (object) array_filter(array_unique($scope));
    }

    /**
     * Gets the king's legal moves.
     *
     * @return array
     */
    public function getLegalMoves(): array
    {
        $legalMoves = array_merge(
            $this->movesKing(),
            $this->movesCaptures(),
            [$this->moveCastlingLong()],
            [$this->moveCastlingShort()]
        );

        return array_filter($legalMoves);
    }

    public function getDefendedSquares(): array
    {
        $squares = [];
        foreach ($this->scope as $square) {
            if (in_array($square, $this->boardStatus->squares->used->{$this->getColor()})) {
                $squares[] = $square;
            }
        }

        return $squares;
    }
}
