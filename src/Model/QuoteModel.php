<?php

namespace App\Model;

class QuoteModel
{
    public static function getQuote()
    {
        return self::$quote;
    }

    private static $quote = [
        'Le bonheur est comme un papillon: il vole sans jamais regarder en arrière. ~ Robert Lalonde',
        'Il ne faut pas attendre d’être parfait pour commencer quelque chose de bien ~ Abbé Pierre',
        'Tourne-toi vers le soleil, et l’ombre sera derrière toi! ~ Proverbe Maori',
        'Ne mettez jamais la clé de votre bonheur dans la poche de quelqu’un d’autre.',
        'Aimer, c’est donner rendez-vous au bonheur dans le palais du hasard. ~ Abel Bonnard',
        'Le bonheur c’est de continuer à désirer ce qu’on possède. ~ Saint Augustin',
        'Tous les hommes pensent que le bonheur se trouve au sommet de la montagne alors qu’il réside dans la façon de la gravir. ~ Confucius',
        'Hier n’existe plus , demain ne viendra peut-être jamais. Il n’y a que le miracle du moment présent, savoure-le. C’est un cadeau! ~ Marie Stilkind',
        'C’est votre attitude, bien plus que votre aptitude, qui détermine votre altitude. ~ Zig Ziglar',
    ];
    // https://www.positivia.fr/citations-bonheur-citation-motivation/
}
