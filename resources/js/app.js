require('jquery');
require('bootstrap');

window.switchTo = function(e, id)
{
    let target = e.target;

    if ('src' in target) {
        let src = target.src;

        if (src.search('back') !== -1) {
            src = src.replace('back', 'front');
        } else {
            src = src.replace('front', 'back');
        }

        let image = document.getElementById(id);

        image.src = src;
    }
}
