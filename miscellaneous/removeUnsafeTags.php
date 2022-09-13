function strip_unsafe($string, $img=false)
{
    // Unsafe HTML tags that members may abuse
    $unsafe=array(
    '/<iframe(.*?)<\/iframe>/is',
    '/<title(.*?)<\/title>/is',
    '/<pre(.*?)<\/pre>/is',
    '/<frame(.*?)<\/frame>/is',
    '/<frameset(.*?)<\/frameset>/is',
    '/<object(.*?)<\/object>/is',
    '/<script(.*?)<\/script>/is',
    '/<embed(.*?)<\/embed>/is',
    '/<applet(.*?)<\/applet>/is',
    '/<meta(.*?)>/is',
    '/<!doctype(.*?)>/is',
    '/<link(.*?)>/is',
    '/<body(.*?)>/is',
    '/<\/body>/is',
    '/<head(.*?)>/is',
    '/<\/head>/is',
    '/<html(.*?)>/is',
    '/<\/html>/is'
    '/on*[a-z]+=".*?"/is',
    );

    // Remove graphic too if the user wants
    if ($img==true)
    {
        $unsafe[]='/<img(.*?)>/is';
    }

    // Remove these tags and all parameters within them
    $string=preg_replace($unsafe, "", $string);

    return $string;
}
