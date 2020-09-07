<?php

namespace App\Model;

class QuoteModel
{
    public static function getQuote()
    {
        return self::$quote;
    }

    private static $quote = [
        '"Le bonheur est comme un papillon: il vole sans jamais regarder en arrière." ~ Robert Lalonde',
        '"Il ne faut pas attendre d’être parfait pour commencer quelque chose de bien." ~ Abbé Pierre',
        '"Tourne-toi vers le soleil, et l’ombre sera derrière toi !" ~ Proverbe Maori',
        '"Ne mettez jamais la clé de votre bonheur dans la poche de quelqu’un d’autre."',
        '"Aimer, c’est donner rendez-vous au bonheur dans le palais du hasard. ~ Abel Bonnard"',
        '"Le bonheur c’est de continuer à désirer ce qu’on possède." ~ Saint Augustin',
        '"Tous les hommes pensent que le bonheur se trouve au sommet de la montagne alors qu’il réside dans la façon de la gravir." ~ Confucius',
        '"Hier n’existe plus , demain ne viendra peut-être jamais. Il n’y a que le miracle du moment présent, savoure-le. C’est un cadeau !" ~ Marie Stilkind',
        '"C’est votre attitude, bien plus que votre aptitude, qui détermine votre altitude." ~ Zig Ziglar',
        '"Le bonheur vient vers ceux croient en lui." ~ Ali Ibn Abu Talb',
        '"En te levant le matin, rappelle-toi combien précieux est le privilège de vivre, de respirer, d’être heureux." ~ Marc Aurèle',
        '"Je ne veux désormais que collectionner les moments de bonheur." ~ Stendhal',
        '"La joie de vivre est une émotion contagieuse." ~ D. Wynot',
        '"Le plus grand secret du bonheur, c’est d’être bien avec soi." ~ B. Fontenelle',
        '"La joie est pareille à un fleuve: rien n’arrête son cours." ~ Henry Miller',
        '"La joie est dans tout ce qui nous entoure, il suffit de savoir l’extraire." ~ Confucius',
        '"La joie est le soleil des âmes ; elle illumine celui qui la possède et réchauffe tous ceux qui en reçoivent les rayons." ~ Carl Reysz',
        '"Ne te lasse pas de crier ta joie et tu n’entendras plus d’autres cris." ~ Proverbe Touareg',
        '"Pour vivre une vie heureuse, attachez-la à un but et not à des personne ou des choses." ~ Einstein',
        '"Conquérir sa joie vaut mieux que s’abandonner à la tristesse." ~ André Gide',
        '"Apprends à écrire tes blessures dans le sable et graver tes joies dans la pierre."',
        '"La confiance est le plus court chemin vers le bonheur." ~ Aline de Pétigny',
        '"Vivre de rêves ou rêver de vivre… Fais ton choix !" ~ J.F. Roiseux',
        '"Impose ta chance, serre ton bonheur et va vers ton risque." ~ René Char',
        '"Tu ne seras jamais heureux si tu cherches continuellement de quoi est fait le bonheur. Tu ne vivras jamais si tu cherches toujours un sens à la vie." ~ Albert Camus',
        '"Tu n’existes pas pour impressionner le monde. Tu existes pour vivre ta vie d’une façon qui fera ton bonheur." ~ Richard Bach',
        '"Sur les flots, sur les grands chemins, nous poursuivons le bonheur. Mais il est ici, le bonheur." ~ Horace',
        '"La joie de vivre n’est pas un but, c’est un devoir." ~ Louis Pauwels',
        '"Si vous n’êtes pas heureux seul vous ne serez jamais heureux à deux. Le bonheur vient de l’intérieur, pas des autres."',
        '"Les joyeux guérissent toujours." ~ Rabelais',
        '"On ne peut pas tout vivre, alors l’important est de vivre l’essentiel et chacun de nous a son essentiel." ~ Marc Levy',
        '"Il n’est jamais trop tard pour fixer un nouveau but, jamais trop tard pour rêver de nouveaux rêves."',
        '"La joie des autres est une grande part dans la notre." ~ Ernest Renan',
        '"L’espérance d’une joie est presque égale à la joie." ~ William Shakespeare',
        '"Ma joie est à l\'image du printemps, si chaleureuse que des fleurs éclosent dans mes mains." ~ Thich Nhat Hanh',
        '"Je choisis de prendre mon bien-être en urgence au lieu de prendre mon mal en patience."',
        '"Le moment présent a un avantage sur tous les autres : il nous appartient." ~ Charles Caleb Colton',
        '"Sois reconnaissant envers les gens qui te rendent heureux. Ils sont les jardiniers qui font fleurir ton âme." ~ Marcel Proust',
        '"Quand on jette des petits rayons de bonheur dans la vie d’autrui, l’éclat finit toujours par rejaillir sur soi." ~ Louis Fortin',
        '"Il y a deux façon de vivre, l’une en faisant comme si rien n’était un miracle, l’autre en faisant comme si tout était un miracle."',
        '"Si je ne suis pas moi, qui le sera ?" ~ Henry David Thoreau',
        '"Des petits plaisirs aux grandes aspirations, ce qui rend profondément heureux, c’est l\'art de chérir et de se remémorer ce qu’il y a de beau et de bon dans sa vie." ~ Anne van Stappen',
        '"Toute beauté est joie qui demeure." ~ John Keats',
        '"Le plaisir se ramasse, la joie se cueille et le bonheur se cultive." ~ Bouddha',
        '"Le bonheur est la seule chose qui se double si on le partage."',
        '"Peu importe ce que tu décides de faire, assure-toi que cela te rende heureux."',
        '"Le secret du bonheur et le comble de l’art, c’est de vivre comme tout le monde en n’étant comme personne." ~ Simone de Beauvoir',
        '"Le bonheur n’est pas d’avoir ce que l’on désire mais d’apprécier ce que l’on a."',
        '"Le secret du bonheur est la liberté… Et le secret de la liberté est le courage." ~ Thucydides',
        '"Le secret du bonheur est de regarder chaque situation telle qu’elle est plutôt que de la regarder pour ce qu’elle devrait être."',
        '"C’est important de rendre quelqu’un heureux et c’est important de commencer par soi."',
        '"Etre heureux, c’est décider de voir la magie dans votre vie et d\'en créer davantage." ~ David Laroche',
        '"Il faut construire un bonheur instant après instant, comme l’oiseau qui fait son nid."',
        '"J’ai décidé d’être heureux parce que c’est bon pour la santé." ~ Voltaire',
        '"Sois heureux un instant, cet instant c’est ta vie."',
        '"Si tu veux être heureux une heure, bois un verre, si tu veux être heureux un jour, marie-toi ; si tu veux être heureux toute la vie, fais-toi jardinier. ~ Proverbe chinois."',
        '"Il existe deux façon d’être heureux : améliorer notre réalité ou bien ajuster nos attentes."',
        '"Si tu veux vivre heureux ? Voyage avec deux sacs, l’un pour donner, l’autre pour recevoir." ~ Goethe',
        '"Il ne faut pas avoir peur du bonheur, c’est seulement un bon moment à passer."',
        '"Vous savez que vous êtes sur le bon chemin quand vous n’avez plus envie de vous retourner."',
        '"Lorsqu’il n’y a pas d’ennemis à l’intérieur, les ennemis à l’extérieur ne peuvent pas vous atteindre." ~ Proverbe africain.',
    ];
    // https://www.positivia.fr/citations-bonheur-citation-motivation/
}
