<?php

namespace Chess\Variant\Chess960;

use Chess\Variant\Classical\PGN\AN\Color;
use Chess\Variant\Classical\PGN\AN\Piece;
use Chess\Variant\Chess960\Rule\CastlingRule;
use Chess\Variant\Chess960\StartPosition;
use Chess\Variant\Classical\Piece\P;
use Chess\Variant\Classical\Piece\RType;

class StartPieces
{
    private array $startPos;

    private array $castlingRule;

    private array $startPieces;

    private array $size;

    public function __construct(array $startPos, array $castlingRule)
    {
        $this->startPos = $startPos;
        $this->castlingRule = $castlingRule;
        $this->startPieces = [];
        $this->size = [
            'files' => 8,
            'ranks' => 8,
        ];
    }

    public function create()
    {
        $longCastlingRook = null;
        foreach ($this->startPos as $key => $val) {
            $wSq = chr(97+$key).'1';
            $bSq = chr(97+$key).'8';
            $className = "\\Chess\\Variant\\Classical\\Piece\\{$val}";
            if ($val === Piece::K) {
                $this->startPieces[] =  new $className(Color::W, $wSq, $this->castlingRule);
                $this->startPieces[] =  new $className(Color::B, $bSq, $this->castlingRule);
            } elseif ($val !== Piece::R) {
                $this->startPieces[] =  new $className(Color::W, $wSq);
                $this->startPieces[] =  new $className(Color::B, $bSq);
            } elseif (!$longCastlingRook) {
                $this->startPieces[] =  new $className(Color::W, $wSq, RType::CASTLE_LONG);
                $this->startPieces[] =  new $className(Color::B, $bSq, RType::CASTLE_LONG);
                $longCastlingRook = $this->startPos[$key];
            } else {
                $this->startPieces[] =  new $className(Color::W, $wSq, RType::CASTLE_SHORT);
                $this->startPieces[] =  new $className(Color::B, $bSq, RType::CASTLE_SHORT);
            }
        }
        $this->startPieces[] = new P(Color::W, 'a2', $this->size);
        $this->startPieces[] = new P(Color::W, 'b2', $this->size);
        $this->startPieces[] = new P(Color::W, 'c2', $this->size);
        $this->startPieces[] = new P(Color::W, 'd2', $this->size);
        $this->startPieces[] = new P(Color::W, 'e2', $this->size);
        $this->startPieces[] = new P(Color::W, 'f2', $this->size);
        $this->startPieces[] = new P(Color::W, 'g2', $this->size);
        $this->startPieces[] = new P(Color::W, 'h2', $this->size);
        $this->startPieces[] = new P(Color::B, 'a7', $this->size);
        $this->startPieces[] = new P(Color::B, 'b7', $this->size);
        $this->startPieces[] = new P(Color::B, 'c7', $this->size);
        $this->startPieces[] = new P(Color::B, 'd7', $this->size);
        $this->startPieces[] = new P(Color::B, 'e7', $this->size);
        $this->startPieces[] = new P(Color::B, 'f7', $this->size);
        $this->startPieces[] = new P(Color::B, 'g7', $this->size);
        $this->startPieces[] = new P(Color::B, 'h7', $this->size);

        return $this->startPieces;
    }
}
