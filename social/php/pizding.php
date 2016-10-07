<?php

    $arr = array('gazlowe',
'illidan',
'malfurion',
'murky',
'sergeant-hammer',
'zeratul',
'abathur',
'diablo',
'li-li',
'muradin',
'raynor',
'sonya',
'tyrande',
'tyrael',
'arthas',
'elite-tauren-chieftain',
'kerrigan',
'nova',
'rehgar',
'tassadar',
'uther',
'valla',
'zagara',
'brightwing',
'falstad',
'nazeebo',
'stitches',
'tychus',
'chen');
    
    for ($index = 0; $index < count($arr); $index++) {
       $fp= fopen('http://www.heroesfire.com/images/wikibase/article/'.$arr[$index].'.png', 'r');
       $file = fopen($arr[$index].'.png', 'w+');
       stream_copy_to_stream($fp, $file);
    }
    
?>
